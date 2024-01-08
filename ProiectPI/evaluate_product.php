<?php
session_start();
include 'includes/db_connections.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifică dacă cheile necesare sunt setate și nu sunt nule
    $productId = isset($_REQUEST['productId']) ? $_REQUEST['productId'] : null;
    $rating = isset($_REQUEST['rating']) ? $_REQUEST['rating'] : null;
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    if ($productId !== null && $rating !== null && $userId !== null) {
        // Verifică dacă utilizatorul a evaluat deja acest produs
        $checkRatingQuery = "SELECT * FROM ratings WHERE product_id = ? AND user_id = ?";
      
        $checkRatingStmt = mysqli_prepare($conn, $checkRatingQuery);
        mysqli_stmt_bind_param($checkRatingStmt, 'ii', $productId, $userId);
        mysqli_stmt_execute($checkRatingStmt);
        $checkRatingResult = mysqli_stmt_get_result($checkRatingStmt);
        
        if ($checkRatingResult->num_rows == 0) {
   
            $insertQuery = "INSERT INTO ratings (product_id, user_id, rating) VALUES (?, ?, ?)";
       

        // Utilizează o altă instrucțiune pregătită pentru actualizare sau inserare
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, 'iii',  $productId, $userId, $rating);
        $result = mysqli_stmt_execute($insertStmt);
    
        if ($result) {
            // Returnă un mesaj de succes sau date suplimentare dacă este nevoie
            echo json_encode(['success' => true]);
        } else {
            // Returnă un mesaj de eroare dacă actualizarea eșuează
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }

    } else {
        $updateQuery = "UPDATE `ratings` SET `rating` = ? WHERE `ratings`.`user_id` = ? AND `ratings`.`product_id` = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'iii',  $rating, $userId, $productId);
        $result = mysqli_stmt_execute($updateStmt);
        if ($result) {
            // Returnă un mesaj de succes sau date suplimentare dacă este nevoie
            echo json_encode(['success' => true]);
        } else {
            // Returnă un mesaj de eroare dacă actualizarea eșuează
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }

    }
    } else {
        // Afișează un mesaj de eroare sau iau o altă măsură dacă nu ai toate cheile necesare
        echo json_encode(['success' => false, 'error' => 'Missing or null values for required keys']);
    }
} else {
    // Gestionează cereri invalide
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
