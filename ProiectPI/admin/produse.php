<?php
session_start();
ini_set('display_errors', '0'); 
include '../includes/db_connections.php';
if (!$conn) {
    die("Conexiunea la baza de date nu a putut fi stabilită: " . mysqli_connect_error());
}
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != true) {
    // Redirect to the login page if the user is not logged in
    header('Location: /login.php');
    exit;
}

if ($_POST['productID'] && $_POST['productID'] !="")
{
    $productID = $_POST['productID'];
$query = "DELETE FROM produse WHERE id = '$productID'";
$result = mysqli_query($conn, $query);

}
if ($_POST['productname'] && $_POST['productname'] !="")
{

    //print_r($_POST);
    $query = "INSERT INTO `produse` ( `nume`, `imagine`, `descriere`, `pret`, `cantitate`, `gender`) VALUES ( ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);


    // Check if the statement is prepared successfully
    if ($stmt) {
        $stmt->bind_param("ssssss", $_POST['productname'], $_POST['imagine'], $_POST['description'],$_POST['price'],$_POST['quantity'],$_POST['gender']);

        if ($stmt->execute()) {
            // Product into mysql 

        } else {
            // Query failed
            echo "failed";
        }

        $stmt->close();
    }

}


$query = "SELECT * FROM produse ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
$myItems = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
        <? include '../includes/menu.inc.php';?>

        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h3 class="display-4 fw-bolder">Panou Admin - Produse</h3>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
              
  
            <div class="row  justify-content-center">

<h2>Add Product</h2>
    <form method="POST" action="">
    <div class="form-group">
    <label>Product Name</label>
    <input type="text" name="productname" class="form-control" placeholder="Product Name">
     </div>
     <div class="form-group">
    <label>Description</label>
    <input type="text" name="description" class="form-control" placeholder="Description">
     </div>

     <div class="form-group">
    <label>Price</label>
    <input type="text" name="price" class="form-control" placeholder="Price">
     </div>

     <div class="form-group">
    <label>Quantity</label>
    <input type="text" name="quantity" class="form-control" placeholder="Quantity">
     </div>


     <div class="form-group">
    <label>Imagine</label>
    <input type="text" name="imagine" class="form-control" placeholder="Imagine">

     </div>
     <div class="form-group">

     <fieldset>

  <div>
    <input type="radio" id="men" name="gender" value="men" checked />
    <label for="men">Men</label>
  </div>

  <div>
    <input type="radio" id="women" name="gender" value="women" />
    <label for="women">Women</label>
  </div>


</fieldset>
</div>

      <br>
      <button type="submit" class="btn btn-primary">Add Product</button>
                  
    </form>

                <!-- start -->


<?php
        if (!empty($myItems)) {
?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Imagine</th>
      
      <th scope="col">Nume</th>
      <th scope="col">Descriere</th>
      <th scope="col">Pret</th>
      <th scope="col">Actiune</th>
    </tr>
  </thead>

  <?php
  $i=1;
            $pret_total = 0;
            foreach ($myItems as $item) {

                if ($item['imagine']==''){
                    $imagine = "https://dummyimage.com/450x300/dee2e6/6c757d.jpg";
                } 
                else {

                    $imagine = $item['imagine'];
                }

                //echo '<li>Product ID: ' . $item['product_id'] . ', Product Name: ' . $item['product_name'] . ', Product Pret: ' . $item['product_pret'] . ', Product Quantity: ' . $item['quantity'] . ' total: '.$item['quantity'] * $item['product_pret'].'</li>';
                // You can add other product details here
           ?>

  <tbody>
    <tr>
      <th scope="row"><?=$i++?></th>
      <td><img src=<?=$imagine?> width=300></td>
      <td><?=$item['nume']?></td>
      <td><?=$item['descriere']?></td>
     
      <td><?=$item['pret']?></td>

      <td>
    <form action="" method="post"><input type=hidden name=productID value="<?=$item['id']?>"><button class="btn btn-danger">Sterge</button></form>
</td>

    </tr>
   
  </tbody>

           <?php
           
            }
           ?>
           </table>


           <?php

            ?>
<br/>



            <br/><br/>
            <?php
        } else {
            echo '<p>Nu sunt produse in database .</p>';
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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="/js/scripts.js"></script>
    <script src="/script.js?dd"></script>
    <script>


    </script>

    </body>
</html>
