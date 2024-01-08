<?php
session_start();
include 'includes/db_connections.php';
if (!$conn) {
    die("Conexiunea la baza de date nu a putut fi stabilită: " . mysqli_connect_error());
}

if (isset($_REQUEST['cat']))
{
    $cat = $_REQUEST['cat'];
}
else { $cat = null;
}
// Fetch clothes from the database

if (isset($_REQUEST['pageno'])) {
    $pageno = $_REQUEST['pageno'];
} else {
    $pageno = 1;
}


$no_of_records_per_page = 8;
$offset = ($pageno-1) * $no_of_records_per_page; 
$where = "";
if (isset($cat) && $cat !== ""){
$where = "WHERE  gender = '$cat'";
}

if ($_GET['q'] && $_GET['q'] != '') { 
$search = $_GET['q'];
    $total_pages_sql = "SELECT COUNT(*) FROM produse  WHERE descriere LIKE '%$search%'";
    $query = "SELECT p.*, AVG(r.rating) AS rating FROM produse p LEFT JOIN ratings r ON p.id = r.product_id  WHERE descriere LIKE '%$search%' GROUP BY p.id LIMIT $offset, $no_of_records_per_page";


}

else {
    $total_pages_sql = "SELECT COUNT(*) FROM produse  $where";

    $query = "SELECT p.*, AVG(r.rating) AS rating FROM produse p LEFT JOIN ratings r ON p.id = r.product_id $where GROUP BY p.id LIMIT $offset, $no_of_records_per_page";

}
$result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);


  //print_r($query);
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>a-Shop</title>
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
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                <?php
            // Loop through all's clothes
            while ($product = mysqli_fetch_assoc($result)) {

                if ($product['imagine']==''){
                    $imagine = "https://dummyimage.com/450x300/dee2e6/6c757d.jpg";
                } 
                else {

                 $imagine = $product['imagine'];
                }
                ?>
                <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top img-fluid" src="<?=$imagine?>"  alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?=$product['nume']?></h5>
                                            <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                    <?php
                            $rating = $product['rating'];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<div class="bi-star-fill"></div>';
                                } 
                            }
                            ?>

                          
                                    </div>
                                    <!-- Product price-->
                                    <?=$product['pret']?> RON
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id=<?=$product['id']?>">Detalii produs</a></div>
                            </div>
                        </div>
                    </div>
                    
               
<?} ?>
                      
                        </div>
                                 
         
                            
                        <div class="container ">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                        <nav class="text-center row justify-content-center ">
  <ul class="pagination text-center">
    <li class="page-item"><a class="page-link" href="?cat=<?=$cat?>&pageno=1">First</a></li>
    <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
        <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?cat=$cat&pageno=".($pageno - 1); } ?>">Prev</a>
    </li>
    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
        <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?cat=$cat&pageno=".($pageno + 1); } ?>">Next</a>
    </li>
    <li class="page-item"><a class="page-link" href="?cat=<?=$cat;?>&pageno=<?php echo $total_pages; ?>">Last</a></li>
    

</ul>
</nav>
                        </div></div>
                        </section>
                        
                <!-- END -->

            
 

        
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js?"></script>
    <script>


    </script>

    </body>
</html>
