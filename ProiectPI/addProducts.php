<?php
ini_set('display_errors', '0'); 

session_start();
include 'includes/db_connections.php';

// Debug: Afișează conținutul sesiunii


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $nume = $_POST['nume'];
    $imagine = $_POST['imagine'];
    $descriere = $_POST['descriere'];
    $pret = $_POST['pret'];
    $cantitate = $_POST['cantitate'];

    // Insert data into the 'produse' table
    $query = "INSERT INTO produse (nume, imagine, descriere, pret, cantitate) VALUES ('$nume', '$imagine', '$descriere', $pret, $cantitate)";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoolOutfits | Clothes Website Design</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,900;1,500&display=swap" 
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

</head>
<body>

<section id="header">
        <a href="#"><img src="Logo.png" class="logo" alt=""></a>
     
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Women</a></li>
                <li><a href="men.php">Men</a></li>
                <li><a href="kids.php">Kids</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a class="active" href="about.php">About</a></li>
                
                <li><a href="cart.php"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a></li>
                <li><a href="login.php"><i class="fa-solid fa-right-to-bracket"></i></a></li>

            </ul>
        </div>

    </section>


    <h2>Add Product</h2>
    <form method="POST" action="">
        <label for="nume">Product Name:</label>
        <input type="text" name="nume" required>

        <label for="imagine">Image URL:</label>
        <input type="text" name="imagine" required>

        <label for="descriere">Description:</label>
        <input type="text" name="descriere" required>

        <label for="pret">Price:</label>
        <input type="number" name="pret" required>

        <label for="cantitate">Quantity:</label>
        <input type="number" name="cantitate" required>

        <button type="submit">Add Product</button>
    </form>

    <section id="newsletter" class="section-p1">
        <div class="newstext">
            <h4> Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our latest shop and <span>special offers</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="Logo.png" alt="">
            <h4>Contact</h4>
            <p><strong>Adress:</strong> Vasile Pârvan nr.10, Timișoara</p>
            <p><strong>Phone:</strong> 0736268964</p>
            <p><strong>Hours:</strong> 10:00 - 17:00</p>
        </div>
        <div class="col">
            <h4>About</h4>
            <a href="#"> About us</a>
            <a href="#"> Delivery Information</a>
            <a href="#"> Privacy Policy</a>
            <a href="#"> Contact Us</a>
        </div>
        <div class="col">
            <h4>My Account</h4>
            <a href="#"> Sign In</a>
            <a href="#"> View Cart</a>
            <a href="#"> My Wishlist</a>
            <a href="#"> Track My Order</a>
        </div>
        <div class="col payment">
            <p>Secured Payment Gateways</p>
            <img src="payment.png" alt="">
        </div>
    </footer>


    <script src="script.js"></script>
</body>
</body>
</html>