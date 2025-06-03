<?php
require_once './datas/head.php';

echo head("Boutique", "Des milliers d'articles sont displonible.");
?>

<body>
    <?php require_once 'header.php' ?>
    <main class="container-fluid">
        <?php require_once 'datas/categories.php' ?>
        <?php //require_once 'datas/catalog-with-keys.php' ?>
        <?php require_once 'datas/multidimentional-catalog.php' ?>
    </main>
    <?php require_once 'footer.php' ?>
</body>

</html>