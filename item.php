<?php
$nom = "Ecouteur";
$prix = 12;
$url = "https://boutique.iservices.fr/7362/ecouteurs-sans-fil-music-pods-3eme-gen.jpg";
?>

<div class="item">
    <h1><?php echo $nom ?></h1>
    <p><?php echo $prix ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $url ?> alt="image ecouteur" />
    </div>

</div>