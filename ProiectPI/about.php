<?php
session_start();
include 'includes/db_connections.php';

$query = "SELECT * FROM produse WHERE id IN (1, 2, 7, 14)";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
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

    <section id="page-header" class="about-header">
        <h2>#KNOW US </h2>
        <p>Thank you for choosing CoolOutfits. Let's redefine fashion together!</p>
    </section>

    <section id="about-head" class="section-p1">
        <img src="Comm.jfif" alt="">
        <div>
           <h2> Who We Are?</h2> 
           <p>Join us on this style adventure.
             CoolOutfits is more than a brand; it's a movement that empowers you to embrace your unique style journey
            . Thank you for being part of our community.</p>
        </div>
    </section>

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


</body>