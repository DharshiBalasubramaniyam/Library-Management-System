<?php
    include("database.php");

    $error = "";
    $id = ""; $fname = ""; $lname = ""; $email = ""; $phone = ""; $city = ""; $faculty = "";

    if (isset($_POST["clear"])) {
        $error = ""; $success="";
        $id = ""; $fname = ""; $lname = ""; $email = ""; $phone = ""; $city = ""; $_POST["faculty"]="Faculty";
    }

    if (isset($_POST["add"])) {
        $id = $_POST["id"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $city = $_POST["city"];
        $phone = $_POST["phone"];
        $faculty = $_POST["faculty"];
        if (empty($_POST["id"]) || empty($_POST["fname"]) || empty($_POST["lname"]) || empty($_POST["phone"]) || empty($_POST["email"]) || empty($_POST["city"])) {
            $error = "All the fields are requirded!";
        }
        else { 
            $error = "";
            if (preg_match("/[^A-Za-z ]/", $fname)) {
                $error = "First name must have only letters.";
            }
            else if (preg_match("/[^A-Za-z ]/", $lname)) {
                $error = "Last name must have only letters.";
            }
            else if (preg_match("/[^A-Za-z- ]/", $city)) {
                $error = "City must have only letters.";
            }
            else if (preg_match("/[^0-9]/", $phone) || strlen($phone) != 10) {
                $error = "Phone number must have 10 digits.";
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format";
            } 
            else if ($faculty === "Faculty") {
                $error = "Please select the faculty of the student!";
            }
            else {
                $check = "SELECT * from member where id='$id'";
    
                $result1 = mysqli_query($connection, $check);
                if (mysqli_num_rows($result1)>0) {
                    $error = "This given student id already exists";
                }
                
                if ($error=="") {
                    $insertSql = "INSERT INTO member(id, fname, lname, email,phone, city, faculty) 
                    VALUES('$id', '$fname', '$lname', '$email', '$phone', '$city', '$faculty')";
                    mysqli_query($connection, $insertSql);
                    $error = "";
                    echo "<script> alert('The Member successfully added to the system!') </script>";
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
    <link rel="stylesheet" href="styles/style.css">
    <title>Add Members</title>
</head>
<body>
    <div class="container">
        <div class="side-bar">
        <div class="logo"><img src="images/logo.png" alt=""> <span>Library</span></div>
            <ul>
                <li><a href="dashboard.php">dashboard</a></li>
                <li><a href="addBook.php">add books</a></li>
                <li class="active"><a href="addMember.php">add members</a></li>
                <li><a href="issueBook.php">issue books</a></li>
                <li><a href="returnBook.php">return books</a></li>
                <li><a href="issuedBooks.php">View issued books</a></li>
                <li><a href="returnedBooks.php">View returned books</a></li>
                <li><a href="allBooks.php">view all books</a></li>
                <li><a href="allMembers.php">view all members</a></li>
                <li><a href="logout.php">log out</a></li>
            </ul>
        </div>
        <div class="add">
            <form action="addMember.php" method="post">
                <h1>Member Details</h1>
                <div class="error-msg"><?php echo "$error"; ?></div>
                <input type="text" placeholder="Student ID" name="id" value="<?php echo $id; ?>">
                <input type="text" placeholder="First Name" name="fname"  value="<?php echo $fname; ?>">
                <input type="text" placeholder="Last Name" name="lname" value="<?php echo $lname; ?>">
                <input type="email" placeholder="Email Address" name="email" value="<?php echo $email; ?>">
                <input type="text" placeholder="Phone number" name="phone" value="<?php echo $phone; ?>">
                <input type="text" placeholder="City" name="city" value="<?php echo $city; ?>" >
                <select name="faculty" id="">
                    <option value="Faculty"  <?php if (isset($_POST["add"]) && $_POST["faculty"]=="Faculty") echo "selected"; ?>>Faculty</option>
                    <option value="Science" <?php if (isset($_POST["add"]) && $_POST["faculty"]=="Science") echo "selected"; ?>>Science</option>
                    <option value="Commerce and Management" <?php if (isset($_POST["add"]) && $_POST["faculty"]=="Commerce and Management") echo "selected"; ?>>Commerce and Management</option>
                    <option value="Humanities" <?php if (isset($_POST["add"]) && $_POST["faculty"]=="Humanities") echo "selected"; ?>>Humanities</option>
                    <option value="Medicine" <?php if (isset($_POST["add"]) && $_POST["faculty"]=="Medicine") echo "selected"; ?>>Medicine</option>
                    <option value="Computing and Technology" <?php if (isset($_POST["add"]) && $_POST["faculty"]=="Computing and Technology") echo "selected"; ?>>Computing and Technology</option>
                    <option value="Social Science" <?php if (isset($_POST["add"]) && $_POST["faculty"]=="Social Science") echo "selected"; ?>>Social Science</option>
                </select>
                <div class="btns">
                    <input type="submit" value="Clear" name="clear" class="clear">
                    <input type="submit" value="Add" name="add">
                </div>
                
        
            </form>
        </div>
    </div>

    <script src="script/script.js"></script>

</body>
</html>
