<?php
require_once 'header.php';
require_once 'my-functions.php';


$corde = [
    "name" => "Corde d'escalade",
    "price" => 12990,
    "weight" => 3,
    "discount" => 10,
    "picture_url" => "https://www.montania-sport.com/46348-thickbox_default/corde-a-simple-escalade-80m-karma-98mm-solid-orange-beal.jpg"
];
$casque = [
    "name" => "Casque",
    "price" => 8099,
    "weight" => 1,
    "discount" => null,
    "picture_url" => "https://glisshop-glisshop-fr-storage.omn.proximis.com/Imagestorage/imagesSynchro/735/735/be2c82cdff7da0ca122e9a1565fe7d0d73cc7b64_H25PETZESC4453545_0.jpeg"
];
$gourde = [
    "name" => "Gourde",
    "price" => 2000,
    "weight" => 1,
    "discount" => 2,
    "picture_url" => "https://shop-ta-gourde.com/cdn/shop/products/gourde_motif_montagne_1200x1200.jpg?v=1576860033"
];
?>

<div class="item">
    <h3><?php echo $corde["name"] ?></h1>
    <?php if($corde["discount"]) :?>
        <p class="solde"><?= formatPrice($corde["price"]) ?> TTC</p>
    <?php endif; ?>
    <p>Prix TTC : <?= formatPrice(discountedPrice($corde["price"], $corde["discount"])) ?></p>
    <p>Prix HT : <?= priceExcludingTVA(discountedPrice($corde["price"], $corde["discount"])) ?></p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $corde["picture_url"] ?> alt="image ecouteur" />
    </div>
</div>
<div class="item">
    <h3><?php echo $casque["name"] ?></h1>
    <?php if($casque["discount"]) :?>
        <p class="solde"><?= formatPrice($casque["price"]) ?> TTC</p>
    <?php endif; ?>
    <p>Prix TTC : <?= formatPrice(discountedPrice($casque["price"], $casque["discount"])) ?></p>
    <p>Prix HT : <?= priceExcludingTVA(discountedPrice($casque["price"], $casque["discount"])) ?></p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $casque["picture_url"] ?> alt="image ecouteur" />
    </div>
</div>
<div class="item">
    <h3><?php echo $gourde["name"] ?></h1>
    <?php if($gourde["discount"]) :?>
        <p class="solde"><?= formatPrice($gourde["price"]) ?> TTC</p>
    <?php endif; ?>
    <p>Prix TTC : <?= formatPrice(discountedPrice($gourde["price"], $gourde["discount"])) ?></p>
    <p>Prix HT : <?= priceExcludingTVA(discountedPrice($gourde["price"], $gourde["discount"])) ?></p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $gourde["picture_url"]  ?> alt="image ecouteur" />
    </div>
</div>