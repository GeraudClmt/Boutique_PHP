<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'datas/my-functions.php';
require_once 'datas/database.php';

$listeProduitCommande = [];
$_SESSION["prixTotal"] = 0;
$_SESSION["poidTotal"] = 0;
if (!isset($_SESSION["numeroLivreur"])) {
    $_SESSION["numeroLivreur"] = 1;
}


//Si les variables n'existent pas je les crées vides
if (!isset($_SESSION["price"], $_SESSION["quantite"], $_SESSION["weight"], $_SESSION["discount"])) {
    $_SESSION["price"] = [];
    $_SESSION["quantite"] = [];
    $_SESSION["discount"] = [];
    $_SESSION["weight"] = [];
}



//Si requete get avec "Vider le panier" appel fonction viderLePanier
if (isset($_GET["viderPanier"]) && $_GET["viderPanier"] == "Vider le panier") {
    viderLePanier();
}




//Si requete get avec changementQuantite on change la quantité de session
if (isset($_GET["changementQuantite"])) {
    foreach ($_GET["changementQuantite"] as $produit => $quantite) {
        if (is_numeric($quantite)) {
            $_SESSION["quantite"][$produit] = $quantite;
        } else {
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
    header("Location: cart.php");
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
if (!empty($listeProduitCommande)) {
    //print_r($listeProduitCommande);
    foreach (array_keys($listeProduitCommande) as $i) {
        if ($listeProduitCommande[$i]["discount"] > 0) {
            $_SESSION["prixTotal"] = $_SESSION["prixTotal"] + discountedPrice((int)$listeProduitCommande[$i]["prixTotal"], (int)$listeProduitCommande[$i]["discount"]);
        } else {
            $_SESSION["prixTotal"] = $_SESSION["prixTotal"] + $listeProduitCommande[$i]["prixTotal"];
        }
        $_SESSION["poidTotal"] = $_SESSION["poidTotal"] + ($listeProduitCommande[$i]["weight"] * $listeProduitCommande[$i]["quantite"]);
    }
}

if (!empty($_GET["orderId"])) {
    cancelOrder($_GET["orderId"]);
    header('Location: cart.php');
    exit();
}

//Liste des commande en fonction de id utilisateur
$listLastOrder = listOrderUser(1);

//recupération de la liste des livreur
$listeCarriers = pull_carriers($_SESSION["prixTotal"], $_SESSION["poidTotal"]);

//Si il y a eu une requete get avec livreur, on met cette valeur dans session sinon par defaut "dhl"
if (isset($_GET["livreur"])) {
    $_SESSION["livreur"] = htmlspecialchars($_GET["livreur"]);

    foreach ($listeCarriers as $carrier) {
        if ($carrier["name"] === $_SESSION["livreur"]) {
            $_SESSION["numeroLivreur"] = $carrier["id"];
        }
    }
} else {
    $_SESSION["livreur"] = "Colissimo";
}



//Click sur le boutton commander

if (isset($_GET["commander"]) && $_GET["commander"] == "true") {

    addOrder(
        (float)$_SESSION["prixTotal"] + prixLivraison($listeCarriers, $_SESSION["numeroLivreur"], $_SESSION["prixTotal"]),
        (float)prixLivraison($listeCarriers, $_SESSION["numeroLivreur"], $_SESSION["prixTotal"]),
        (int)$_SESSION["poidTotal"],
        1,
        $_SESSION["numeroLivreur"]
    );

    foreach ($listeProduitCommande as $product) {

        addOrder_product($product["name"], $product["price"], $product["quantite"]);
    }


    viderLePanier();
    header('Location: cart.php');
    exit();
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
                <button class="m-3 btn btn-outline-success" type="submit">Recalculer avec les quantiées</button>
            </form>
            <?php if ($_SESSION["prixTotal"] > 0) : ?>
                <form action="cart.php" method="get">
                    <fieldset class="containerChoixLivreurs">
                        <legend>Choix du livreur:</legend>
                        <?php foreach ($listeCarriers as $carrier) { ?>
                            <div class="m-2">
                                <input type="radio" id="<?= $carrier["id"] ?>" name="livreur" value="<?= $carrier["name"] ?>" <?= $_SESSION["numeroLivreur"] == $carrier["id"] ? "checked" : "" ?> />
                                <label for="<?= $carrier["id"] ?>"><?= $carrier["name"] ?></label>
                            </div>
                        <?php } ?>
                        <button class="btn btn-outline-success" type="submit">Recalculer avec le bon livreur</button>
                    </fieldset>
                    <input class="btn btn-outline-success" type="submit" name="viderPanier" value="Vider le panier" />
                </form>


                <div class="prixTotal">

                    <p>HT : <?= priceExcludingTVA($_SESSION["prixTotal"]) ?></p>
                    <p>TVA : <?= formatPrice($_SESSION["prixTotal"] * 0.2) ?> </p>
                    <p>Livraison : <?= formatPrice(prixLivraison($listeCarriers, $_SESSION["numeroLivreur"], $_SESSION["prixTotal"])) ?> </p>
                    <p>Total TTC : <?= formatPrice($_SESSION["prixTotal"] + prixLivraison($listeCarriers, $_SESSION["numeroLivreur"], $_SESSION["prixTotal"])) ?></p>

                </div>
                <form method="get" class="col d-flex justify-content-end m-4">
                    <input type="hidden" name="commander" value="true" />
                    <button class="btn btn-success" type="submit">Commander</button>
                </form>
            <?php endif ?>

        </div>

        <div class="row justify-content-center">
            <?php if (isset($listLastOrder)) : ?>
                <h2>Commandes d'aujourd'hui</h2>
                <?php
                foreach ($listLastOrder as $order) { ?>
                    <form action="cart.php" method="get" class="col-4 m-2 border border-success-subtle rounded p-2">
                        <h4>Numéro : <?= $order["id"] ?></h4>
                        <h4>Prix total : <?= formatPrice($order["total"]) ?> </h4>
                        <input type="hidden" name="orderId" value="<?= $order["id"] ?>" />
                        <button type="submit" class="btn btn-danger">Annuler la commande</button>
                    </form>
                <?php } ?>
            <?php endif ?>

        </div>
    </main>

    <?php require_once 'footer.php' ?>
</body>

</html>