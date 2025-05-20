<?php
require_once 'header.php';
require_once 'my-functions.php';

$products = [
    "corde" => [
        "name" => "Corde d'escalade",
        "price" => 12099,
        "weight" => 3000,
        "discount" => 10,
        "picture_url" => "https://contents.mediadecathlon.com/p2615071/k$b2f1933c71b675afddb50d80df8b4a9b/sq/corde-descalade-95-mm-x-80-m-vertika.jpg?format=auto&f=800x0"
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
    ]
];
?>

<!--Affichage-->
<?php
foreach($products as $item){ 
?>
<div class="item">
    <h3><?= $item["name"] ?></h1>
    <?php if($item["discount"]) :?>
        <h3 class="solde">Solde</h3>
    <?php endif; ?>
    <p>Prix TTC : <?= formatPrice(discountedPrice($item["price"], $item["discount"])) ?></p>
    <p>Prix HT : <?= priceExcludingTVA(discountedPrice($item["price"], $item["discount"])) ?></p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?= $item["picture_url"] ?> alt="image ecouteur" />
    </div>
</div>
<?php
}
?>
