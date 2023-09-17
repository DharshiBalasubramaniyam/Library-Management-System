<?php

    include("../database.php");

    $error = "";

    $title = ""; $author = ""; $isbn = ""; $publisher = ""; $edition = ""; $pages = ""; $category = "";
    $pattern1 = "/[^0-9]/"; $pattern2 = "/[^A-Za-z ]/"; $pattern3 = "/[^A-Za-z0-9- ]/";

    if (isset($_GET['isbn'])) {
        $isbn = $_GET['isbn'];


        $query = "select * from book where isbn=$isbn";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $author = $row['author'];
        $publisher = $row['publisher'];
        $edition = $row['edition'];
        $pages = $row['pages'];
        $category = $row['category'];
    }

    if (isset($_POST["add"])) {
        $title = $_POST["title"];
        $author = $_POST["author"];
        $edition = $_POST["edition"];
        $publisher = $_POST["publisher"];
        $isbn = $_POST["isbn"];
        $pages = $_POST["pages"];
        $category = $_POST["category"];
        if (empty($_POST["title"]) || empty($_POST["author"]) || empty($_POST["isbn"]) || empty($_POST["publisher"]) || empty($_POST["edition"]) || empty($_POST["pages"])) {
            $error = "All the fields are requirded!";
        }
        else {
            $error = "";
            if (preg_match($pattern3, $title)) {
                $error = "Author name of the book must have only letters.";
            }
            else if (preg_match($pattern1, $isbn) || strlen($isbn)!=13) {
                $error = "ISBN of the book must have 13 characters and contains only digits.";
            }
            else if (preg_match($pattern2, $publisher)) {
                $error = "Publisher name of the book must have only letters.";
            }
            else if (preg_match($pattern1, $edition)) {
                $error = "Edition number of the book must have only numbers.";
            }
            else if (preg_match($pattern1, $pages)) {
                $error = "No of pages of the book must have only numbers.";
            }
            else if ($category === "Category") {
                $error = "Please select the category of the book!";
            }
            else {
                if ($error=="") {
                    $updateSql = "Update book set isbn = '$isbn', title = '$title', author = '$author', publisher = '$publisher', edition = $edition, pages = $pages, category = '$category' where isbn = '$isbn'";
                    mysqli_query($connection, $updateSql);
                    echo "<script> alert('The book details updated successfully!') </script>";
                    $title = ""; $author = ""; $isbn = ""; $publisher = ""; $edition = ""; $pages = ""; $_POST["category"]="Category";
                    $error = "";
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
    <title>updateBook</title>
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
                <li class="active"><a href="../Books/updateBooks.php">Update books</a></li>
                <li><a href="../Members/allMembers.php">view all members</a></li>
                <li><a href="../Login/logout.php">log out</a></li>
            </ul>
        </div>
        <div class="add">
            <form action="updateBook.php" method="post">
                <h1>Enter New Book Details</h1>
                <div class="error-msg"><?php echo "$error"; ?></div>
                <input type="text" placeholder="New Book Title" name="title" value="<?php echo $title; ?>">
                <input type="text" placeholder="New Author Name" name="author" value="<?php echo $author; ?>">
                <input type="text" placeholder="New ISBN of Book" name="isbn" value="<?php echo $isbn; ?>">
                <input type="text" placeholder="New Publisher Name" name="publisher" value="<?php echo $publisher; ?>">
                <input type="text" placeholder="New Edition" name="edition" value="<?php echo $edition; ?>">
                <input type="text" placeholder="New No of Pages" name="pages" value="<?php echo $pages; ?>">
                <select name="category" id="">
                    <option value="Category" <?php if (isset($_GET['isbn']) && $category=="Category") echo "selected"; ?>>New Category</option>
                    <option value="ICT" <?php if (isset($_GET['isbn']) &&  $category=="ICT") echo "selected"; ?>>ICT</option>
                    <option value="Physics" <?php if (isset($_GET['isbn']) &&  $category=="Physics") echo "selected"; ?>>Physics</option>
                    <option value="Law" <?php if (isset($_GET['isbn']) &&  $category=="Law") echo "selected"; ?>>Law</option>
                    <option value="Carnatic Music" <?php if (isset($_GET['isbn']) &&  $category=="Carnatic Music") echo "selected"; ?>>Carnatic Music</option>
                    <option value="Management" <?php if (isset($_GET['isbn']) &&  $category=="Management") echo "selected"; ?>>Management</option>
                    <option value="Agriculture" <?php if (isset($_GET['isbn']) &&  $category=="Agriculture") echo "selected"; ?>>Agriculture</option>
                    <option value="Mathemetics" <?php if (isset($_GET['isbn']) &&  $category=="Mathemetics") echo "selected"; ?>>Mathemetics</option>
                </select>
                <div class="btns">
                    <input type="submit" value="Clear" name="clear" class="clear" class="clear">
                    <input type="submit" value="Update" name="add">
                </div>
                
        
            </form>
        </div>
    </div>

    <script src="script/script.js"></script>
    
</body>
</html>