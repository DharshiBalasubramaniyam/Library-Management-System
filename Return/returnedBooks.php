<?php
    include("../database.php");

    $key = "";

    if (isset($_POST['search'])) {
        $key = $_POST['key'];
        $records = array();
        $query = "SELECT * from borrow where returned_date is not null and (isbn='$key' or member_id='$key' or issue_date='$key' or due_date='$key')"; 
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result)!=0){
            while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
            }
        }
    }
    else {
        $query = "SELECT * from borrow where returned_date is not null order by returned_date desc";
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
    <link rel="stylesheet" href="../styles/style.css">
    <title>All returned books</title>
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
                <li><a href="../Return/returnBook.php">return books</a></li>
                <li><a href="../Issue/issuedBooks.php">View issued books</a></li>
                <li class="active"><a href="../Return/returnedBooks.php">View returned books</a></li>
                <li><a href="../Books/allBooks.php">view all books</a></li>
                <li><a href="../Members/allMembers.php">view all members</a></li>
                <li><a href="../Login/logout.php">log out</a></li>
            </ul>
        </div>
        <div class="list">
            <div class="content">
                <h1>Returned Books List</h1>
                <div class="top">
                    <form action="returnedBooks.php" method="post" class="search-bar"> 
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
                        <th>Returned Date</th>
                        <th>Fine</th>
                    </tr>
                    <?php foreach($records as $record) { ?>
                        <tr>
                            <td><?php echo $record["isbn"] ?></td>
                            <td><?php echo $record["member_id"] ?></td>
                            <td><?php echo $record["issue_date"] ?></td>
                            <td><?php echo $record["due_date"] ?></td>
                            <td><?php echo $record["returned_date"] ?></td>
                            <td><?php echo $record["fine"] ?></td>
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