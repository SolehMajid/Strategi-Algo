<?php
$user = 'root';
$pass = '';
$db = 'strategi_algo';
$host = 'localhost';

$conn = new PDO(
    "mysql:host=$host;dbname=$db",
    $user,
    $pass
);
