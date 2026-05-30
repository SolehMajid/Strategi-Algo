<?php 
    require_once "fungsi.php";

    $msg = "";
    $display = "";
    if(!empty($_POST['submit'])) {
        daftarPembuat(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), $msg, $display);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Strategi Algoritma</title>
</head>
<body>
    <?php echo $msg; ?>
    <form action="" method="post">
        <p class="tengah">Buat username</p>
        <div class="tengah">
            <input type="text" name="username" value="" required>
        </div>
        <p class="tengah">Buat password</p>
        <div class="tengah">
            <input type="password" name="password" value="" required>
        </div>
        <div class="tengah">
            <a class="kembali" href="index.html">Kembali</a>
            <input type="submit" value="submit" name="submit">
        </div>
    </form>
</body>
</html>