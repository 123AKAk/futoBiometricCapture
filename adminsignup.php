<?php 
require "assets/db.php";
require "assets/varnames.php";
require 'assets/sharedComponents.php';
$components = new SharedComponents();

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["admin_blunt_blog_user_loggedin_"])){
    $_SESSION["admin_blunt_blog_user_loggedin_"] = $components->unprotect($_SESSION["admin_blunt_blog_user_loggedin_"]);
    if($_SESSION["admin_blunt_blog_user_loggedin_"] == true){
        $_SESSION["admin_blunt_blog_user_loggedin_"] = $components->protect($_SESSION["admin_blunt_blog_user_loggedin_"]);
        header("location: admin/index.php");
        exit;
    }
}

// else if(isset($_GET["arch"])){
//     if($_GET["arch"] !== "adminsignup"){
//         header("location: index.php");
//         exit;
//     }
// }


// Define variables and initialize with empty values
$username = $email = $password = $confrimpassword = "";
$username_err = $email_err = $password_err = $confrimpassword_err = $agreement_err = $agreed ="";
$_SESSION["main_err"] = $_SESSION["username"] = $_SESSION["email"] = $_SESSION["password"] = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Enter your Username.";
    }
    else {
        $username = trim($_POST["username"]);
        $_SESSION["username"] = $username;
    }

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Enter your Email.";
    }
    else {
        $email = trim($_POST["email"]);
        $_SESSION["email"] = $email;
    }

    // Check if all password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Enter your Password.";
    }    
    else if (empty(trim($_POST["confrimpassword"]))) {
        $_SESSION["password"] = trim($_POST["password"]);
        $confrimpassword_err = "Confrim your Password.";
    }
    else if ($_POST["confrimpassword"] != $_POST["password"]){
        $confrimpassword_err = "Passwords does not Match.";
    }
    else {
        $password = trim($_POST["password"]);
    }

    // Check if agreement is checked
    if (isset($_POST["terms"]) == "check")
    {
        $agreed = "agreed";
        // Validate credentials
        if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confrimpassword_err)) {
            // Prepare a select statement
            $sql = "SELECT * FROM admin WHERE email = :email";

            if ($stmt = $pdo->prepare($sql)) {

                // Set parameters
                $param_email = trim($_POST["email"]);

                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Check if username exists, if yes then verify password
                    if ($stmt->rowCount() == 1) {
                        // Display an error message if email exist
                        $email_err = "There is an account with that Email.";
                        return;
                    }
                    else
                    {

                        //hash password
                        $hashpassword = password_hash($password, PASSWORD_DEFAULT);

                        $data = array(
                            "email" => $components->test_input($_POST["email"]),
                            "username" => $components->test_input($_POST["username"]),
                            "password" => $components->test_input($hashpassword)
                        );
        
                        // Get keys string from data array
                        $columns = $components->implodeArray(array_keys($data));

                        // Get values string from data array with prefix (:) added
                        $prefixed_array = preg_filter('/^/', ':', array_keys($data));
                        $values = $components->implodeArray($prefixed_array);

                        try {
                            $sql = "INSERT INTO admin ($columns) VALUES ($values)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($data);

                            header("Location: adminlogin.php?admsg=active");
                        } 
                        catch (PDOException $error) {
                            $_SESSION["main_err"] = "Error: ".$error;
                        }
                    }
                } else {
                    $_SESSION["main_err"] = "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
            else
            $_SESSION["main_err"] = "Error checking Account Details";
        }
    }
    else
    {
        $agreement_err = "Our Terms & Agreement has not been accepted.";
    }
    // Close connection
    unset($pdo);
}
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
    <title> Admin | Signup </title>
  
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
    <section class="container" style="margin-bottom:0px; margin-top:40px">
        <div class="">
            <div class="row">
                <div class="col-lg-6 col-md-8 m-auto">
                    <div class="login-content">
                        <h4>Admin Signup</h4>
                        <!--form-->              
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="sign-form widget-form" method="POST">
                        
                            <p style="color:darkred;">
                                <?= (!empty($_SESSION["main_err"])) ? $_SESSION["main_err"] : ''; ?>
                            </p>

                            <hr>

                            <div class="form-group">
                                <input type="text" class="form-control <?= (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Full Name*" name="username" value="<?= (!empty($_SESSION["username"])) ? $_SESSION["username"] : ''; ?>">
                                <span class="invalid-feedback"><?= $username_err; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control <?= (!empty($email_err)) ? 'is-invalid' : ''; ?>" placeholder="Email Address*" name="email" value="<?= (!empty($_SESSION["email"])) ? $_SESSION["email"] : ''; ?>">
                                <span class="invalid-feedback"><?= $email_err; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control <?= (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password*" name="password" value="<?= (!empty($_SESSION["password"])) ? $_SESSION["password"] : ''; ?>">
                                <span class="invalid-feedback"><?= $password_err; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control <?= (!empty($confrimpassword_err)) ? 'is-invalid' : ''; ?>" placeholder="Confrim Password*" name="confrimpassword" value="">
                                <span class="invalid-feedback"><?= $confrimpassword_err; ?></span>
                            </div>

                            <div class="sign-controls form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="terms" class="custom-control-input <?= (!empty($agreement_err)) ? 'is-invalid' : ''; ?>" id="rememberMe" value="check" <?= (!empty($agreed)) ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="rememberMe">
                                        I Agree to Blunt <a href="privacy.php" class="btn-link">terms & conditions</a> 
                                    </label>
                                    <span class="invalid-feedback"><?= $agreement_err; ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn-custom">Sign Up</button>
                            </div>
                            <p class="form-group text-center">Already have an account? <a href="adminlogin.php" class="btn-link">Login</a> </p>
                        </form>
                           <!--/-->
                    </div> 
                </div>
             </div>
        </div>
    </section>       
<br>
<?php
    
    include 'includes/scripts.php';
?> 