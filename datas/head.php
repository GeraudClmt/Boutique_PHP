<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function head(string $page, string $description){
    return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="$description" />
    <link rel="stylesheet" href="styles/style.css"/>
    <title>$page</title>
</head>
HTML; 
    }
?>

