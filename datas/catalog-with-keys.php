<?php
$corde = [
    "name" => "Corde d'escalade",
    "price" => 120,
    "weight" => 3,
    "discount" => 10,
    "picture_url" => "https://contents.mediadecathlon.com/p2615071/k$b2f1933c71b675afddb50d80df8b4a9b/sq/corde-descalade-95-mm-x-80-m-vertika.jpg?format=auto&f=800x0"
];
$piolet = [
    "name" => "Piolet",
    "price" => 150,
    "weight" => 1,
    "discount" => 5,
    "picture_url" => "https://skitour.fr/matos/photos/5508.jpg"
];
$crampons = [
    "name" => "Crampons",
    "price" => 160,
    "weight" => 1,
    "discount" => 3,
    "picture_url" => "https://www.montagnes-magazine.com/media/MATOS/2021/novembre/petzl.jpeg"
];
?>

<div class="item">
    <h3><?php echo $corde["name"] ?></h1>
    <p>Prix : <?= $corde["price"] ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $corde["picture_url"] ?> alt="image ecouteur" />
    </div>
</div>
<div class="item">
    <h3><?php echo $piolet["name"] ?></h1>
    <p>Prix : <?= $piolet["price"] ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $piolet["picture_url"] ?> alt="image ecouteur" />
    </div>
</div>
<div class="item">
    <h3><?php echo $crampons["name"] ?></h1>
    <p>Prix : <?= $crampons["price"] ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $crampons["picture_url"]  ?> alt="image ecouteur" />
    </div>
</div>