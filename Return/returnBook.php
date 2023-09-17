<?php
    include("../database.php");

    $error = ""; $isbn = "";
    $row = "";

    if (isset($_POST["search"])) {
        if (empty($_POST["isbn"])) {
            $error = "Please enter the ISBN of the book!";
        }
        else {
            $error = "";
            $isbn = $_POST["isbn"];
            $check = "SELECT * from borrow where isbn='$isbn' and returned_date is null";
    
            $result1 = mysqli_query($connection, $check);
            $row = mysqli_fetch_assoc($result1);
    
            if (mysqli_num_rows($result1)==0) {
                $error = "The book is not issued!";
            }
            else {
            
            }
        }

    }
    $days = ""; $fine = "";
    if (isset($_POST["return"])) {
        $isbn = $_POST["isbn"];
        $return = date('y-m-d', strtotime($_POST["returndate"]));
        $fine = $_POST['fine'];

        if (empty($_POST["return"]) || empty($_POST["fine"])) {
            $error = "All fields are required!";
        }
        else {
            $sql1 = "update book set status='Available' where isbn='$isbn'";
            mysqli_query($connection, $sql1);
            $sql2 = "update borrow set returned_date='$return', fine='$fine' where isbn='$isbn' and returned_date is null";
            mysqli_query($connection, $sql2);
            $error = "";
            echo "<script> alert('The book successfully returned!') </script>";
            $isbn = "";
    }
        }
        
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Return Book</title>
</head>
<body>

    <div class="container">
        <div class="side-bar">
            <div class="logo"><img src="../images/logo.png" alt=""> <span>Library</span></div>
            <ul>
                <li><a href="../dashboard.php">dashboard</a></li>
                <li ><a href="../Books/addBook.php">add books</a></li>
                <li><a href="../Members/addMember.php">add members</a></li>
                <li><a href="../Issue/issueBook.php">issue books</a></li>
                <li class="active"><a href="../Return/returnBook.php">return books</a></li>
                <li><a href="../Issue/issuedBooks.php">View issued books</a></li>
                <li><a href="../Return/returnedBooks.php">View returned books</a></li>
                <li><a href="../Books/allBooks.php">view all books</a></li>
                <li><a href="../Members/allMembers.php">view all members</a></li>
                <li><a href="../Login/logout.php">log out</a></li>
            </ul>
        </div>
        <div class="add return">
            <form action="returnBook.php" method="post">
                <h1>Return Books Details</h1>
                <div class="error-msg"><?php echo "$error"; ?></div>
                <div class="input-return-book">
                    <input type="text" placeholder="Enter ISBN of Book" name="isbn" value="<?php echo "$isbn"; ?>">
                    <input type="submit" value="Search" name="search">
                </div>
                <?php if ($row) { ?>
                    
                    <div class="hide-content">
                        <table border="1px">
                            <tr>
                                <th>ISBN of Book</th>
                                <th>Student ID</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                            </tr>
                            <tr>
                                <td><?php echo $row["isbn"] ?></td>
                                <td><?php echo $row["member_id"] ?></td>
                                <td><?php echo $row["issue_date"] ?></td>
                                <td><?php echo $row["due_date"] ?></td>
                            </tr>
                        </table>
                        <div class="input-box">
                            <label for="duedate">Return Date: </label>
                            <input type="date" id="returndate" name="returndate">
                            <label for="fine">Fine(Rs.) : </label>
                            <input type="text" id="fine" name="fine" value="0.0">
                            <div class="btns">
                                <input type="submit" value="Cancel" class="clear">
                                <input type="submit" value="Return" name="return">
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </form>
        </div>
    </div>









    <script src="script/script.js"></script>
</body>
</html>