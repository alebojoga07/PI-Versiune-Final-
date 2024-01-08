<?php
session_start();
ini_set('display_errors', '0'); 

include 'includes/db_connections.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);    

    // Adaugă $password în baza de date
    error_log("Username introdus: $username, Password introdus: $password");

    // Validate the user's credentials directly
    $query = "SELECT * FROM users WHERE username = ? LIMIT 1";

    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();

        $passwordFromForm = $_POST['password'];

        if ($user_data) {
            
            if (password_verify($passwordFromForm, $user_data['password'])) {            
                // Set user session upon successful login
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['id'] = $user_data['id'];
                $_SESSION['isAdmin'] = $user_data['isAdmin'];

                // Mesaj de debug pentru a confirma că s-a efectuat autentificarea cu succes
                error_log("Autentificare cu succes. Redirectare către index.php");

                // Mesaj de debug pentru a afișa parola hasuită generată pentru test
                $testPassword = password_hash($passwordFromForm, PASSWORD_DEFAULT);
                error_log("Parola hasuită pentru test: $testPassword");
        
                // Mesaj de debug pentru a afișa rezultatul funcției password_verify
                $passwordVerificationResult = password_verify($passwordFromForm, $user_data['password']);
                error_log("Rezultatul verificării parolei: " . var_export($passwordVerificationResult, true));
               
                header("Location: index.php"); // Redirect to your welcome page or dashboard
                exit();
            } else {
                // Invalid credentials
                $error = "Invalid username or password. Please try again.";
                // Mesaj de debug pentru a afișa erorile posibile la autentificare
                error_log("Eroare la autentificare: $error");
                error_log("Parola introdusă: $passwordFromForm, Hash din baza de date: {$user_data['password']}");

                $passwordVerificationResult = password_verify($passwordFromForm, $user_data['password']);
                error_log("Rezultatul verificării parolei: " . var_export($passwordVerificationResult, true));
            }

            $stmt->close();
        } else {       
            
            $error = "Invalid username or password. Please try again.";

        }
       
    } else {
        // Invalid username
        $error = "Invalid username or password. Please try again.";
        
        // Mesaj de debug pentru a afișa username-ul introdus
        error_log("Eroare la autentificare: $error");
        error_log("Username introdus: $username");
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CoolOutfits - Login</title>
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

                <!-- Login -->



            <form action="login.php" method="post">
            <? if ($error){?>
                <div class="form-group text-danger">
            <?=$error;?>
            </div>  
                <?php } ?>

                  <div class="form-group">
                     <label>User Name</label>
                     <input type="text" name="username" class="form-control" placeholder="User Name">
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" name="password"  class="form-control" placeholder="Password">
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Login</button>
                  <a href="register.php" class="btn btn-secondary">Register</a>
               </form>


                <!-- END -->
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

    </body>
</html>
