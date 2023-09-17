<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $database = "library";
    $connection = "";

    try {
        $connection = mysqli_connect($server, 
                                    $user, 
                                    $password, $database);
    }catch(mysqli_sql_exception) {
        echo "could not connect";
    }

?>