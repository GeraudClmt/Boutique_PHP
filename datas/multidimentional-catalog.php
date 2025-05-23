<?php
session_start();
require_once 'header.php';
require_once 'my-functions.php';

$products = [
    "corde" => [
        "name" => "Corde",
        "price" => 12099,
        "weight" => 3000,
        "discount" => 10,
        "picture_url" => "https://contents.mediadecathlon.com/p2615071/k\$b2f1933c71b675afddb50d80df8b4a9b/sq/corde-descalade-95-mm-x-80-m-vertika.jpg?format=auto&f=800x0"
    ],
    "piolet" => [
        "name" => "Piolet",
        "price" => 15099,
        "weight" => 500,
        "discount" => 5,
        "picture_url" => "https://skitour.fr/matos/photos/5508.jpg"
    ],
    "crampons" => [
        "name" => "Crampons",
        "price" => 16099,
        "weight" => 600,
        "discount" => null,
        "picture_url" => "https://www.montagnes-magazine.com/media/MATOS/2021/novembre/petzl.jpeg"
    ],
    "cordes" => [
        "name" => "Cordes",
        "price" => 12990,
        "weight" => 2000,
        "discount" => 10,
        "picture_url" => "https://www.montania-sport.com/46348-thickbox_default/corde-a-simple-escalade-80m-karma-98mm-solid-orange-beal.jpg"
    ],
    "casque" => [
        "name" => "Casque",
        "price" => 8099,
        "weight" => 200,
        "discount" => null,
        "picture_url" => "https://glisshop-glisshop-fr-storage.omn.proximis.com/Imagestorage/imagesSynchro/735/735/be2c82cdff7da0ca122e9a1565fe7d0d73cc7b64_H25PETZESC4453545_0.jpeg"
    ],
    "gourde" => [
        "name" => "Gourde",
        "price" => 2000,
        "weight" => 100,
        "discount" => 2,
        "picture_url" => "https://shop-ta-gourde.com/cdn/shop/products/gourde_motif_montagne_1200x1200.jpg?v=1576860033"
    ]
];

?>

<!--Affichage-->
<?php
foreach ($products as $item) {
?>
    <div class="item">
        <h3><?= $item["name"] ?></h1>
            <?php if ($item["discount"]) : ?>
                <p class="solde"><?= formatPrice($item["price"]) ?> TTC 🔥</p>
            <?php else : ?>
                <p>Pas de promotion sur cette article 🥲</p>
            <?php endif; ?>
            <p>Prix TTC : <?= formatPrice(discountedPrice((int)$item["price"], (int)$item["discount"])) ?></p>
            <p>Prix HT : <?= priceExcludingTVA(discountedPrice((int)$item["price"], (int)$item["discount"])) ?></p>
            <div class="containerImgItem">
                <img class="imgItem" src=<?= $item["picture_url"] ?> alt="image ecouteur" />
            </div>
            <div class="choixQuantite">
            <label for=<?= $item["name"] ?>>Quantité :</label>
            <input type="number" id="quantite-<?= strtolower($item['name']) ?>" name="quantite[<?= strtolower($item['name']) ?>]" value="0" min="0" max="100" />
            <button type="submit" class="btnCommander">COMMANDER</button>
            </div>
            <input type="hidden" id="price-<?= strtolower($item['name']) ?>" name="price[<?= strtolower($item['name']) ?>]" value=<?= $item["price"] ?> />
            <input type="hidden" id="price-<?= strtolower($item['name']) ?>" name="discount[<?= strtolower($item['name']) ?>]" value=<?= $item["discount"] ?> />
            <input type="hidden" id="price-<?= strtolower($item['name']) ?>" name="weight[<?= strtolower($item['name']) ?>]" value=<?= $item["weight"] ?> />
            

    </div>
<?php
}
?>