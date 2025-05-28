<?php
require_once 'header.php';
require_once 'my-functions.php';
require_once 'database.php';

$products = pullTableProducts();

?>

<!--Affichage-->
<?php
foreach ($products as $item) {
?>
    <div class="item rounded shadow">
        <h3><?= $item["name"] ?></h1>
            <?php if ($item["discount"]) : ?>
                <p class="solde"><?= formatPrice($item["price"]) ?> TTC 🔥</p>
            <?php else : ?>
                <p>Pas de promotion sur cette article 🥲</p>
            <?php endif; ?>
            <p>Prix TTC : <?= formatPrice(discountedPrice((int)$item["price"], (int)$item["discount"])) ?></p>
            <p>Prix HT : <?= priceExcludingTVA(discountedPrice((int)$item["price"], (int)$item["discount"])) ?></p>
            <div class="containerImgItem">
                <img class="imgItem " src=<?= $item["img_url"] ?> alt="image ecouteur" />
            </div>
            <div class="choixQuantite">
            <label for=<?= $item["name"] ?>>Quantité :</label>
            <input type="number" id="quantite-<?= strtolower($item['name']) ?>" name="quantite[<?= strtolower($item['name']) ?>]" value="0" min="0" max="100" />
            <button type="submit" class="btn btn-success">COMMANDER</button>
            </div>
            <input type="hidden" id="price-<?= strtolower($item['name']) ?>" name="price[<?= strtolower($item['name']) ?>]" value=<?= $item["price"] ?> />
            <input type="hidden" id="price-<?= strtolower($item['name']) ?>" name="discount[<?= strtolower($item['name']) ?>]" value=<?= $item["discount"] ?> />
            <input type="hidden" id="price-<?= strtolower($item['name']) ?>" name="weight[<?= strtolower($item['name']) ?>]" value=<?= $item["weight"] ?> />
            

    </div>
<?php
}
?>