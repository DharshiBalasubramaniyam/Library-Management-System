<?php

    session_start();

    include("database.php");

    $bookQuery = "select count(isbn) as count from book";
    $result1 = mysqli_query($connection, $bookQuery);
    $row1 = mysqli_fetch_assoc($result1);
    $bookCount = $row1['count'];

    $memberQuery = "select count(id) as count from member";
    $result2 = mysqli_query($connection, $memberQuery);
    $row2 = mysqli_fetch_assoc($result2);
    $memberCount = $row2['count'];

    $issueQuery = "select count(borrow_id) as count from borrow where returned_date is null";
    $result3 = mysqli_query($connection, $issueQuery);
    $row3 = mysqli_fetch_assoc($result3);
    $issueCount = $row3['count'];

    $today = date("Y-m-d");
    $todayFormatted = date("l, F j, Y");
    $todayIssueQuery = "select count(borrow_id) as count from borrow where issue_date = '$today' and returned_date is null";
    $result4 = mysqli_query($connection, $todayIssueQuery);
    $row4 = mysqli_fetch_assoc($result4);
    $todayIssueCount = $row4['count'];

    $todayReturnQuery = "select count(borrow_id) as count from borrow where issue_date = '$today' and returned_date is not null";
    $result5 = mysqli_query($connection, $todayReturnQuery);
    $row5 = mysqli_fetch_assoc($result5);
    $todayReturnCount = $row5['count'];

    $todayNewBook = "select count(isbn) as count from book where reg_date = '$today'";
    $result6 = mysqli_query($connection, $todayNewBook);
    $row6 = mysqli_fetch_assoc($result6);
    $todayBookCount = $row6['count'];

    $todayNewMember = "select count(id) as count from member where reg_date = '$today'";
    $result7 = mysqli_query($connection, $todayNewMember);
    $row7 = mysqli_fetch_assoc($result7);
    $todayMemberCount = $row7['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>DashBoard</title>
</head>
<body>
    <div class="container">
        <div class="side-bar">
            <div class="logo"><img src="images/logo.png" alt=""> <span>Library</span></div>
            <ul>
                <li class="active"><a href="dashboard.php">dashboard</a></li>
                <li><a href="./Books/addBook.php">add books</a></li>
                <li><a href="./Members/addMember.php">add members</a></li>
                <li><a href="./Issue/issueBook.php">issue books</a></li>
                <li><a href="./Return/returnBook.php">return books</a></li>
                <li><a href="./Issue/issuedBooks.php">View issued books</a></li>
                <li><a href="./Return/returnedBooks.php">View returned books</a></li>
                <li><a href="./Books/allBooks.php">view all books</a></li>
                <li><a href="./Members/allMembers.php">view all members</a></li>
                <li><a href="./Login/logout.php">log out</a></li>
            </ul>
        </div>
        <div class="dashboard">
            <div class="header">
                <div class="welcome">Welcome <?php echo "{$_SESSION['first_name']} {$_SESSION['last_name']}"; ?>!</div>
                <div class="date">Today: <?php echo $todayFormatted; ?></div>
            </div>
            <div class="cards">
                <div class="card">
                    <div class="overlay">
                        <h2>All Books</h2>
                        <div class="count"><?php echo $bookCount; ?></div>
                        <div class="more"><a href="./Books/allBooks.php">See more info</a></div>
                    </div>
                </div>
                <div class="card">
                    <div class="overlay">
                        <h2>All Members</h2>
                        <div class="count"><?php echo $memberCount; ?></div>
                        <div class="more"><a href="./Members/allMembers.php">See more info</a></div>
                    </div>
                </div>
                <div class="card">
                    <div class="overlay">
                        <h2>Issued Books</h2>
                        <div class="count"><?php echo $issueCount; ?></div>
                        <div class="more"><a href="./Issue/issuedBooks.php">See more info</a></div>
                    </div>
                </div>
            </div>
            <h4>Today</h4>
            <div class="cards">
                <div class="card">
                    <div class="overlay">
                        <h2>Issued Books</h2>
                        <div class="count"><?php echo $todayIssueCount; ?></div>
                        <div class="more"><a href="./Issue/issuedBooks.php">See more info</a></div>
                    </div>
                </div>
                <div class="card">
                    <div class="overlay">
                        <h2>Returned Books</h2>
                        <div class="count"><?php echo $todayReturnCount; ?></div>
                        <div class="more"><a href="./Return/returnedBooks.php">See more info</a></div>
                    </div>
                </div>
                <div class="card">
                    <div class="overlay">
                        <h2>New Books</h2>
                        <div class="count"><?php echo $todayBookCount; ?></div>
                        <div class="more"><a href="./Books/allBooks.php">See more info</a></div>
                    </div>
                </div>
                <div class="card">
                    <div class="overlay">
                        <h2>New Members</h2>
                        <div class="count"><?php echo $todayMemberCount; ?></div>
                        <div class="more"><a href="./Members/allMembers.php">See more info</a></div>
                    </div>
                </div>     
                    
            </div>
        </div>
    </div>

    <script src="script/script.js"></script>
</body>
</html>