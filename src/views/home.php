<?php


include_once "bootstrap.php";

use Models\Page;

// Helper functions
function redirect_to_root()
{
    header("Location: " . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
}
