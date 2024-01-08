<?php
session_start();
// ne da numarul de stele pentru produsul PID 
include 'includes/db_connections.php';
if (!$conn) {
    die("Conexiunea la baza de date nu a putut fi stabilită: " . mysqli_connect_error());
}
// Fetch random clothes from the database
if (isset($_GET['pid']) && !empty($_GET['pid'])) {
    $productId = $_GET['pid'];

$query = "SELECT p.* , AVG(r.rating) as rating FROM produse p
LEFT JOIN ratings r ON p.id = r.product_id where p.id = $productId";


$result_product = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result_product);
$averageRating = round($product['rating']);
print $averageRating;
}
?>