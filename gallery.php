<?php
/**
 * 3D Infinite Gallery (PHP + vanilla Three.js)
 * Put this file anywhere on your site and point $imageDir at your existing images.
 */

// ---- CONFIG -------------------------------------------------------------
$imageDir   = __DIR__ . '/images/gallery';   // filesystem path to your images
$imageUrl   = 'images/gallery';              // same folder as a URL (relative to this page)
$extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif'];
$title      = 'Shadway';
$hint1      = 'Use mouse wheel, arrow keys, or touch to navigate';
$hint2      = 'Auto-play resumes after 3 seconds of inactivity';

$settings = [
    'speed'        => 1.2,
    'visibleCount' => 12,
    'depthRange'   => 50,
    'fadeSettings' => [
        'fadeIn'  => ['start' => 0.05, 'end' => 0.25],
        'fadeOut' => ['start' => 0.40, 'end' => 0.43],
    ],
    'blurSettings' => [
        'blurIn'  => ['start' => 0.0, 'end' => 0.1],
        'blurOut' => ['start' => 0.40, 'end' => 0.43],
        'maxBlur' => 8.0,
    ],
];
// -------------------------------------------------------------------------

$images = [];
if (is_dir($imageDir)) {
    $files = scandir($imageDir, SCANDIR_SORT_ASCENDING);
    natcasesort($files);
    foreach ($files as $file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $extensions, true)) {
            $alt = ucwords(str_replace(['-', '_'], ' ', pathinfo($file, PATHINFO_FILENAME)));
            $images[] = [
                'src' => rtrim($imageUrl, '/') . '/' . rawurlencode($file),
                'alt' => $alt,
            ];
        }
    }
}

$config = $settings + ['images' => $images];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?> – Gallery</title>
    <link rel="stylesheet" href="css/gallery.css">
</head>
<body>
<main class="gallery-page">

    <section
        id="gallery3d"
        class="gallery3d"
        data-config='<?= htmlspecialchars(json_encode($config, JSON_UNESCAPED_SLASHES), ENT_QUOTES) ?>'
    >
        <div class="gallery3d__canvas" id="gallery3dCanvas"></div>

        <!-- Shown only when WebGL is unavailable -->
        <div class="gallery3d__fallback">
            <p>WebGL not supported. Showing image list:</p>
            <div class="gallery3d__grid">
                <?php foreach ($images as $img): ?>
                    <img src="<?= htmlspecialchars($img['src']) ?>"
                         alt="<?= htmlspecialchars($img['alt']) ?>"
                         loading="lazy">
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!$images): ?>
            <p class="gallery3d__empty">No images found in <code><?= htmlspecialchars($imageUrl) ?></code></p>
        <?php endif; ?>
    </section>

    <div class="gallery-title">
        <h1><span><?= htmlspecialchars($title) ?></span></h1>
    </div>

    <div class="gallery-hint">
        <p><?= htmlspecialchars($hint1) ?></p>
        <p class="gallery-hint__dim"><?= htmlspecialchars($hint2) ?></p>
    </div>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="js/gallery.js"></script>
</body>
</html>
