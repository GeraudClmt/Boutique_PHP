<?php
$nom = "Piolet";
$prix = 150;
$url = "https://skitour.fr/matos/photos/5508.jpg";

?>

<div class="item">
    <h1><?php echo $nom ?></h1>
    <p><?php echo $prix ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $url ?> alt="image ecouteur" />
    </div>

</div>