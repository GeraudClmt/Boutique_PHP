<?php
function formatPrice(float $centPrice) : string{
    $price = number_format(($centPrice / 100), 2, ',', ' ') . '€';
    return $price;
};

function priceExcludingTVA(float $priceTTC) : string{
    $price = $priceTTC - ($priceTTC * 20 / 100);
    $priceHT = formatPrice($price);
    return $priceHT;
};

function discountedPrice(int $centPrice, float $promo) : float{
    (int) $price = $centPrice - ($centPrice * $promo / 100);
    return $price;
};
?>