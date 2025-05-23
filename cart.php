<?php
session_start();
require_once 'datas/my-functions.php';

$listeProduitCommande = [];
$_SESSION["prixTotal"] = 0;
$_SESSION["poidTotal"] = 0;

//Si les variables n'existent pas je les crées vides
if (!isset($_SESSION["price"], $_SESSION["quantite"], $_SESSION["weight"], $_SESSION["discount"])) {
    $_SESSION["price"] = [];
    $_SESSION["quantite"] = [];
    $_SESSION["discount"] = [];
    $_SESSION["weight"] = [];
}
//Si il y a eu une requete get avec livreur, on met cette valeur dans session sinon par defaut "dhl"
if (isset($_GET["livreur"])) {
    $_SESSION["livreur"] = htmlspecialchars($_GET["livreur"]);
} else {
    $_SESSION["livreur"] = "dhl";
}

//Si requete get avec "Vider le panier" appel fonction viderLePanier
if ($_GET["viderPanier"] == "Vider le panier") {
    viderLePanier();
}

//Si requete get avec changementQuantite on change la quantité de session
if(isset($_GET["changementQuantite"])){
    foreach($_GET["changementQuantite"] as $produit => $quantite){
        if(is_numeric($quantite)){
            $_SESSION["quantite"][$produit] = $quantite;
        }else{
            echo "Erreur type de quantité";
        }
        
    }
}

//Si on a une requete post et que les variables sont pas null
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["price"]) && !empty($_POST["quantite"]) && !empty($_POST["discount"]) && !empty($_POST["weight"])) {
        foreach ($_POST["quantite"] as $produit => $quantite) {
            if (isset($_SESSION["quantite"][$produit]) &&  $_SESSION["quantite"][$produit] != 0) {
                $_SESSION["quantite"][$produit] = $_SESSION["quantite"][$produit] + (int)$quantite;
            } else {
                $_SESSION["quantite"][$produit] = 0 + (int)$quantite;
            }

            $_SESSION["price"][$produit] = $_POST["price"][$produit];
            $_SESSION["discount"][$produit] = $_POST["discount"][$produit];
            $_SESSION["weight"][$produit] = $_POST["weight"][$produit];
        }
    }
    //Recharge la parge cart.php
    header(("Location: cart.php"));
    //Arrete le script pour pas recharger le reste
    exit();
}

//Stockage de tous session dans un tableau pour l'exploitation
foreach (array_keys($_SESSION["quantite"]) as $item) {
    if (isset($_SESSION["quantite"][$item]) && $_SESSION["quantite"][$item] != "0") {
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

//Calcul des prix total et poids
foreach (array_keys($listeProduitCommande) as $i) {
    $_SESSION["prixTotal"] = $_SESSION["prixTotal"] + $listeProduitCommande[$i]["prixTotal"];
    $_SESSION["poidTotal"] = $_SESSION["poidTotal"] + ($listeProduitCommande[$i]["weight"] * $listeProduitCommande[$i]["quantite"]);
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
            <form action="cart.php" method="get">
                <?php foreach (array_keys($listeProduitCommande) as $produit) { ?>
                    <div class="elementPanier">
                        <p><?= $listeProduitCommande[$produit]["name"] ?></p>
                        <?php if ($listeProduitCommande[$produit]["discount"] > 0) : ?>
                            <div>
                                <p class="solde"><?= formatPrice((int) $listeProduitCommande[$produit]["price"]) ?></p>
                                <p><?= formatPrice(discountedPrice((int)$listeProduitCommande[$produit]["price"], (int)$listeProduitCommande[$produit]["discount"])) ?></p>
                            </div>
                            <input class="incrementeurPanier" type="number" name="changementQuantite[<?= $produit ?>]" value=<?= $listeProduitCommande[$produit]["quantite"] ?> min="0" max="100" />
                            <p><?= formatPrice(discountedPrice((int) $listeProduitCommande[$produit]["prixTotal"], (int)$listeProduitCommande[$produit]["discount"])) ?> TTC</p>
                        <?php else : ?>
                            <p><?= formatPrice((int) $listeProduitCommande[$produit]["price"]) ?></p>
                            <input class="incrementeurPanier" type="number" name="changementQuantite[<?= $produit ?>]" value=<?= $listeProduitCommande[$produit]["quantite"] ?> min="0" max="100" />
                            <p><?= formatPrice((int) $listeProduitCommande[$produit]["prixTotal"]) ?> TTC</p>
                        <?php endif ?>
                    </div>
                <?php }
                ?>
                <button class="btnRecalculerLivreur" type="submit">Recalculer avec les quantiées</button>
            </form>
            <form  action="cart.php" method="get">
                <fieldset class="containerChoixLivreurs">
                    <legend>Choix du livreur:</legend>
                    <div>
                        <input type="radio" id="dhl" name="livreur" value="dhl" <?= $_SESSION["livreur"] == "dhl" ? "checked" : "" ?> />
                        <label for="dhl">DHL</label>
                    </div>
                    <div>
                        <input type="radio" id="dpd" name="livreur" value="dpd" <?= $_SESSION["livreur"] == "dpd" ? "checked" : "" ?> />
                        <label for="dpd">DPD</label>
                    </div>
                    <button class="btnRecalculerLivreur" type="submit">Recalculer avec le bon livreur</button>
                </fieldset>
                <input class="btnRecalculerLivreur" type="submit" name="viderPanier" value="Vider le panier" />
            </form>

            <div class="prixTotal">
                <p>HT : <?= priceExcludingTVA($_SESSION["prixTotal"]) ?></p>
                <p>TVA : <?= formatPrice($_SESSION["prixTotal"] * 0.2) ?> </p>
                <p>Livraison : <?= formatPrice(prixLivraison($_SESSION["livreur"], $_SESSION["poidTotal"], $_SESSION["prixTotal"])) ?> </p>
                <p>Total TTC : <?= formatPrice($_SESSION["prixTotal"] + prixLivraison($_SESSION["livreur"], $_SESSION["poidTotal"], $_SESSION["prixTotal"])) ?></p>
            </div>
        </div>
    </main>
    <?php require_once 'footer.php' ?>
</body>

</html>