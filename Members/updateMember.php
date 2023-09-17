<?php

    include("../database.php");

    $error = "";
    $id = ""; $fname = ""; $lname = ""; $email = ""; $phone = ""; $city = ""; $faculty = "";
    $pattern1 = "/[^0-9]/"; $pattern2 = "/[^A-Za-z ]/"; $pattern3 = "/[^A-Za-z0-9.- ]/";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];


        $query = "select * from member where id='$id'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $fname = $row["fname"];
        $lname = $row["lname"];
        $email = $row["email"];
        $city = $row["city"]; 
        $phone = $row["phone"];
        $faculty = $row["faculty"];
    }

    if (isset($_POST["add"])) {
        if (empty($_POST["id"]) || empty($_POST["fname"]) || empty($_POST["lname"]) || empty($_POST["phone"]) || empty($_POST["email"]) || empty($_POST["city"])) {
            echo "phone $phone";
            $error = "All the fields are requirded!";
        }
        else { 
            $id = $_POST["id"];
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $email = $_POST["email"];
            $city = $_POST["city"];
            $phone = $_POST["phone"];
            $faculty = $_POST["faculty"];
            $error = "";
            if (preg_match($pattern2, $fname)) {
                $error = "First name must have only letters.";
            }
            else if (preg_match($pattern2, $lname)) {
                $error = "Last name must have only letters.";
            }
            else if (preg_match($pattern2, $city)) {
                $error = "City must have only letters.";
            }
            else if (preg_match($pattern1, $phone) || strlen($phone) != 10) {
                $error = "Phone number must have 10 digits.bla ";
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format";
            } 
            else if ($faculty === "Faculty") {
                $error = "Please select the faculty of the student!";
            }
            else {
                if ($error=="") {
                    $updateSql = "update member set id = '$id', fname = '$fname', lname = '$lname', email = '$email', phone = '$phone', city = '$city', faculty = '$faculty' where id = '$id'";
                    mysqli_query($connection, $updateSql);
                    $error = "";
                    echo "<script> alert('The member details updated successfully!') </script>";
                    $id = ""; $fname = ""; $lname = ""; $email = ""; $phone = ""; $city = ""; $_POST["faculty"]="Faculty";
                }
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
    <title>Update Members</title>
</head>
<body>
<div class="container">
        <div class="side-bar">
        <div class="logo"><img src="../images/logo.png" alt=""> <span>Library</span></div>
        <ul>
                <li><a href="../dashboard.php">dashboard</a></li>
                <li><a href="../Books/addBook.php">add books</a></li>
                <li><a href="../Members/addMember.php">add members</a></li>
                <li><a href="../Issue/issueBook.php">issue books</a></li>
                <li><a href="../Return/returnBook.php">return books</a></li>
                <li><a href="../Issue/issuedBooks.php">View issued books</a></li>
                <li><a href="../Return/returnedBooks.php">View returned books</a></li>
                <li><a href="../Books/allBooks.php">view all books</a></li>
                <li><a href="../Members/allMembers.php">view all members</a></li>
                <li class="active"><a href="../Books/updateMember.php">Update Members</a></li>
                <li><a href="../Login/logout.php">log out</a></li>
            </ul>
        </div>
        <div class="add">
            <form action="updateMember.php" method="post">
                <h1>Enter New Member Details</h1>
                <div class="error-msg"><?php echo "$error"; ?></div>
                <input type="text" placeholder="Student ID" name="id" value="<?php echo $id; ?>">
                <input type="text" placeholder="First Name" name="fname"  value="<?php echo $fname; ?>">
                <input type="text" placeholder="Last Name" name="lname" value="<?php echo $lname; ?>">
                <input type="email" placeholder="Email Address" name="email" value="<?php echo $email; ?>">
                <input type="text" placeholder="Phone number" name="phone" value="<?php echo $phone; ?>">
                <input type="text" placeholder="City" name="city" value="<?php echo $city; ?>" >
                <select name="faculty" id="">
                    <option value="Faculty"  <?php if (isset($_GET['id']) && $faculty=="Faculty") echo "selected"; ?>>Faculty</option>
                    <option value="Faculty of Science" <?php if (isset($_GET['id']) && $faculty=="Faculty of Science") echo "selected"; ?>>Faculty of Science</option>
                    <option value="Faculty of Commerce and Management" <?php if (isset($_GET['id']) && $faculty=="Faculty of Commerce and Management") echo "selected"; ?>>Faculty of Commerce and Management</option>
                    <option value="Faculty of Humanities" <?php if (isset($_GET['id']) && $faculty=="Faculty of Humanities") echo "selected"; ?>>Faculty of Humanities</option>
                    <option value="Faculty of Medicine" <?php if (isset($_GET['id']) && $faculty=="Faculty of Medicine") echo "selected"; ?>>Faculty of Medicine</option>
                    <option value="Faculty of Computing and Technology" <?php if (isset($_GET['id']) && $faculty=="Faculty of Computing and Technology") echo "selected"; ?>>Faculty of Computing and Technology</option>
                    <option value="Faculty of Social Science" <?php if (isset($_GET['id']) && $faculty=="Faculty of Social Science") echo "selected"; ?>>Faculty of Social Science</option>
                </select>
                <div class="btns">
                    <input type="submit" value="Clear" name="clear" class="clear">
                    <input type="submit" value="Update" name="add">
                </div>
                
        
            </form>
        </div>
    </div>

    <script src="script/script.js"></script>
</body>
</html>