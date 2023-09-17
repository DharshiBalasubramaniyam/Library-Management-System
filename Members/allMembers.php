<?php
    include("../database.php");

    $key = "";

    if (isset($_POST['search'])) {
        $key = $_POST['key'];
        $records = array();
        $query = "select * from member where fname like '%$key%' or lname like '%$key%' or id like '%$key%' or faculty like '%$key%'"; 
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result)!=0){
            while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
            }
        }
    }
    else {
        $query = "SELECT * from member order by reg_date desc, id asc";
        $result = mysqli_query($connection, $query);
        $records = array();
        if (mysqli_num_rows($result)!=0){
            while ($row = mysqli_fetch_assoc($result)) {
            $records[] = $row;
            }
        }
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];


        $query1 = "delete from member where id='$id'";
        $rows1 = mysqli_query($connection, $query1);
        $query2 = "delete from borrow where member_id='$id' and returned_date is null";
        $rows2 = mysqli_query($connection, $query2);
        if ($rows1 > 0) {
            echo "<script> alert('The book removed successfully!') </script>";
        }
        $query = "SELECT * from member order by reg_date desc, id asc";
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
    <script src="https://kit.fontawesome.com/c732ec9339.js" crossorigin="anonymous"></script>
    <title>All Members</title>
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
                <li class="active"><a href="../Members/allMembers.php">view all members</a></li>
                <li><a href="../Login/logout.php">log out</a></li>
            </ul>
        </div>
        <div class="list">
            <div class="content">
                <h1>Members List</h1>
                <div class="top">
                    <form action="allMembers.php" method="post" class="search-bar"> 
                        <input type="text" placeholder="Search members by First Name, Last Name, Student Id or faculty" name="key" value="<?php echo $key; ?>">
                        <input type="submit" value="Search" name="search">
                    </form>
                    <div class="add-book"><a href="../Members/addMember.php">Add New Member</a></div>
                </div>


                <?php if(mysqli_num_rows($result)==0) {echo "<br> <br> <br>No records found!";} else { ?>
                <div class="rows"><?php echo count($records) . " records found!<br><br>"; ?></div>
                <div class="table">
                <table>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Phone number</th>
                        <th>City</th>
                        <th>Faculty</th>
                        <th>Reg. date</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach($records as $record) { ?>
                        <tr>
                            <td><?php echo $record["id"] ?></td>
                            <td><?php echo $record["fname"] ?></td>
                            <td><?php echo $record["lname"] ?></td>
                            <td><?php echo $record["email"] ?></td>
                            <td><?php echo $record["phone"] ?></td>
                            <td><?php echo $record["city"] ?></td>
                            <td><?php echo $record["faculty"] ?></td>
                            <td><?php echo $record["reg_date"] ?></td>
                            <td><?php echo "<a href='updateMember.php?id=" . $record['id'] .  "'><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>" ?> / 
                            <?php echo "<a href='allMembers.php?id=" . $record['id'] .  "' onclick='return confirm(\"Are you sure? Do you want to delete this book\")'><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>" ?></td>
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