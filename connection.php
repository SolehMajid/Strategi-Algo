<?php 
    $user = 'root';
    $pass = 'root';
    $db = 'strategi_algo';
    $host = 'localhost';

    $conn = new PDO(
        "mysql:host=$host;dbname=$db",
        $user,
        $pass
    );

?>