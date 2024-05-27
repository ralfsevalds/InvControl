<?php

// Include the database connection file
require_once 'db_connect.php';

// Check if the order_id parameter is provided
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Retrieve the order details from the database with sale price
    $sql = "SELECT order_details.product_id, product.name, order_details.quantity, product.sale_price
            FROM order_details
            INNER JOIN product ON order_details.product_id = product.id
            WHERE order_details.order_id = :order_id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    $order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send the order details as JSON response
    header('Content-Type: application/json');
    echo json_encode($order_details);
}
?>