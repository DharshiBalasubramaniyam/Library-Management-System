<?php
    include("database.php");

    $key = "";

    if (isset($_POST['search'])) {
        $key = $_POST['key'];
        $records = array();
        $query = "select * from book where isbn='$key' or title like '%$key%' or author like '%$key%' or category like '%$key%' or status='$key'"; 
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result)!=0){
            while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
            }
        }
    }
    else {
        $query = "SELECT * from book order by reg_date desc, isbn asc";
        $result = mysqli_query($connection, $query);
        $records = array();
        if (mysqli_num_rows($result)!=0){
            while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
            }
        }
    }

    if (isset($_GET['isbn'])) {
        $isbn = $_GET['isbn'];


        $query1 = "delete from book where isbn='$isbn'";
        $rows1 = mysqli_query($connection, $query1);
        $query2 = "delete from borrow where isbn='$isbn' and returned_date is null";
        $rows2 = mysqli_query($connection, $query2);
        if ($rows1 > 0) {
            echo "<script> alert('The book removed successfully!'); </script>";
        }
        $query = "SELECT * from book order by reg_date desc, isbn asc";
        $result = mysqli_query($connection, $query);
        $records = array();
        if (mysqli_num_rows($result)!=0){
            while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
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
    <script src="https://kit.fontawesome.com/c732ec9339.js" crossorigin="anonymous"></script>
    <title>All books</title>
</head>
<body>

    <div class="container">
        <div class="side-bar">
        <div class="logo"><img src="images/logo.png" alt=""> <span>Library</span></div>
            <ul>
                <li><a href="dashboard.php">dashboard</a></li>
                <li><a href="addBook.php">add books</a></li>
                <li><a href="addMember.php">add members</a></li>
                <li><a href="issueBook.php">issue books</a></li>
                <li><a href="returnBook.php">return books</a></li>
                <li><a href="issuedBooks.php">View issued books</a></li>
                <li><a href="returnedBooks.php">View returned books</a></li>
                <li class="active"><a href="allBooks.php">view all books</a></li>
                <li><a href="allMembers.php">view all members</a></li>
                <li><a href="logout.php">log out</a></li>  
            </ul>
        </div>
        <div class="list">
            <div class="content">
                <h1>Books List</h1>
                <div class="top">
                    <form action="allBooks.php" method="post" class="search-bar"> 
                        <input type="text" placeholder="Search books by ISBN, Keyword, Author, Availability or Category" name="key" value="<?php echo $key; ?>">
                        <input type="submit" value="Search" name="search">
                    </form>
                    <div class="add-book"><a href="addBook.php">Add New book</a></div>
                </div>

                <?php if(mysqli_num_rows($result)==0) {echo "<br> <br> <br>No records found!";} else {  ?>
                
                <div class="rows"><?php echo count($records) . " records found!<br><br>"; ?></div>
                <div class="table">    
                <table>
                    <tr>
                        <th>ISBN</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Edition</th>
                        <th>Category</th>
                        <th>Reg. Date</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach($records as $record) { ?>
                        <tr>
                            <td><?php echo $record["isbn"] ?></td>
                            <td><?php echo $record["title"] ?></td>
                            <td><?php echo $record["author"] ?></td>
                            <td><?php echo $record["publisher"] ?></td>
                            <td><?php echo $record["edition"] ?></td>
                            <td><?php echo $record["category"] ?></td>
                            <td><?php echo $record["reg_date"] ?></td>
                            <td><?php echo $record["status"] ?></td>
                            <td><?php echo "<a href='updateBook.php?isbn=" . $record['isbn'] .  "'><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>" ?> / 
                            <?php echo "<a href='allBooks.php?isbn=" . $record['isbn'] .  "' onclick='return confirm(\"Are you sure? Do you want to delete this book\")'><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>" ?></td>
                        </tr>
                    <?php } ?>
                </table>
                </div>
                
                <?php } ?>

            </div>
            
            
        </div>
    </div>

    <script src="script/script.js"></script>
</body>
</html>