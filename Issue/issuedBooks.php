<?php
    include("database.php");

    $key = "";

    if (isset($_POST['search'])) {
        $key = $_POST['key'];
        $records = array();
        $query = "SELECT * from borrow where returned_date is null and (isbn='$key' or member_id='$key' or issue_date='$key' or due_date='$key')"; 
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result)!=0){
            while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
            }
        }
    }
    else {
        $query = "SELECT * from borrow where returned_date is null order by issue_date desc";
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
                <li class="active"><a href="issuedBooks.php">View issued books</a></li>
                <li><a href="returnedBooks.php">View returned books</a></li>
                <li><a href="allBooks.php">view all books</a></li>
                <li><a href="allMembers.php">view all members</a></li>
                <li><a href="logout.php">log out</a></li>  
            </ul>
        </div>
        <div class="list">
            <div class="content">
                <h1>Issued Books List</h1>
                <div class="top">
                    <form action="issuedBooks.php" method="post" class="search-bar"> 
                        <input type="text" placeholder="Search by student id, ISBN" name="key" value="<?php echo $key; ?>">
                        <input type="submit" value="Search" name="search">
                    </form>
                </div>

                <?php if(mysqli_num_rows($result)==0) {echo "<br> <br> <br>No records found!";} else { ?>
                <div class="rows"><?php echo count($records) . " records found!<br><br>"; ?></div>
                <div class="table">
                <table>
                    <tr>
                        <th>ISBN</th>
                        <th>Memder_Id</th>
                        <th>Issue_date</th>
                        <th>Due date</th>
                    </tr>
                    <?php foreach($records as $record) { ?>
                        <tr>
                            <td><?php echo $record["isbn"] ?></td>
                            <td><?php echo $record["member_id"] ?></td>
                            <td><?php echo $record["issue_date"] ?></td>
                            <td><?php echo $record["due_date"] ?></td>
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