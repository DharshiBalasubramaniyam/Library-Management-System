
<?php
    session_start();

    include('../database.php');
    $error = "";
    $email=""; $password="";

    if(isset($_POST['login'])){
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result)==0) {
                $error = "Invalid username or password!";
            }
            else {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['first_name'] = $row['fname'];
                $_SESSION['last_name'] = $row['lname'];
                header('location: ../dashboard.php');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>LMS-Login</title>
</head>
<body>
    <div class="home">
        <div class="login-box">
            <div class="left">
            <div class="logo"><img src="../images/logo.png" alt=""> <span>Library</span></div>

            </div>
            <div class="right">
                <h1>Wecome Back Librarian!</h1>
                <h2>Login Now!</h2>
                <form action="login.php" method="post">
                    <div class="error-msg">
                        <?php echo $error ?>
                    </div>
                    <input type="email" name="email" placeholder="Your Email address" value="<?php echo $email; ?>">
                    <input type="password" name="password" placeholder="Password" <?php echo $password; ?>>
                    <input type="submit" value="Login" name="login">
                </form>
                <p>If you need assistance or have any questions feel free to reach out to our support team.</p>
            </div>
        </div>
    </div>
</body>
</html>