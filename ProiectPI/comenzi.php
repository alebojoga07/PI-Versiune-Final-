<?php
ini_set('display_errors', '0'); 

session_start();
include 'includes/db_connections.php';
if (!$conn) {
    die("Conexiunea la baza de date nu a putut fi stabilită: " . mysqli_connect_error());
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['id']; // Assuming 'id' is the user ID field in your users table


$query = "SELECT * FROM orders WHERE user_id = '$userId' ORDER by order_id DESC";
$result_comenzi = mysqli_query($conn, $query);


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
        <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <? include 'includes/menu.inc.php';?>

        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h3 class="display-4 fw-bolder">Istoric Comenzi</h3>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row  justify-content-center">
<!-- start -->

<?php
  $i=0;
while ($product = mysqli_fetch_assoc($result_comenzi)) {
  $i++;
    //print($product['order_id']);
   // print("<br>");
    ?>
      <p>
  <a class="btn <? if ($product['status']=='expediat') {echo "btn-secondary ";} else echo " btn-primary";?>" data-bs-toggle="collapse" href="#collapseExample<?=$i?>" role="button" aria-expanded="false" aria-controls="collapseExample<?=$i?>">
    comanda: #<?=$product['order_id']?> Status: <?=$product['status']?>
  </a>

</p>
<div class="collapse" id="collapseExample<?=$i?>">
  <div class="card card-body">
  Nume: <?=$product['nume']?> <br>
Adresa: <?=$product['adresa']?> <br>
Telefon: <?=$product['telefon']?> <br>
Comanda: 
<?
$items = $product['comanda'];
 $arr = json_decode($items);

foreach($arr as $item){

    echo '<li>Product ID: ' . $item->product_id . ', Product Name: ' . $item->product_name . ', Product Pret: ' . $item->product_pret . ', Product Quantity: ' . $item->quantity . '</li>';

}
echo '<li> Ramburs: <b>' . $product['total_price'] . ' RON </b></li>';

?>    
</div>
</div>
    <?php
}

?>
      


                <!-- END -->
            </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="/js/scripts.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="/script.js?dd"></script>
    <script>


    </script>

    </body>
</html>
