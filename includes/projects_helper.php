<?php
/**
 * RiTiVerse — Projects Data & Case Study Helper Layer
 * Provides robust DB retrieval, schema auto-migration, adjacent project navigation, and SEO auto-sync.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

/**
 * Ensure all new case-study columns exist in the database table
 */
function ensure_projects_table_schema($db) {
    if (!$db) return;
    try {
        $cols = $db->query("SHOW COLUMNS FROM projects")->fetchAll(PDO::FETCH_COLUMN);
        if (!$cols) return;

        if (!in_array('client_name', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN client_name VARCHAR(150) NOT NULL DEFAULT '' AFTER title");
        }
        if (!in_array('client_industry', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN client_industry VARCHAR(100) NOT NULL DEFAULT '' AFTER client_name");
        }
        if (!in_array('project_duration', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN project_duration VARCHAR(60) NOT NULL DEFAULT '' AFTER client_industry");
        }
        if (!in_array('challenge', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN challenge TEXT NULL AFTER description");
        }
        if (!in_array('solution', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN solution TEXT NULL AFTER challenge");
        }
        if (!in_array('key_features', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN key_features TEXT NULL AFTER solution");
        }
        if (!in_array('impact_summary', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN impact_summary TEXT NULL AFTER key_features");
        }
        if (!in_array('image_url', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN image_url VARCHAR(255) NOT NULL DEFAULT '' AFTER impact_summary");
        }
        if (!in_array('gallery_images', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN gallery_images TEXT NULL AFTER image_url");
        }
        if (!in_array('live_url', $cols)) {
            $db->exec("ALTER TABLE projects ADD COLUMN live_url VARCHAR(255) NOT NULL DEFAULT '' AFTER gallery_images");
        }
    } catch (Exception $e) {
        // Silently continue in production if already altered or restricted
    }
}

/**
 * Fetch all projects from database
 */
function get_all_projects($featured_only = false) {
    $db = get_db();
    if (!$db) return [];

    ensure_projects_table_schema($db);

    try {
        $sql = "SELECT * FROM projects";
        if ($featured_only) {
            $sql .= " WHERE is_featured = 1";
        }
        $sql .= " ORDER BY display_order ASC, id ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

/**
 * Get project by slug or numeric ID
 */
function get_project_by_slug_or_id($slug_or_id) {
    $db = get_db();
    if (!$db) return null;

    ensure_projects_table_schema($db);

    try {
        if (is_numeric($slug_or_id)) {
            $stmt = $db->prepare("SELECT * FROM projects WHERE id = ? LIMIT 1");
            $stmt->execute([(int)$slug_or_id]);
        } else {
            $stmt = $db->prepare("SELECT * FROM projects WHERE slug = ? LIMIT 1");
            $stmt->execute([trim($slug_or_id)]);
            if ($stmt->rowCount() === 0 && is_numeric($slug_or_id)) {
                $stmt = $db->prepare("SELECT * FROM projects WHERE id = ? LIMIT 1");
                $stmt->execute([(int)$slug_or_id]);
            }
        }
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Get adjacent (previous and next) featured projects for navigation
 */
function get_adjacent_projects($current_id) {
    $db = get_db();
    $result = ['prev' => null, 'next' => null];
    if (!$db) return $result;

    try {
        // Previous project (smaller order or id)
        $prev_stmt = $db->prepare("SELECT id, title, slug, category, image_url FROM projects WHERE is_featured = 1 AND id < ? ORDER BY display_order DESC, id DESC LIMIT 1");
        $prev_stmt->execute([(int)$current_id]);
        $result['prev'] = $prev_stmt->fetch(PDO::FETCH_ASSOC) ?: null;

        // Next project (greater order or id)
        $next_stmt = $db->prepare("SELECT id, title, slug, category, image_url FROM projects WHERE is_featured = 1 AND id > ? ORDER BY display_order ASC, id ASC LIMIT 1");
        $next_stmt->execute([(int)$current_id]);
        $result['next'] = $next_stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (Exception $e) {
        // Silently continue
    }

    return $result;
}

/**
 * Synchronize featured project case studies into sitemap.xml and llms.txt
 */
function sync_projects_seo($db = null) {
    if (!$db) $db = get_db();
    if (!$db) return false;

    try {
        $stmt = $db->query("SELECT title, slug, category, description, image_url, updated_at, created_at FROM projects WHERE is_featured = 1 ORDER BY display_order ASC, id ASC");
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $root_dir = dirname(__DIR__);
        $sitemap_path = $root_dir . '/sitemap.xml';
        $today = date('Y-m-d');

        // 1. Update sitemap.xml with /project/{slug} entries
        if (file_exists($sitemap_path) && is_writable($sitemap_path)) {
            $xml = file_get_contents($sitemap_path);
            
            // Remove existing project detail URLs
            $xml = preg_replace('/\s*<url>\s*<loc>https:\/\/ritiverse\.in\/project\/[^<]+<\/loc>.*?<\/url>/s', '', $xml);

            // Construct new project URLs
            $project_nodes = '';
            foreach ($projects as $p) {
                if (empty($p['slug'])) continue;
                $p_url = 'https://ritiverse.in/project/' . htmlspecialchars($p['slug'], ENT_QUOTES, 'UTF-8');
                $p_title = htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8');
                $p_desc = htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8');
                $p_img = !empty($p['image_url']) ? 'https://ritiverse.in/' . ltrim($p['image_url'], '/') : 'https://ritiverse.in/assets/card_web_apps.webp';
                $mod_date = !empty($p['updated_at']) ? substr($p['updated_at'], 0, 10) : (!empty($p['created_at']) ? substr($p['created_at'], 0, 10) : $today);

                $project_nodes .= "  <url>\n";
                $project_nodes .= "    <loc>{$p_url}</loc>\n";
                $project_nodes .= "    <lastmod>{$mod_date}</lastmod>\n";
                $project_nodes .= "    <changefreq>monthly</changefreq>\n";
                $project_nodes .= "    <priority>0.85</priority>\n";
                $project_nodes .= "    <image:image>\n";
                $project_nodes .= "      <image:loc>{$p_img}</image:loc>\n";
                $project_nodes .= "      <image:title>{$p_title} — Case Study</image:title>\n";
                if (!empty($p_desc)) {
                    $project_nodes .= "      <image:caption>{$p_desc}</image:caption>\n";
                }
                $project_nodes .= "    </image:image>\n";
                $project_nodes .= "  </url>\n";
            }

            // Insert before </urlset>
            if (!empty($project_nodes)) {
                $xml = preg_replace('/<\/urlset>/', rtrim($project_nodes) . "\n</urlset>", $xml);
                file_put_contents($sitemap_path, $xml);
            }
        }

        // 2. Update llms.txt
        $llms_path = $root_dir . '/llms.txt';
        if (file_exists($llms_path) && is_writable($llms_path)) {
            $llms = file_get_contents($llms_path);
            
            // Clean out old case study list under Section
            $case_studies_md = "";
            if (!empty($projects)) {
                $case_studies_md .= "\n### Published Client Case Studies\n\n";
                foreach ($projects as $p) {
                    if (empty($p['slug'])) continue;
                    $cat = strtoupper($p['category'] ?? 'WEB');
                    $case_studies_md .= "- [{$p['title']} ({$cat})](https://ritiverse.in/project/{$p['slug']}): " . trim(preg_replace('/\s+/', ' ', $p['description'])) . "\n";
                }
            }

            // Replace or append into "Project Case Studies & Delivery Standards" section
            $pattern = '/(## Project Case Studies & Delivery Standards\s*\n)(.*?)(?=\n## [A-Z])/s';
            if (preg_match($pattern, $llms, $matches)) {
                $section_content = preg_replace('/\n### Published Client Case Studies\n.*?(?=\n- \*\*|\n$)/s', '', $matches[2]);
                $replacement = "$1" . trim($section_content) . "\n" . $case_studies_md . "\n";
                $llms = preg_replace($pattern, $replacement, $llms);
                file_put_contents($llms_path, $llms);
            }
        }

        return true;
    } catch (Exception $e) {
        return false;
    }
}

