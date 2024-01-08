<?php
// Include fișierul de conexiune la baza de date
include 'includes/db_connections.php';

// Utilizatorul pentru care dorești să verifici hash-ul
$username = 'test1';

// Interogare pentru a obține hash-ul din baza de date
$query = "SELECT password FROM users WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();

    if ($user_data) {
        echo "Hash-ul din baza de date pentru utilizatorul '$username' este: " . $user_data['password'];
    } else {
        echo "Utilizatorul '$username' nu a fost găsit în baza de date.";
    }

    $stmt->close();
} else {
    echo "Eroare la pregătirea interogării SQL.";
}

// Închide conexiunea la baza de date
$conn->close();
?>
