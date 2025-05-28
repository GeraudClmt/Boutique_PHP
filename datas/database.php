<?php
function connectToDataBase(): PDO
{
    try {
        $mysqlClient = new PDO(
            'mysql:host=127.0.0.1;dbname=Store;chartset=utf8',
            'user',
            'password',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
        );
        return $mysqlClient;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function pullTableProducts(): array
{
    $sqlQuery = 'SELECT * FROM products';
    $productStatement = connectToDataBase()->prepare($sqlQuery);

    $productStatement->execute();

    return $productStatement->fetchAll();
}

function pullCategories(): array
{
    $sqlQuery = 'SELECT * FROM categories';
    $productStatement = connectToDataBase()->prepare($sqlQuery);

    $productStatement->execute();

    return $productStatement->fetchAll();
}

function pullLastOrders(): array
{
    $sqlQuery = 'SELECT c.first_name, c.last_name, COUNT(o.customer_id) AS nb_Orders from customers c INNER JOIN orders o ON c.id = o.customer_id GROUP BY c.id LIMIT  5;';
    $listOrders = connectToDataBase()->prepare($sqlQuery);

    $listOrders->execute();

    return $listOrders->fetchAll();
}

function totalOrdersOfTheDay(): array
{
    $sqlQuery = 'SELECT SUM(p.price * op.quantity) AS total FROM order_product op JOIN orders o ON o.id=op.order_id JOIN products p ON op.product_id = p.id WHERE date(date) = CURDATE();';
    $listOrder = connectToDataBase()->prepare($sqlQuery);

    $listOrder->execute();
    return $listOrder->fetchAll();
}

function addOrder(int $total, int $shipping_cost, int $total_weight, int $customer_id, int $carrier_id )
{
    $sqlQuery = 'INSERT INTO orders (total, shipping_cost, total_weight, customer_id, carrier_id) 
                 VALUES (:total, :shipping_cost, :total_weight, :customer_id, :carrier_id)';

    $envoie = connectToDataBase()->prepare($sqlQuery);

    $envoie->execute([
        'total' => $total,
        'shipping_cost' => $shipping_cost,
        'total_weight' => $total_weight,
        'customer_id' => $customer_id,
        'carrier_id' => $carrier_id
    ]);
}
