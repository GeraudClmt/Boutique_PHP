<?php
function formatPrice(float $centPrice) : string{
    $price = number_format(($centPrice / 100), 2, ',', ' ') . '€';
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

function prixLivraison(string $livreur, int $poidTotal, float $prixTotal) : float{
    $prixLivraison = 0;
    switch ($livreur){
        case "dhl":
            if($poidTotal >= 0 && $poidTotal <= 500){
                $prixLivraison = 500;
            }elseif($poidTotal > 500 && $poidTotal <= 2000){
                $prixLivraison = $prixTotal * 0.1;
            }else{
                $prixLivraison = 0;
            }
        break;
        case "dpd":
            if($poidTotal >= 0 && $poidTotal <= 500){
                $prixLivraison = 600;
            }elseif($poidTotal > 500 && $poidTotal <= 2000){
                $prixLivraison = $prixTotal * 0.13;
            }else{
                $prixLivraison = 0;
            }
        break;
    }

    return $prixLivraison;
}
?>