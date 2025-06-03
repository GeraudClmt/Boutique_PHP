<?php
function formatPrice(float $centPrice) : string{
    $price = number_format($centPrice, 2, ',', ' ') . '€';
    return $price;
}

function priceExcludingTVA(float $priceTTC) : string{
    $price = $priceTTC - ($priceTTC * 20 / 100);
    $priceHT = formatPrice($price);
    return $priceHT;
}

function discountedPrice(int $centPrice, float $promo) : float{
    (int) $price = $centPrice - ($centPrice * $promo / 100);
    return $price;
}

function prixLivraison(array $listeCarriers, int $numeroLivreur) : float{
    $prixLivraison = 0;
    foreach($listeCarriers as $carrier){
        if($carrier["id"] === $numeroLivreur){
            $prixLivraison = $carrier["shipping_cost"];
        }
    }
    
    return $prixLivraison;
}

function viderLePanier(){
    $_SESSION["price"] = [];
    $_SESSION["quantite"] = [];
    $_SESSION["discount"] = [];
    $_SESSION["weight"] = [];
}
?>