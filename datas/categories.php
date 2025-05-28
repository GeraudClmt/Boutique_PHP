<?php
require_once "database.php";

$listeCategories = pullCategories();

?>

<div class="row">
    <?php
    foreach ($listeCategories as $categories){ ?>
        <div class="col-4  d-flex align-items-center flex-column">
            <h3><?= $categories["name"] ?></h3>
            <div class="imgItem">
                <img class="rounded shadow h-100 w-100 object-fit-cover" src="<?= $categories["image_url"] ?>" alt="image categories" />
            </div>
        </div>
    <?php
    }
    ?>
</div>