<?php
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

