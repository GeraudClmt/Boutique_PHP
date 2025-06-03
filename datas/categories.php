<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once "database.php";
$listeCategories = pullCategories();

if(isset($_GET["categorie"])){
    $_SESSION["categories"] = $_GET["categorie"];
}else{
    $_SESSION["categories"] = 0;
}
?>

<div class="row">
    <form method="get" class="col-3  d-flex align-items-center flex-column">
            <h3>Toutes les categories</h3>
            <input type="hidden" name="categorie" value="0"/>
            <button type="submit" class="imgItem btn btn-light">
                <img class="rounded shadow h-100 w-100 object-fit-cover" src="https://www.trace-ta-route.com/wp-content/uploads/2022/07/Alpinisme-0-Materiel-Blog-Outdoor-Trace-les-Cimes-1050x700.jpg" alt="image categories" />
            </button>
    </form>
    <?php
    foreach ($listeCategories as $categories){ ?>
        <form method="get" class="col-3  d-flex align-items-center flex-column">
            <h3><?= $categories["name"] ?></h3>
            <input type="hidden" name="categorie" value="<?= $categories["id"]  ?>"/>
            <button type="submit" class="imgItem btn btn-light">
                <img class="rounded shadow h-100 w-100 object-fit-cover" src="<?= $categories["image_url"] ?>" alt="image categories" />
            </button>
    </form>
    <?php
    }
    ?>
</div>