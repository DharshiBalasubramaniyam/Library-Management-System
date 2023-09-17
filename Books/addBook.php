<?php
    include("database.php");

    $error = "";
    $title = ""; $author = ""; $isbn = ""; $publisher = ""; $edition = ""; $pages = ""; $category = "";

    if (isset($_POST["clear"])) {
        $error = ""; $success="";
        $title = ""; $author = ""; $isbn = ""; $publisher = ""; $edition = ""; $pages = ""; $_POST["category"]="Category";
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
            if (preg_match("/[^0-9]/", $isbn) || strlen($isbn)!=13) {
                $error = "ISBN of the book must have 13 characters and contains only digits.";
            }
            else if (preg_match("/[^A-Za-z0-9 ]/", $publisher)) {
                $error = "Publisher name of the book must have only letters.";
            }
            else if (preg_match("/[^0-9]/", $edition)) {
                $error = "Edition number of the book must have only numbers.";
            }
            else if (preg_match("/[^0-9]/", $pages)) {
                $error = "No of pages of the book must have only numbers.";
            }
            else if ($category === "Category") {
                $error = "Please select the category of the book!";
            }
            else {
                $check = "SELECT * from book where isbn='$isbn'";
    
                $result1 = mysqli_query($connection, $check);
                if (mysqli_num_rows($result1)>0) {
                    $error = "This given isbn already exists";
                }
                
                if ($error=="") {
                    $insertSql = "INSERT INTO book(isbn, title, author, publisher, edition, pages, category) 
                    VALUES('$isbn', '$title', '$author', '$publisher', '$edition', '$pages', '$category')";
                    mysqli_query($connection, $insertSql);
                    echo "<script> alert('The book successfully added to the system!') </script>";
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
    <link rel="stylesheet" href="styles/style.css">
    <title>Add Books</title>
</head>
<body>
    <div class="container">
        <div class="side-bar">
        <div class="logo"><img src="images/logo.png" alt=""> <span>Library</span></div>
            <ul>
                <li><a href="dashboard.php">dashboard</a></li>
                <li  class="active"><a href="addBook.php">add books</a></li>
                <li><a href="addMember.php">add members</a></li>
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
            <form action="addBook.php" method="post">
                <h1>Book Details</h1>
                <div class="error-msg"><?php echo "$error"; ?></div>
                <input type="text" placeholder="Book Title" name="title" value="<?php echo $title; ?>">
                <input type="text" placeholder="Author Name" name="author" value="<?php echo $author; ?>">
                <input type="text" placeholder="ISBN of Book" name="isbn" value="<?php echo $isbn; ?>">
                <input type="text" placeholder="Publisher Name" name="publisher" value="<?php echo $publisher; ?>">
                <input type="text" placeholder="Edition" name="edition" value="<?php echo $edition; ?>">
                <input type="text" placeholder="No of Pages" name="pages" value="<?php echo $pages; ?>">
                <select name="category" id="">
                    <option value="Category" <?php if (isset($_POST["add"]) && $_POST["category"]=="Category") echo "selected"; ?>>Category</option>
                    <option value="ICT" <?php if (isset($_POST["add"]) && $_POST["category"]=="ICT") echo "selected"; ?>>ICT</option>
                    <option value="Physics" <?php if (isset($_POST["add"]) && $_POST["category"]=="Physics") echo "selected"; ?>>Physics</option>
                    <option value="Law" <?php if (isset($_POST["add"]) && $_POST["category"]=="Law") echo "selected"; ?>>Law</option>
                    <option value="Carnatic Music" <?php if (isset($_POST["add"]) && $_POST["category"]=="Carnatic Music") echo "selected"; ?>>Carnatic Music</option>
                    <option value="Management" <?php if (isset($_POST["add"]) && $_POST["category"]=="Management") echo "selected"; ?>>Management</option>
                    <option value="Agriculture" <?php if (isset($_POST["add"]) && $_POST["category"]=="Agriculture") echo "selected"; ?>>Agriculture</option>
                    <option value="Mathemetics" <?php if (isset($_POST["add"]) && $_POST["category"]=="Mathemetics") echo "selected"; ?>>Mathemetics</option>
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