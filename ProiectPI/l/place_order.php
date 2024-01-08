<?php
session_start();
include 'includes/db_connections.php';

// Debug: Afișează conținutul sesiunii


// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit;
}
$userId = $_SESSION['id']; // Assuming 'id' is the user ID field in your users table

if ($userId === null) {
    echo "Error: User ID is not valid.";
    exit;
}


if ($_POST){

// Fetch cart items for the logged-in user
$query = "SELECT c.*, p.nume AS product_name , p.pret AS product_pret, p.imagine AS imagine 
FROM cart c
JOIN produse p ON c.product_id = p.id
WHERE c.user_id = $userId";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch cart items as an associative array
$cartItems = mysqli_fetch_all($result, MYSQLI_ASSOC);


$jsonItems =  json_encode($cartItems);




$pret_total = 0;
foreach ($cartItems as $item) {
$pret_total = $pret_total + $item['quantity'] * $item['product_pret'];
}





// Close the connection

$adresa = $_POST['adresa'];
$nume = $_POST['nume'];
$telefon = $_POST['telefon'];

$query = "INSERT INTO `orders` ( `user_id`, `comanda`, `total_price`, `nume`, `adresa`, `telefon`) VALUES ( '$userId', '$jsonItems', '$pret_total', '$nume', '$adresa', '$telefon')";
 
$result = mysqli_query($conn, $query);
if ($result == 0) {
    die("A Aparut o eroare la inregistrarea in mysql");
} else {
    // Golește coșul
    $_SESSION['cart'] = [];
    //sterge cosul din mysql 
    $query = "DELETE FROM cart WHERE user_id = $userId";
    $result = mysqli_query($conn, $query);

    // Redirecționează către o pagină de mulțumire sau afișează un mesaj de succes
    header('Location: thank_you.php');
    die();
}

// Close the connection
mysqli_close($conn);

}
?>
