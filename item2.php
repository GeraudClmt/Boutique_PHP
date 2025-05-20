<?php
$nom = "Campons";
$prix = 160;
$url = "https://www.montagnes-magazine.com/media/MATOS/2021/novembre/petzl.jpeg";

?>

<div class="item">
    <h1><?php echo $nom ?></h1>
    <p><?php echo $prix ?>$</p>
    <div class="containerImgItem">
        <img class="imgItem" src=<?php echo $url ?> alt="image ecouteur" />
    </div>

</div>