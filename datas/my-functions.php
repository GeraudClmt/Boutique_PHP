<?php
function formatPrice(int $centPrice){
    $price = number_format(($centPrice / 100), 2, ',', ' ') . '€';
    return $price;
};

function priceExcludingTVA(int $priceTTC){
    $price = $priceTTC - ($priceTTC * 20 / 100);
    $priceHT = formatPrice($price);
    return $priceHT;
};

function discountedPrice(int $centPrice, $promo){
    (int) $price = $centPrice - ($centPrice * $promo / 100);
    return $price;
};
?>