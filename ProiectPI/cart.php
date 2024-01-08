<?php
ini_set('display_errors', '0'); 

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

if ($_POST['cartID']){
    $cartID = $_POST['cartID'];
    $query = "DELETE FROM `cart` WHERE `cart`.`id` = $cartID";
    $result = mysqli_query($conn, $query);
}



if ($_REQUEST['get'] && $_REQUEST['get'] == 'sum'){

    // extragem numarul de produse din cos

    // Fetch cart items for the logged-in user
$query = "SELECT c.quantity, SUM(c.quantity) as SUM FROM cart c JOIN produse p ON c.product_id = p.id WHERE c.user_id = $userId";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch cart items as an associative array
$cartItemsSum = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Free result set
mysqli_free_result($result);

// Close the connection
mysqli_close($conn);
die($cartItemsSum[0]['SUM']);
}

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

// Free result set
mysqli_free_result($result);

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CoolOutfits</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <? include 'includes/menu.inc.php';?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With us</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <div class="container px-4 px-lg-5 mt-5">
<h2>CART ITEMS</h2>
<?php
        if (!empty($cartItems)) {
?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Foto</th>
      
      <th scope="col">Nume</th>
      <th scope="col">Bucati</th>
      <th scope="col">Pret Unitar</th>
      <th scope="col">Actiune</th>
    </tr>
  </thead>

  <?php
  $i=1;
            $pret_total = 0;
            foreach ($cartItems as $item) {
            $pret_total = $pret_total + $item['quantity'] * $item['product_pret'];


                //echo '<li>Product ID: ' . $item['product_id'] . ', Product Name: ' . $item['product_name'] . ', Product Pret: ' . $item['product_pret'] . ', Product Quantity: ' . $item['quantity'] . ' total: '.$item['quantity'] * $item['product_pret'].'</li>';
                // You can add other product details here
           ?>

  <tbody>
    <tr>
      <th scope="row"><?=$i++?></th>
      <td><img width=300  src=<?=$item['imagine']?>></td>
      <td><?=$item['product_name']?></td>
      <td><?=$item['quantity']?></td>
     
      <td><?=$item['product_pret']?></td>

      <td><form action="cart.php" method="post"><input type=hidden name=cartID value="<?=$item['id']?>"><button class="btn btn-danger">Sterge</button></form></td>

    </tr>
   
  </tbody>

           <?php
           
            }
           ?>
           </table>


           <?php

            ?>
            <h2>pret total: <?=$pret_total?> RON</h2>
<br/>


<form action="place_order.php" method="post">
            <? if ($error){?>
                <div class="form-group text-danger">
            <?=$error;?>
            </div>  
                <?php } ?>

                  <div class="form-group">
                     <label>Nume</label>
                     <input type="text" name="nume" class="form-control" placeholder="Nume" required>
                  </div>
                  <div class="form-group">
                     <label>Adresa</label>
                     <input type="text" name="adresa"  class="form-control" placeholder="Adresa" required>
                  </div>

                  <div class="form-group">
                     <label>Telefon</label>
                     <input type="text" name="telefon"  class="form-control" placeholder="Telefon" required>
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Plaseaza Comanda</button>
               </form>
            <br/><br/>
            <?php
        } else {
            echo '<p>Your shopping cart is empty.</p>';
        }
        ?>




</div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js?s"></script>
    </body>
</html>
