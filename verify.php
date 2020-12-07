<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: masuk.php");
        exit;
    }

    require 'functions.php';

    $id = $_SESSION['id'];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);

    if($row['active'] == '1'){
        header("Location: user.php");
        exit;
    }

    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        // Verify data
        $email = $_GET['email']; 
        $hash = $_GET['hash'];

        mysqli_query($conn, "UPDATE user SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'");
        header("Location: user.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/verify.css">
    <title>Materi</title>
</head>
<body>
    <nav>
        <a href="user.php">
            <img src="asset/Logo.png" alt="">
        </a>
        <div class="dropdown">
            <button class="dropbtn">
                <img src="profile/<?php echo $row["gambar"];?>" alt="" width="20" height="20" style="border-radius: 100%;">
                <p>Halo, <?php echo $row["nama"];?></p>
                <img src="asset/navbar-dropdown.png" alt="" width="10" height="10">
            </button>
            <div class="dropdown-content">
                <a href="profile.php">Profile Saya</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <section class="d-flex align-items-center justify-content-center">
        <h1>Online Learning</h1>
        <div class="verify">
            <p>Hi! kamu baru saja mendaftar <b>Online Learning</b> akun.</p>
            <p>Mohon luangkan waktu sejenak untuk memverifikasi bahwa ini adalah email Anda.</p>
            <a href="https://mail.google.com/mail/u/0/">Verifikasi Alamat Email</a>
            <p>Jika Anda tidak membuat akun menggunakan email ini, harap abaikan email ini.</p>
            <p class="regards">Hormat kami,</p>
            <p><b>Online Learning Team</b></p>
        </div>

        <p class="copy">&copy 2020 <span>Online Learning</span></p>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>