<?php
/**
 * RiTiVerse — Dynamic Service Route Handler
 * Dispatches to service-detail.php based on ?slug= or ?id= query parameters
 */
$service_slug = $_GET['slug'] ?? ($_GET['id'] ?? 'website-development');
require_once __DIR__ . '/service-detail.php';
