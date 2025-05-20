<?php
require_once 'header.php';
$products=["Corde d'escalade", "Piolet", "Campons"];

sort($products);


?>

<!--Affichage-->
<div>
    <h2>Exemple boucle foreach :</h2>
    <?php
    //Avec boucle foreach
    foreach($products as $element){
    ?>
        <h3><?= $element ?></h3>
    <?php
    }
    ?>

    <h2>Exemple boucle for :</h2>
    <?php
    //Avec boucle for
    for($i = 0; $i < count($products); $i++){
    ?>
        <h3><?= $products[$i] ?></h3>
    <?php
    }
    ?>

    <h2>Exemple boucle while :</h2>
    <?php
    //Avec boucle do while
    $compteur = 0;
    do{
    ?>
        <h3><?= $products[$compteur] ?></h3>
    <?php
    $compteur++;
    }while($compteur < count($products));
    ?>

    <h2>Rangé dans l'orde alphabetique :</h2>
    <h3>Le premier élément est : <?= $products[0] ?> </h3>
    <h3>Le dernier élément est : <?= end($products) ?></h3>
</div>
