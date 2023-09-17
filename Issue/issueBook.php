<?php
    include("database.php");

    $error = "";
    $isbn = ""; $id = ""; $issue = ""; $due = "";

    if (isset($_POST["submit"])) {
        $isbn = $_POST["isbn"];
        $id = $_POST["id"];
        if (empty($_POST["isbn"]) || empty($_POST["id"]) || empty($_POST["issue"]) || empty($_POST["due"])) {
            $error = "All the fields are requirded!";
        }
        else { 

            $check1 = "SELECT * from book where isbn='$isbn'";
            $check2 = "SELECT * from member where id='$id'";
            $result1 = mysqli_query($connection, $check1);
            $result2 = mysqli_query($connection, $check2);

            $row = mysqli_fetch_assoc($result1);
            if (mysqli_num_rows($result1)==0) {
                $error = "There is no book with given ISBN!";
            }
                
            else if ($row["status"] === "Not Available") {
                $error = "The book is currently not available in library!";
            }
            else if (mysqli_num_rows($result2)==0) {
                $error = "There is no member with given student id!";
            }
            else {
                $issue = date('y-m-d', strtotime($_POST["issue"]));
                $due = date('y-m-d', strtotime($_POST["due"]));
                $insertSql = "INSERT INTO borrow(isbn, member_id, issue_date, due_date) 
                    VALUES('$isbn', '$id', '$issue', '$due')";
                mysqli_query($connection, $insertSql);
               
                $sql = "update book set status='Not Available' where isbn='$isbn'";
                mysqli_query($connection, $sql);
                $error = "";
                echo "<script> alert('The book successfully issued!') </script>";           
                $isbn = ""; $id = ""; $issue = ""; $due = "";
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
    <title>Issue Book</title>
</head>
<body>

    <div class="container">
        <div class="side-bar">
        <div class="logo"><img src="images/logo.png" alt=""> <span>Library</span></div>
            <ul>
            <li><a href="dashboard.php">dashboard</a></li>
                <li><a href="addBook.php">add books</a></li>
                <li><a href="addMember.php">add members</a></li>
                <li class="active"><a href="issueBook.php">issue books</a></li>
                <li><a href="returnBook.php">return books</a></li>
                <li><a href="issuedBooks.php">View issued books</a></li>
                <li><a href="returnedBooks.php">View returned books</a></li>
                <li><a href="allBooks.php">view all books</a></li>
                <li><a href="allMembers.php">view all members</a></li>
                <li><a href="logout.php">log out</a></li>
            </ul>
        </div>
        <div class="add issue">
            <form action="issueBook.php" method="post">
                <h1>Book Issue Details</h1>
                <div class="error-msg"><?php echo "$error"; ?></div>
                <input type="text" placeholder="ISBN of Book" name="isbn" value="<?php echo $isbn; ?>">
                <input type="text" placeholder="Student ID" name="id" value="<?php echo $id; ?>">
                <label for="issuedate">Issue Date: </label>
                <input type="date" id="issuedate" name="issue">
                <label for="duedate">Due Date: </label>
                <input type="date" id="duedate" name="due">
                <div class="btns">
                    <input type="submit" value="Clear" name="clear" class="clear">
                    <input type="submit" value="Issue" name="submit">
                </div>
            </form>
        </div>
    </div>

    <script src="script/script.js"></script>
</body>
</html>