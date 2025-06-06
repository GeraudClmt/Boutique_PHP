<?php
function connectToDataBase(): PDO
{
    $host = "127.0.0.1";
    $bdd = "Store"; //Store
    $user = "business"; //user
    $pswd = "home"; //password

    try {
        $mysqlClient = new PDO(
            "mysql:host=$host;dbname=$bdd;chartset=utf8",
            $user,
            $pswd,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
        );
        return $mysqlClient;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function pullTableProducts(int $categories = 0): array
{
    if ($categories == 0) {
        $sqlQuery = 'SELECT * FROM products;';
        $productStatement = connectToDataBase()->prepare($sqlQuery);
        $productStatement->execute();
    } else {
        $sqlQuery = 'SELECT * FROM products WHERE categories_id = :categories_id;';
        $productStatement = connectToDataBase()->prepare($sqlQuery);
        $productStatement->execute([
            "categories_id" => $categories
        ]);
    }

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
    $sqlQuery = 'SELECT SUM(o.total) as total FROM orders o WHERE date(date) = CURDATE();';
    $listOrder = connectToDataBase()->prepare($sqlQuery);

    $listOrder->execute();
    return $listOrder->fetchAll(PDO::FETCH_ASSOC);
}

function addOrder(float $total, float $shipping_cost, int $total_weight, int $customer_id, int $carrier_id)
{
    $sqlQuery = 'INSERT INTO orders (total, shipping_cost, total_weight, customer_id, carrier_id) 
                 VALUES (:total, :shipping_cost, :total_weight, :customer_id, :carrier_id);';

    $envoie = connectToDataBase()->prepare($sqlQuery);

    $envoie->execute([
        'total' => $total,
        'shipping_cost' => $shipping_cost,
        'total_weight' => $total_weight,
        'customer_id' => $customer_id,
        'carrier_id' => $carrier_id
    ]);
}

function addOrder_product(string $name, float $price, int $quantity)
{
    echo "<br>" . $name . "<br>" . $price . "<br>" . $quantity . "<br>";
    $connectionBDD = connectToDataBase();
    //SELECT id FROM products WHERE name = "Corde" AND price = 100;
    $sqlIdProduct = 'SELECT id FROM products WHERE name = :name AND ABS(price - :price) < 0.01';
    $idProduct = $connectionBDD->prepare($sqlIdProduct);
    $idProduct->execute([
        'name' => $name,
        'price' => $price
    ]);

    $id = $idProduct->fetchAll();
    print_r($id);

    //SELECT MAX(id) FROM orders;
    $sqlIdLastOrder = 'SELECT MAX(id) FROM orders;';
    $idLastOrder = $connectionBDD->prepare($sqlIdLastOrder);
    $idLastOrder->execute();
    $idLastOrders = $idLastOrder->fetchAll();

    $sqlQuery = 'INSERT INTO order_product (product_id, quantity, order_id) VALUES (:product_id, :quantity, :order_id);';
    $envoie = $connectionBDD->prepare($sqlQuery);

    $envoie->execute([
        'product_id' => $id[0][0],
        'quantity' => $quantity,
        'order_id' => $idLastOrders[0][0]
    ]);
}

function listOrderUser($userID)
{
    $sqlLastOrder = 'SELECT * FROM orders WHERE date(DATE) = CURDATE() AND customer_id = :customer_id;';
    $listLastOrders = connectToDataBase()->prepare($sqlLastOrder);
    $listLastOrders->execute([
        "customer_id" => $userID
    ]);

    $listLastOrders = $listLastOrders->fetchAll();
    return $listLastOrders;
}

function cancelOrder(int $idOrder)
{
    $connectionBDD = connectToDataBase();

    try {
        $sqlDeleteOP = 'DELETE FROM order_product WHERE order_id = :order_id;';
        $deleteOP = $connectionBDD->prepare($sqlDeleteOP);
        $deleteOP->execute([
            "order_id" => $idOrder,
        ]);
    } catch (error) {
        echo "Erreur suppression order_product";
    }

    try {
        $sqlDeleteOrder = 'DELETE FROM orders WHERE id = :id;';
        $deleteOrder = $connectionBDD->prepare($sqlDeleteOrder);
        $deleteOrder->execute([
            "id" => $idOrder,
        ]);
    } catch (error) {
        echo "Erreur suppression order";
    }
}

function pull_carriers(float $totalPrice, int $totalWeight): array
{
    $sqlPullCarriers = 'SELECT * FROM carrier WHERE max_weight >= :max_weight;';
    if ($totalPrice > 20.00) {
        $sqlPullCarriers = 'SELECT * FROM carrier WHERE tracking = 1 AND max_weight >= :max_weight;';
    }

    $listCarriers = connectToDataBase()->prepare($sqlPullCarriers);
    $listCarriers->execute([
        "max_weight" => $totalWeight,
    ]);

    return $listCarriers->fetchAll();
}
