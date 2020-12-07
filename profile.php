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

    if($row['active'] == '0'){
        header("Location: verify.php");
        exit;
    }
    
    if(isset($_POST["change-pict"])){
        if(editPicture($_POST) > 0){
            echo "
                <script>
                    alert('Ubah gambar berhasil!');
                    document.location.href = 'profile.php';
                </script>
            ";
        }
    }
    else if(isset($_POST["change-pass"])){
        if(editPass($_POST) > 0){
            echo "
                <script>
                    alert('Ubah Password Berhasil!');
                    document.location.href = 'profile.php';
                </script>
            ";
        }
    }
    else if(isset($_POST["update"])){
        if(updateProf($_POST) > 0){
            echo "
                <script>
                    alert('Ubah Profile Berhasil!');
                    document.location.href = 'profile.php';
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
    <link rel="stylesheet" href="css/profile.css">
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

    <section class="d-flex justify-content-center align-items-center">
        <div class="profile">
            <div class="picts">
                <img src="profile/<?php echo $row["gambar"];?>" alt="" style="border-radius: 100%;" id="profile">
                <button type="button" class="edit" data-toggle="modal" data-target="#profs">
                    <img src="asset/pencil.svg" alt="" width="20" height="15">
                </button>
            </div>
            <div class="line"></div>
            <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $row["id"];?>">
                <div class="input">
                    <label for="">Nama</label>
                    <input type="text" name="nama" value="<?php echo $row["nama"];?>">
                </div>
                <div class="genders">
                    <label for="">Jenis Kelamin</label>
                    <div class="gender">
                        <input type="radio" name="jenis_kelamin" value="pria" <?php if($row['jenis_kelamin']=='pria') echo 'checked'?>>
                        <label for="">Pria</label>
                        <input type="radio" name="jenis_kelamin" value="wanita" <?php if($row['jenis_kelamin']=='wanita') echo 'checked'?>>
                        <label for="">Wanita</label>
                    </div>
                </div>
                <div class="address">
                    <label for="">Alamat</label>
                    <textarea name="alamat" id="" cols="30" rows="4" placeholder="Address"><?php echo $row["alamat"]; ?></textarea>
                </div>
                <div class="input">
                    <label for="">Telepon</label>
                    <input type="text" name="telepon" value="<?php echo $row["telepon"]; ?>">
                </div>
                <div class="input">
                    <label for="">Email</label>
                    <input type="text" name="email" value="<?php echo $row["email"]; ?>">
                </div>
                <div class="buttons">
                    <button type="submit" name="update">Ubah</button>
                    <button type="button" id="change" data-toggle="modal" data-target="#pass">
                        Ubah Password
                    </button>
                </div>
            </form>
            <div class="modal fade" id="profs" tabindex="-1" aria-labelledby="profileLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="profileLabel">Ubah Gambar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="modal-body">
                                <div class="file">
                                    <input type="file" name="gambar">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="change" name="change-pict">
                                Ubah gambar
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="pass" tabindex="-1" aria-labelledby="passLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="passLabel">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <div class="modal-body">
                                <div class="input">
                                    <label for="">Password Anda</label>
                                    <input type="password" name="old-pass" placeholder="Password Anda">
                                </div>
                                <div class="input">
                                    <label for="">Password Baru</label>
                                    <input type="password" name="new-pass" placeholder="Password Baru">
                                </div>
                                <div class="input">
                                    <label for="">Konfirmasi Password</label>
                                    <input type="password" name="re-pass" placeholder="Konfirmasi Password">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="change" name="change-pass">
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>