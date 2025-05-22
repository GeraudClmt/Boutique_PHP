<?php
require_once 'datas/my-functions.php';

$listeProduitCommande = [];
$prixTotal = 0;
$poidTotal = 0;

$listePrice = $_POST["price"];
$listeQuantite = $_POST["quantite"];
$listeDiscount = $_POST["discount"];
$listePoid = $_POST["weight"];
$livreur = $_POST["livreur"];
$data = $_POST;


if($livreur == null){
    $livreur = "dhl";
}


foreach (array_keys($listePrice) as $item) {
    if (isset($listeQuantite[$item]) && $listeQuantite[$item] != "0") {
        //echo "Element : " . $item . " Quantité : " . $listeQuantite[$item] . " prix : " . $listePrice[$item];

        $listeProduitCommande[$item] = [
            "name" => $item,
            "price" => $listePrice[$item],
            "quantite" => $listeQuantite[$item],
            "prixTotal" => (int) $listePrice[$item] * (int) $listeQuantite[$item],
            "discount" => (int) $listeDiscount[$item],
            "weight" => (int)$listePoid[$item]
        ];
    }
}

foreach (array_keys($listeProduitCommande) as $i) {
    $prixTotal = $prixTotal + $listeProduitCommande[$i]["prixTotal"];
    $poidTotal = $poidTotal + ($listeProduitCommande[$i]["weight"] * $listeProduitCommande[$i]["quantite"]);
}


?>


<?php require_once 'datas/head.php';
echo head("Panier", "Tous les acticles du panier sont ici.");
?>

<body>
    <?php require_once 'header.php' ?>
    <main class="mainPanier">
        <div class="containerPanier">
            <div class="elementPanier">
                <h4>Produit</h4>
                <h4>Prix</h4>
                <h4>Quantité</h4>
                <h4>Total</h4>
            </div>
            <?php foreach (array_keys($listeProduitCommande) as $produit) { ?>
                <div class="elementPanier">
                    <p><?= $listeProduitCommande[$produit]["name"] ?></p>

                    <?php if ($listeProduitCommande[$produit]["discount"] > 0) : ?>
                        <div>
                            <p class="solde"><?= formatPrice((int) $listeProduitCommande[$produit]["price"]) ?></p>
                            <p><?= formatPrice(discountedPrice((int)$listeProduitCommande[$produit]["price"], (int)$listeProduitCommande[$produit]["discount"])) ?></p>
                        </div>
                        <p><?= $listeProduitCommande[$produit]["quantite"] ?></p>
                        <p><?= formatPrice(discountedPrice((int) $listeProduitCommande[$produit]["prixTotal"], (int)$listeProduitCommande[$produit]["discount"])) ?></p>
                    <?php else : ?>
                        <p><?= formatPrice((int) $listeProduitCommande[$produit]["price"]) ?></p>
                        <p><?= $listeProduitCommande[$produit]["quantite"] ?></p>
                        <p><?= formatPrice((int) $listeProduitCommande[$produit]["prixTotal"]) ?></p>
                    <?php endif ?>
                </div>
            <?php }
            ?>

            <form action="cart.php" method="post">
                <?php foreach ($data as $key => $value): ?>
                    <?php if (is_array($value)) : ?>
                        <?php foreach ($value as $subKey => $subVal): ?>
                            <input type="hidden" name="<?= $key ?>[<?= $subKey ?>]" value="<?= $subVal ?>"/>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= $value?>" />
                    <?php endif; ?>
                <?php endforeach; ?>
                <fieldset>
                    <legend>Choix du livreur:</legend>
                    <div>
                        <input type="radio" id="dhl" name="livreur" value="dhl" <?= $livreur == "dhl" ? "checked" : "" ?> />
                        <label for="dhl">DHL</label>
                    </div>
                    <div>
                        <input type="radio" id="dpd" name="livreur" value="dpd" <?= $livreur == "dpd" ? "checked" : "" ?>/>
                        <label for="dpd">DPD</label>
                    </div>
                </fieldset>
                <button type="submit">Recalculer</button>
            </form>

            <div class="prixTotal">
                <p>HT : <?= priceExcludingTVA($prixTotal) ?></p>
                <p>TVA : <?= formatPrice($prixTotal * 0.2) ?> </p>
                <p>Livraison : <?=formatPrice(prixLivraison($livreur, $poidTotal, $prixTotal )) ?> </p>
                <p>Total : <?= formatPrice($prixTotal) ?></p>
            </div>
        </div>
    </main>
    <?php require_once 'footer.php' ?>
</body>

</html>