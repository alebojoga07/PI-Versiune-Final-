<?php
ini_set('display_errors', '0'); 

session_start();
include 'includes/db_connections.php';


// Afișează conținutul $_POST în consolă
//echo '<script>console.log("$_POST: ", ' . json_encode($_POST) . ');</script>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_REQUEST['productId'];
    $selectedSize = $_REQUEST['selectedSize'];
    $quantity = $_REQUEST['quantity'];
    $item=array('id' => $productId,'size' =>$selectedSize );
    $userId = $_SESSION['id'];
    
    // Adaugă produsul în sesiune
   // $_SESSION['cart'][] = ['id' => $productId, 'size' => $selectedSize];
   //array_push($_SESSION['cart'], $item);
    // Debug: Afișează conținutul sesiunii în consolă
    //echo '<script>console.log("$_SESSION[\'cart\']: ", ' . json_encode($_SESSION['cart']) . ');</script>';

    // Returnează un mesaj de succes sau alte informații dacă este cazul
    $query = "INSERT INTO cart ( user_id, product_id, selected_size, quantity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);


        // Check if the statement is prepared successfully
        if ($stmt) {
            $stmt->bind_param("ssss", $userId, $productId, $selectedSize, $quantity);

            if ($stmt->execute()) {
                // Product into mysql 
                echo json_encode(['success' => true]);

            } else {
                // Query failed
                echo "failed";
            }

            $stmt->close();
        } else {
            // Statement preparation failed
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
        }
    
} else {
    // Handle invalid requests
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
