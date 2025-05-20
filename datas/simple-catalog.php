<?php
$products=["Corde d'escalade", "Piolet", "Campons"];

sort($products);


?>

<div>
    <h3><?php echo $products[0] ?></h3>
    <h3><?php echo end($products) ?></h3>
</div>
