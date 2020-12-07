<?php
    session_start();
    require 'functions.php';

    if(!isset($_SESSION["login"])){
        header("Location: masuk.php");
        exit;
    }

    $id = $_SESSION['id'];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");
    $row = mysqli_fetch_assoc($result);

    $prodid = $_GET['id'];
    $data = mysqli_query($conn, "SELECT * FROM materi WHERE id = '$prodid'");
    $prod = mysqli_fetch_assoc($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/materi.css">
    <title>Materi</title>
</head>
<body>
    <nav>
        <a href="">
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
    
    <section>
        <h1><?php echo $prod["judul"];?></h1>
        <iframe src="https://www.youtube.com/embed/<?php echo $prod["video"];?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" frameborder="0" allowfullscreen></iframe>
        <p><?php echo $prod["deskripsi"];?></p>
    </section>

    <footer>
        <p>Copyright &copy; 2020 Online Learning</p>
        <div class="medsos">
            <a href="https://www.instagram.com/" target="_blank"><img src="asset/instagram-white.png" alt=""></a>
            <a href="https://line.me/id/" target="_blank"><img src="asset/line-white.png" alt=""></a>
            <a href="https://web.whatsapp.com/" target="_blank"><img src="asset/whatsapp-white.png" alt=""></a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>