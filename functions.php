<?php
    $conn = mysqli_connect("localhost", "root", "", "onlen");

    function query($query){
        global $conn;
        $result = mysqli_query($conn,$query);
        $rows = [];
        while( $row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }

        return $rows;
    }

    function upload(){
        $nameFile = $_FILES['gambar']['name'];
        $sizeFile = $_FILES['gambar']['size'];
        $picterror = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];
    
        $error = 0;

        // cek apakah tidak ada gambar yang diupload
        if($picterror === 4){
            $error++;
            echo "
                <script>
                    alert('Gambar harus diupload!');
                </script>";
        }
    
        // cek apakah yang diupload adalah gambar
        $ekstensiGambarValid=['jpg','jpeg','png'];
        $ekstensiGambar = explode('.', $nameFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
    
        if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
            $error++;
            echo "
                <script>
                    alert('Ekstensi file yang diperbolehkan: .png, .jpg, .jpeg!');
                </script>";
        }
    
        // cek jika ukuran gambar terlalu besar
        else if($sizeFile > 2000000){
            $error++;
            echo "
                <script>
                    alert('Ukuran gambar terlalu besar!');
                </script>";
        }

        if($error > 0){
            return 1;
        }
        else if($error == 0){
            $newName = uniqid();
            $newName .= '.';
            $newName .= $ekstensiGambar; 
            move_uploaded_file($tmpName, 'profile/' . $newName);

            return $newName;
        }
    
    }

    function registrasi($data){
        global $conn;
    
        $nama = stripcslashes($data["nama"]);
        $jenis_kelamin = $data["jenis_kelamin"];
        $alamat = $data["alamat"];
        $telepon = $data["telepon"];
        $email = $data["email"];
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $repassword = mysqli_real_escape_string($conn, $data["re-password"]);
        $hash = md5( rand(0,1000) );
        $error = 0;
        
        if($nama == ""){
            $error++;
            echo "
                <script>
                    alert('Nama harus diisi!');
                </script>
            ";
        }
        else if(strlen($nama) < 3){
            $error++;
            echo "
                <script>
                    alert('Minimal nama 3 karakter!');
                </script>
            ";
        }

        if($alamat == ""){
            $error++;
            echo "
                <script>
                    alert('Alamat harus diisi!');
                </script>
            ";
        }
        else if(strlen($alamat) < 10){
            $error++;
            echo "
                <script>
                    alert('Minimum alamat 10 karakter!');
                </script>
            ";
        }

        if($telepon == ""){
            $error++;
            echo "
                <script>
                    alert('Telepon harus diisi!');
                </script>
            ";    
        }
        else if(strlen($telepon) < 10){
            $error++;
            echo "
                <script>
                    alert('Minimal telepon 10 karakter!');
                </script>
            ";
        }
        else if(!preg_match("/^[0-9|+]+$/", $telepon)){
            $error++;
            echo "
                <script>
                    alert('Telepon hanya dapat diisi angka atau \'+\'!');
                </script>
            ";
        }

        if($email == ""){
            $error++;
            echo "
                <script>
                    alert('Email harus diisi!');
                </script>
            ";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error++;
            echo "
                <script>
                    alert('Tidak sesuai format email!');
                </script>
            ";
        }
        
        if($password == ""){
            $error++;
            echo "
            <script>
            alert('Password harus diisi!');
            </script>
            ";
        }
        else if(strlen($password) < 6){
            $error++;
            echo "
            <script>
            alert('Minimum password 6 karakter!');
            </script>
            ";
        }
        
        if($repassword == ""){
            $error++;
            echo "
            <script>
            alert('Re-password harus diisi!');
            </script>
            ";
        }
        else if($password !== $repassword){
            $error++;
            echo "
            <script>
            alert('Konfirmasi password tidak sama!');
            </script>
            ";
        }
        
        $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");
        if(mysqli_fetch_assoc($result)){
            $error++;
            echo "<script>
                    alert('Email ini sudah terdaftar!');
                </script>";
        }

        if($error > 0){
            return false;
        }
        else if($error == 0){
            $gambar = upload();
            // $hash = md5( rand(0,1000) );
            
            if($gambar == 0){
                return false;
            }
            else if($gambar == 1){
                return false;
            }
            $password = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn, "INSERT INTO user VALUES('','$nama', '$jenis_kelamin', '$alamat', '$telepon', '$email', '$password', '$gambar', '$hash', '0')");
            $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
            $row = mysqli_fetch_assoc($result);
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];

            include('mailing.php');

            return mysqli_affected_rows($conn);
        }
    }

    function editPicture($data){
        global $conn;
    
        $id = $data["id"];
        $gambar = upload();
    
        // query insert data
        $query = "UPDATE user SET
                    gambar = '$gambar'
                    WHERE id = '$id'
                    ";
    
        mysqli_query($conn, $query);
    
        return mysqli_affected_rows($conn);
    
    }

    function updateProf($data){
        global $conn;
    
        $id = $data["id"];
        $nama = stripcslashes($data["nama"]);
        $jenis_kelamin = $data["jenis_kelamin"];
        $alamat = $data["alamat"];
        $telepon = $data["telepon"];
        $email = $data["email"];
        $error = 0;
        
        if($nama == ""){
            $error++;
            echo "
                <script>
                    alert('Nama harus diisi!');
                </script>
            ";
        }
        else if(strlen($nama) < 3){
            $error++;
            echo "
                <script>
                    alert('Minimum nama 3 karakter!');
                </script>
            ";
        }

        if($alamat == ""){
            $error++;
            echo "
                <script>
                    alert('Alamat harus diisi!');
                </script>
            ";
        }
        else if(strlen($alamat) < 10){
            $error++;
            echo "
                <script>
                    alert('Minimum alamat 10 karakter');
                </script>
            ";
        }

        if($telepon == ""){
            $error++;
            echo "
                <script>
                    alert('Telepon harus diisi!');
                </script>
            ";    
        }
        else if(strlen($telepon) < 10){
            $error++;
            echo "
                <script>
                    alert('Minimum telepon 10 karakter!');
                </script>
            ";
        }
        else if(!preg_match("/^[0-9|+]+$/", $telepon)){
            $error++;
            echo "
                <script>
                    alert('Telepon hanya dapat diisi angka atau \'+\'!');
                </script>
            ";
        }

        if($email == ""){
            $error++;
            echo "
                <script>
                    alert('Email harus diisi!');
                </script>
            ";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error++;
            echo "
                <script>
                    alert('Tidak sesuai dengan format email!');
                </script>
            ";
        }

        if($error > 0){
            return false;
        }
        else if($error == 0){
            $query = "UPDATE user SET
                            nama = '$nama',
                            jenis_kelamin = '$jenis_kelamin',
                            alamat = '$alamat',
                            telepon = '$telepon',
                            email = '$email'
                        WHERE id = '$id'
                        ";
        
            mysqli_query($conn, $query);
        
            return mysqli_affected_rows($conn);
        }
    
    }

    function editPass($data){
        global $conn;
    
        $id = $data["id"];
        $pass = mysqli_real_escape_string($conn, $data["old-pass"]);
        $pass_baru = mysqli_real_escape_string($conn, $data["new-pass"]);
        $konfirmasi_pass = mysqli_real_escape_string($conn, $data["re-pass"]);

        $error = 0;

        $result = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'");

    	if(mysqli_num_rows($result) === 1){

            $row = mysqli_fetch_assoc($result);
            if($pass == ""){
                echo "
                    <script>
                        alert('Password lama harus diisi!');
                    </script>
                    ";
                return false;
            }
            if(password_verify($pass, $row["password"])){
                if($pass_baru == ""){
                    $error++;
                    echo "
                    <script>
                        alert('Password baru harus diisi!');
                    </script>
                    ";
                }
                else if(strlen($pass_baru) < 6){
                    $error++;
                    echo "
                    <script>
                        alert('Minimum password baru 6 karakter!');
                    </script>
                    ";
                }
                
                if($konfirmasi_pass == ""){
                    $error++;
                    echo "
                    <script>
                        alert('Konfirmasi Password harus diisi!');
                    </script>
                    ";
                }
                else if($pass_baru !== $konfirmasi_pass){
                    $error++;
                    echo "
                    <script>
                        alert('Konfirmasi Password tidak sama!');
                    </script>
                    ";
                }

                if($error > 0){
                    return false;
                }
                else if($error == 0){
                    $pass_baru = password_hash($pass_baru, PASSWORD_DEFAULT);

                    $query = "UPDATE user SET
                                    password = '$pass_baru'
                                WHERE id = '$id'
                                ";
                    
                    mysqli_query($conn, $query);
                
                    return mysqli_affected_rows($conn);
                }
            }
            else if(!password_verify($pass, $row["password"])){
                echo "
                    <script>
                        alert('Password anda tidak sama dengan password yang terdaftar!');
                    </script>
                ";
                return false;
            }
        }
    
    }

?>