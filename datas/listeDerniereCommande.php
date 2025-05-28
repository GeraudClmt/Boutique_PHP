<?php
require_once 'database.php';

$listeCommande = pullLastOrders();
?>



<div class="alert alert-dark">
    <h2>Les dernières personnes à avoir commandé :</h2>
    <?php
    foreach ($listeCommande as $commande){ ?>
        <div>
            <h3><?= $commande["first_name"] . " " . $commande["last_name"]?></h3>
            <p>Nombre de commande <?= $commande["nb_Orders"] ?></p>
        </div>
    <?php
    }
    ?>
</div>
