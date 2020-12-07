<?php
    session_start();

    require 'functions.php';
    
    if(isset($_SESSION["login"])){
        header("Location: user.php");
        exit;
    }

    if(isset($_POST["daftar"])){
        if(registrasi($_POST) > 0){
            echo "
                <script>
                    alert('Daftar Berhasil!');
                    document.location.href = 'user.php';
                </script>
            ";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sign.css?v=<?php echo time(); ?>">
    <title>Daftar</title>
</head>
<body>
    <nav>
        <a href="index.php">
            <img src="asset/Logo.png" alt="">
        </a>
        <div class="nav-left">
            <a href="daftar.php">Daftar</a>
            <a href="masuk.php">Masuk</a>
        </div>
    </nav>

    <section>
        <h1>Online Learning</h1>
        <div class="sign">
            <div class="sign-header">
                <h1>Daftar</h1>
                <p>Sudah punya akun? <a href="masuk.php">Masuk</a></p>
            </div>
            <div class="line"></div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="input">
                    <label for="">Nama</label>
                    <input type="text" placeholder="e.g. John Doe" name="nama">
                </div>
                <div class="genders">
                    <label for="">Jenis Kelamin</label>
                    <div class="gender">
                        <input type="radio" name="jenis_kelamin" value="pria" checked>
                        <label for="">Pria</label>
                        <input type="radio" name="jenis_kelamin" value="wanita">
                        <label for="">Wanita</label>
                    </div>
                </div>
                <div class="address">
                    <label for="">Alamat</label>
                    <textarea name="alamat" id="" cols="30" rows="4" placeholder="Alamat"></textarea>
                </div>
                <div class="input">
                    <label for="">Telepon</label>
                    <input type="text" placeholder="e.g. 085716343xxx" name="telepon">
                </div>
                <div class="input">
                    <label for="">Email</label>
                    <input type="text" placeholder="john@mail.com" name="email">
                </div>
                <div class="input">
                    <label for="">Password</label>
                    <input type="password" placeholder="Password" name="password">
                </div>
                <div class="input">
                    <label for="">Re-Password</label>
                    <input type="password" placeholder="Re-Password" name="re-password">
                </div>
                <div class="input">
                    <label for="">Gambar</label>
                    <div class="pict">
                        <input type="file" name="gambar">
                    </div>
                </div>
                <div class="button">
                    <button type="submit" id="sign" name="daftar">Daftar</button>
                </div>
            </form>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>