<?php
session_start();
require_once 'datas/my-functions.php';

$listeProduitCommande = [];
$_SESSION["prixTotal"] = 0;
$_SESSION["poidTotal"] = 0;

if (!isset($_SESSION["price"], $_SESSION["quantite"], $_SESSION["weight"], $_SESSION["discount"])) {
    $_SESSION["price"] = [];
    $_SESSION["quantite"] = [];
    $_SESSION["discount"] = [];
    $_SESSION["weight"] = [];
}
if (isset($_POST["livreur"])) {
    $_SESSION["livreur"] = $_POST["livreur"];
} else {
    $_SESSION["livreur"] = "dhl";
}


if (!empty($_POST["price"]) && !empty($_POST["quantite"]) && !empty($_POST["discount"]) && !empty($_POST["weight"])) {
    foreach ($_POST["quantite"] as $produit => $quantite) {
        $_SESSION["quantite"][$produit] = ($_SESSION["quantite"][$produit] ?? 0) + (int)$quantite;

        $_SESSION["price"][$produit] = $_POST["price"][$produit];
        $_SESSION["discount"][$produit] = $_POST["discount"][$produit];
        $_SESSION["weight"][$produit] = $_POST["weight"][$produit];
    }

}

$data = $_SESSION;


foreach (array_keys($_SESSION["price"]) as $item) {
    if (isset($_SESSION["quantite"][$item]) && $_SESSION["quantite"][$item] != "0") {
        //echo "Element : " . $item . " Quantité : " . $_SESSION["quantite"][$item] . " prix : " . $_SESSION["price"][$item];

        $listeProduitCommande[$item] = [
            "name" => $item,
            "price" => $_SESSION["price"][$item],
            "quantite" => $_SESSION["quantite"][$item],
            "prixTotal" => (int) $_SESSION["price"][$item] * (int) $_SESSION["quantite"][$item],
            "discount" => (int) $_SESSION["discount"][$item],
            "weight" => (int)$_SESSION["weight"][$item]
        ];
    }
}

foreach (array_keys($listeProduitCommande) as $i) {
    $_SESSION["prixTotal"] = $_SESSION["prixTotal"] + $listeProduitCommande[$i]["prixTotal"];
    $_SESSION["poidTotal"] = $_SESSION["poidTotal"] + ($listeProduitCommande[$i]["weight"] * $listeProduitCommande[$i]["quantite"]);
}

//session_destroy();


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
                <fieldset>
                    <legend>Choix du livreur:</legend>
                    <div>
                        <input type="radio" id="dhl" name="livreur" value="dhl" <?= $_SESSION["livreur"] == "dhl" ? "checked" : "" ?> />
                        <label for="dhl">DHL</label>
                    </div>
                    <div>
                        <input type="radio" id="dpd" name="livreur" value="dpd" <?= $_SESSION["livreur"] == "dpd" ? "checked" : "" ?> />
                        <label for="dpd">DPD</label>
                    </div>
                </fieldset>
                <button type="submit">Recalculer</button>
            </form>

            <div class="prixTotal">
                <p>HT : <?= priceExcludingTVA($_SESSION["prixTotal"]) ?></p>
                <p>TVA : <?= formatPrice($_SESSION["prixTotal"] * 0.2) ?> </p>
                <p>Livraison : <?= formatPrice(prixLivraison($_SESSION["livreur"], $_SESSION["poidTotal"], $_SESSION["prixTotal"])) ?> </p>
                <p>Total : <?= formatPrice($_SESSION["prixTotal"] + prixLivraison($_SESSION["livreur"], $_SESSION["poidTotal"], $_SESSION["prixTotal"])) ?></p>
            </div>
        </div>
    </main>
    <?php require_once 'footer.php' ?>
</body>

</html>