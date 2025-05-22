<?php
require_once 'datas/my-functions.php';

$listeProduitCommande = [];
$prixTotal = 0;
$listePrice = $_POST["price"];
$listeQuantite = $_POST["quantite"];
$listeDiscount = $_POST["discount"];

$data = $_POST;

foreach (array_keys($listePrice) as $item) {
    if (isset($listeQuantite[$item]) && $listeQuantite[$item] != "0") {
        //echo "Element : " . $item . " Quantité : " . $listeQuantite[$item] . " prix : " . $listePrice[$item];

        $listeProduitCommande[$item] = [
            "name" => $item,
            "price" => $listePrice[$item],
            "quantite" => $listeQuantite[$item],
            "prixTotal" => (int) $listePrice[$item] * (int) $listeQuantite[$item],
            "discount" => (int) $listeDiscount[$item]
        ];
    }
}

foreach (array_keys($listeProduitCommande) as $i) {
    $prixTotal = $prixTotal + $listeProduitCommande[$i]["prixTotal"];
}



?>


<?php require_once 'datas/head.php';
echo head("Panier", "Tous les acticles du panier sont ici.");
?>

<body>
    <?php require_once 'header.php' ?>
    <main class="mainPanier">
        <form class="containerPanier">
            <div class="elementPanier">
                <h4>Produit</h4>
                <h4>Prix</h4>
                <h4>Quantité</h4>
                <h4>Total</h4>
            </div>
            <?php foreach (array_keys($listeProduitCommande) as $produit) { ?>
                <div class="elementPanier">
                    <input type="text" value=<?= $listeProduitCommande[$produit]["name"]?> readonly="readonly"/>

                    <?php if ($listeProduitCommande[$produit]["discount"] > 0) : ?>
                        <div>
                            <input class="solde" type="text" value=<?= formatPrice((int) $listeProduitCommande[$produit]["price"]) ?> readonly="readonly"/>
                            <input type="text" value=<?= formatPrice(discountedPrice((int)$listeProduitCommande[$produit]["price"], (int)$listeProduitCommande[$produit]["discount"])) ?> readonly="readonly"/>
                        </div>
                        <input type="text" value=<?= $listeProduitCommande[$produit]["quantite"] ?> readonly="readonly"/>
                        <input type="text" value=<?= formatPrice(discountedPrice((int) $listeProduitCommande[$produit]["prixTotal"], (int)$listeProduitCommande[$produit]["discount"])) ?> readonly="readonly"/>
                    <?php else : ?>
                        <input type="text" value=<?= formatPrice((int) $listeProduitCommande[$produit]["price"]) ?> readonly="readonly"/>
                        <input type="text" value=<?= $listeProduitCommande[$produit]["quantite"] ?> readonly="readonly"/>
                        <input type="text" value=<?= formatPrice((int) $listeProduitCommande[$produit]["prixTotal"]) ?> readonly="readonly"/>
                    <?php endif ?>
                </div>
            <?php }
            ?>
            <div class="prixTotal">
                <div class="totalTVA_HT">
                    <label for="textPriceTVA">HT :</label>
                    <input type="text" id="textPriceTVA" value=<?= priceExcludingTVA($prixTotal) ?> readonly="readonly"/>
                </div>
                <div class="totalTVA_HT">
                    <label for="textTVA">TVA :</label>
                    <input type="text" id="textTVA" value=<?= formatPrice($prixTotal * 0.2) ?> readonly="readonly"/>
                </div>
                <div class="totalTVA_HT">
                    <label for="textPriceTotal">Total :</label>
                    <input type="text" id="textPriceTotal" value=<?= formatPrice($prixTotal) ?> eadonly="readonly"/>
                </div>
            </div>
        </form>
    </main>
    <?php require_once 'footer.php' ?>
</body>

</html>