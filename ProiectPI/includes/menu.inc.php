<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand">CoolOutfits</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">Home</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="#!">Despre</a></li> -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/shop.php">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="/shop.php?cat=men">Men</a></li>
                                <li><a class="dropdown-item" href="/shop.php?cat=women">Women</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Cont</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    
                         <?php
                             $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
                             $isAdmin = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : null;
                             if ( $userId !== null) {?>
                                <li><a class="dropdown-item" href="/comenzi.php">Istoric Comenzi</a></li>
                                <li><a class="dropdown-item" href="/logout.php">Logout</a></li>
                        <!-- start admin -->
                        <?php if ( $isAdmin ) {?>
                        <li><a class="dropdown-item" href="/admin/index.php">Admin - Comenzi</a></li>
                        <li><a class="dropdown-item" href="/admin/produse.php">Admin - Produse</a></li>
                        
                        <?php }?>
                        <!-- end admin -->
                             
                             <?php
                             } else { ?>
                         
                                <li><a class="dropdown-item" href="/login.php">Login</a></li>
                                <li><a class="dropdown-item" href="/register.php">Register</a></li>

                            <?php } ?>
                            </ul>

                        </li>



                        <form class="navbar-search pull-right" action="shop.php" method="get">
  <input type="text" class="search-query" placeholder="Search" name="q">
</form>  

                    </ul>
 
                        <a class="btn btn-outline-dark " href="/cart.php" >
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span id="cartcount" class="badge bg-dark text-white ms-1 rounded-pill">0</span>
</a>
                </div>
            </div>
        </nav>