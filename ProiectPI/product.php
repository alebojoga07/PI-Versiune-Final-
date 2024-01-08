<?php
ini_set('display_errors', '0'); 

session_start();

include 'includes/db_connections.php';
if (!$conn) {
    die("Conexiunea la baza de date nu a putut fi stabilită: " . mysqli_connect_error());
}
// Fetch random clothes from the database
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

        // Get user ID (assuming it's stored in the session)
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;



$query = "SELECT p.*, AVG(r.rating) AS rating FROM produse p LEFT JOIN ratings r ON p.id = r.product_id  GROUP BY p.id ORDER BY RAND() LIMIT 4";
$result_random = mysqli_query($conn, $query);
$query = "SELECT p.* , AVG(r.rating) as rating FROM produse p
LEFT JOIN ratings r ON p.id = r.product_id where p.id = $productId";

//print_r($query);

$result_product = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result_product);


if ($product['imagine']==''){
    $imagine = "https://dummyimage.com/600x700/dee2e6/6c757d.jpg";
} 
else {

    $imagine = $product['imagine'];
}
$averageRating = round($product['rating']);
// Check for errors
if (!$result_random) {
    die("Query failed: " . mysqli_error($conn));
}

} else {
    die("Product ID not provided");
} 
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Item - <?=$product['nume']?></title>
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
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?=$imagine;?>" alt="..." /></div>
                    <div class="col-md-6">
                        <div class="d-flex text-warning mb-2 star" id="ratingStars" data-product-id="<?=$product['id']?>">


                        <?php
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $averageRating) {
                        echo '<i class="bi-star-fill"></i>';
                    } else {
                        echo '<i class="bi-star"></i>';
                    }
                }

                
                ?>
            </div>
                        <h1 class="display-5 fw-bolder"><?=$product['name']?></h1>
                        <div class="fs-5 mb-5">
                            <span><?=$product['pret']?> RON</span>
                        </div>
                        <p class="lead"><?=$product['descriere']?></p>
                        <form id="addproduct" method="post" action="add_to_cart.php">

                        <div class="d-flex">
                            
                        <input type="hidden" name="productId" value="<?=$product['id']; ?>">
                        <select name="selected_size" required style="max-width: 9rem; margin-right: 20px" />
                            <option value="" disabled selected>Select size</option>
                            <option value="XXL">XXL</option>
                            <option value="XL">XL</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="S">S</option>
                            <option value="XS">XS</option>
                        </select>
                           <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" name="quantity" style="max-width: 3rem" />
                           <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="add_to_cart">
                                <i class="bi-cart-fill me-1"></i>
                                Adaugă în coș
                            </button>
            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Related items section-->
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                



                <?php
            // Loop random clothes
            while ($product_random = mysqli_fetch_assoc($result_random)) {
                ?>
                <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?=$product_random['nume']?></h5>
                                            <!-- Product reviews-->
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                    <?php
                            $rating = $product_random['rating'];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<div class="bi-star-fill"></div>';
                                } 
                            }
                            ?>

                          
                                    </div>
                                    <!-- Product price-->
                                    <?=$product_random['pret']?> RON
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id=<?=$product_random['id']?>">Detalii produs</a></div>
                            </div>
                        </div>
                    </div>
                    
               
<?} ?>
                    
                </div>
            </div>
        </section>
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
   $(document).ready(function () {
    $('.star i').on('click', function () {
        var productId = $('#ratingStars').data('product-id');
        var rating = $(this).index() + 1; // Index + 1 pentru a obține rating-ul selectat
       // alert(productId);
        // Trimite datele către server utilizând AJAX
        $.ajax({
            type: 'POST',
            url: 'evaluate_product.php',
            data: { productId: productId, rating: rating },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Opțional: Gestionare cu succes, de exemplu, actualizare interfață
                    console.log('Rating added successfully');
                } else {
                    // Opțional: Gestionare eroare, de exemplu, afișare mesaj de eroare
                    console.error('Error adding rating: ' + response.error);
                }
            },
            error: function () {
                // Opțional: Gestionare eroare AJAX
                console.error('Error adding rating');
            }
        });


        setTimeout(function() {
  
        $.ajax({
            type: "GET",
            url: "/stars.php?pid=<?=$productId?>",
            dataType: 'json',
            success: function(data) {
                var dataArray = data;
                //alert(dataArray);
                // $("#cartcount").text(dataArray);
                //$("#ratingStars").remove();
                // $("#cartcount").addClass('bg-danger');
                var star = 0;
                $('#ratingStars i').each(function () {
                    star++;
                   // alert(star);
                var is_active = false;
                is_active = $(this).hasClass('bi-star-fill');
                $(this).removeClass();
        
                if (star <= dataArray )
                {
                    $(this).addClass('bi-star-fill');

                } else $(this).addClass('bi-star');
                var newcontent = '<a href="#">' + $(this).html() + "</a>";
                $(this).html(newcontent);
                });
            }
        });

    }, 300);
    });
});



    </script>
    
    </body>
</html>
