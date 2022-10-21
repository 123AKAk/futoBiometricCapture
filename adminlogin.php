<?php 
    require "assets/db.php";
    require "assets/varnames.php";
    require 'assets/sharedComponents.php';
    $components = new SharedComponents();

    session_start();

    if (isset($_SESSION["admin_blunt_blog_user_loggedin_"])){
        $_SESSION["admin_blunt_blog_user_loggedin_"] = $components->unprotect($_SESSION["admin_blunt_blog_user_loggedin_"]);
        if($_SESSION["admin_blunt_blog_user_loggedin_"] == true){
            $_SESSION["admin_blunt_blog_user_loggedin_"] = $components->protect($_SESSION["admin_blunt_blog_user_loggedin_"]);
            header("location: admin/index.php");
            exit;
        }
    }
    
    $signupmsg = "";
    if(isset($_GET["admsg"]))
        $signupmsg = "Sign Up Successful - Login in with your account details";
    if(isset($_GET["newadmsg"]))
        $signupmsg = "Account Password Reset Successful - Login in with new account details";

    // Define variables and initialize with empty values
    $email = $password = "";
    $email_err = $password_err = $_SESSION["email"] ="";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // Check if email is empty
        if (empty(trim($_POST["email"]))) {
            $email_err = "Enter your Email.";
        } else {
            $email = trim($_POST["email"]);
            $_SESSION["email"] = $email;
        }

        // Check if password is empty
        if (empty(trim($_POST["password"]))) {
            $password_err = "Enter your password.";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate credentials
        if (empty($email_err) && empty($password_err)) {
            // Prepare a select statement
            $sql = "SELECT * FROM admin WHERE email = :email";

            if ($stmt = $pdo->prepare($sql)) {

                // Set parameters
                $param_email = trim($_POST["email"]);

                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);


                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Check if email exists, if yes then verify password
                    if ($stmt->rowCount() == 1) {
                        if ($row = $stmt->fetch()) {

                            $id = $row["id"];
                            $username = $row["username"];
                            $hashed_password = $row["password"];

                            if (password_verify($password, $hashed_password)) 
                            {
                                session_start();
                                // Store data in session variables
                                $_SESSION["admin_blunt_blog_user_loggedin_"] = $components->protect("true");
                                $_SESSION["blunt_blog_user_status_"] = $components->protect($id);

                                // Redirect user to admin page
                                header("location: index.php");
                                exit;
                            }
                            else {
                                // Display an error message if password is not valid
                                $password_err = "The password you entered was Invalid.";
                            }
                        }
                    } else {
                        // Display an error message if username doesn't exist
                        $email_err = "No Admin Account found with that Email.";
                    }
                } else {
                    $email_err = "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }
        // Close connection
        unset($pdo);
    }
?>

<?php
// Initialize the session
// session_start();
// $loggedin = false;

// // Check if the user is already logged in, if yes then redirect him to welcome page
// if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
//    $loggedin = true;
    
// }

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- favicon -->
    <link rel="icon" sizes="16x16" href="assets/img/favicon.png">

    <!-- Title -->
    <title> Admin | Login </title>
  
    <!-- CSS Plugins -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">

    <!-- main style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <?php require "includes/metatags.php"; ?>
</head>

<body>

    <!--Login-->
    <section class="container">
    <br>
        <div class="section-heading">
            <div class="row">
                <div class="col-lg-6 col-md-8 m-auto">
                    <div class="login-content">
                        <h4> Admin Login</h4>
                        <p style="text-align: center; font-weight:bold; margin-bottom:20px;"><?= $signupmsg ?></p>
                        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="sign-form widget-form " method="POST">
                            <div class="form-group">
                                <input type="email" class="form-control <?= (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Email*" name="email" value="<?= (!empty($_SESSION["email"])) ? $_SESSION["email"] : ''; ?>">
                                <span class="invalid-feedback"><?= $email_err; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control <?= (!empty($password_err)) ? 'is-invalid' : ''; ?>"  placeholder="Password*">
                                <span class="invalid-feedback"><?= $password_err; ?></span>
                            </div>
                            <div class="sign-controls form-group">
                                <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberMe">
                                    <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                </div>
                                <a href="adminforgotpassword.php" class="btn-link ">Forgot Password?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-custom">Login</button>
                            </div>
                            <p class="form-group text-center">Don't have an account? <a href="adminsignup.php" class="btn-link">Create One</a> </p>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </section>

<?php
    include 'includes/scripts.php';
?> 