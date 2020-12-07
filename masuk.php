<?php 
    session_start();
    require 'functions.php';

    if(isset($_SESSION["login"])){
        header("Location: user.php");
        exit;
    }


    if(isset($_POST["login"])){

        $email = $_POST["email"];
        $password = $_POST["password"];

        $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

        // cek username
        if(mysqli_num_rows($result) === 1){

            // cek password
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row["password"])){
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];

                header("Location: user.php");
                exit;
            }
        }
    }

    if(isset($_POST["reset"])){
        $email = $_POST["emailForget"];
        $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
        
        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            $code = uniqid(true);
            $user_id = $row['id'];
            $nama = $row['nama'];
            $query = mysqli_query($conn, "INSERT INTO reset_password VALUES('', '$user_id', '$code')");

            include('reset.php');

            echo "
                <script>    
                    alert('Password baru telah dikirim ke email Anda!');
                    document.location.href = 'masuk.php';
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
    <title>Masuk</title>
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
                <h1>Masuk</h1>
                <p>Belom punya akun? <a href="daftar.php">Daftar</a></p>
            </div>
            <div class="line"></div>
            <form action="" method="POST" class="form-login">
                <div class="input">
                    <label for="">Email</label>
                    <input type="text" placeholder="john@mail.com" name="email">
                </div>
                <div class="input">
                    <label for="">Password</label>
                    <input type="password" placeholder="Password" name="password">
                </div>
                <button type="button" data-toggle="modal" data-target="#exampleModal" id="forget">
                    Lupa Password?
                </button>
                <div class="button-login">
                    <button id="sign" type="submit" name="login">
                        Masuk
                    </button>
                </div>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lupa Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                        <div class="modal-body">
                            <p><b>Harap masukkan Email anda</b></p>
                            <p>Password baru akan dikirim melalui email yang terdaftar.</p>
                                <div class="input">
                                    <label for="">Email</label>
                                    <input type="text" placeholder="john@mail.com" name="emailForget">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="reset" name="reset">Ubah Password</button>
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