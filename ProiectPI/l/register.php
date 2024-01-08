<?php
// Include the database connection file
include 'includes/db_connections.php';

// Check if the $conn variable is defined
if (!$conn) {
    die("Database connection not available.");
}

// Initialize variables to store user input
$username = $password = $email = '';
$error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user input
    $username = htmlspecialchars(trim($_POST['username']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    // Check if all required fields are filled
    if (empty($username) || empty($password) || empty($email)) {
        $error = "All fields are required.";
    } else {
        // Insert user data into the database
        $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Check if the statement is prepared successfully
        if ($stmt) {
            $stmt->bind_param("sss", $username, $password, $email);

            if ($stmt->execute()) {
                // Registration successful
                header("Location: login.php"); // Redirect to login page
                exit();
            } else {
                // Registration failed
                $error = "Registration failed. Please try again.";
            }

            $stmt->close();
        } else {
            // Statement preparation failed
            $error = "Database error. Please try again later.";
        }
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
        <title>a-Shop - Login</title>
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



            <form action="register.php" method="post">
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
                     <label>Email</label>
                     <input type="text" name="email"  class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" name="password"  class="form-control" placeholder="Password">
                  </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Register</button>
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
