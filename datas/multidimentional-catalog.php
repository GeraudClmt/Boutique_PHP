<?php
$products = [
    "corde" => [
        "name" => "Corde d'escalade",
        "price" => 120,
        "weight" => 3000,
        "discount" => 10,
        "picture_url" => "https://contents.mediadecathlon.com/p2615071/k$b2f1933c71b675afddb50d80df8b4a9b/sq/corde-descalade-95-mm-x-80-m-vertika.jpg?format=auto&f=800x0"
    ],
    "piolet" => [
        "name" => "Piolet",
        "price" => 150,
        "weight" => 500,
        "discount" => 5,
        "picture_url" => "https://skitour.fr/matos/photos/5508.jpg"
    ],
    "crampons" => [
        "name" => "Crampons",
        "price" => 160,
        "weight" => 600,
        "discount" => null,
        "picture_url" => "https://www.montagnes-magazine.com/media/MATOS/2021/novembre/petzl.jpeg"
    ]
];
?>


<div class="item">
    <h3><?php echo $products["corde"]["name"] ?></h1>
    <p>Prix : <?php echo $products["corde"]["prix"] ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $products["corde"]["picture_url"] ?> alt="image ecouteur" />
    </div>
</div>
<div class="item">
    <h3><?php echo $products["piolet"]["name"] ?></h1>
    <p>Prix : <?php echo $products["piolet"]["prix"] ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $products["piolet"]["picture_url"] ?> alt="image ecouteur" />
    </div>
</div>
<div class="item">
    <h3><?php echo $products["crampons"]["name"] ?></h1>
    <p>Prix : <?php echo $products["crampons"]["prix"] ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $products["crampons"]["picture_url"]  ?> alt="image ecouteur" />
    </div>
</div>