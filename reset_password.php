<?php 
session_start();
require 'functions.php';

if(isset($_SESSION["login"])){
    header("Location: user.php");
    exit;
}

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['code']) && !empty($_GET['code'])){
    // Verify data
    $email = $_GET['email']; 
	$code = $_GET['code'];

	$searchCode = mysqli_query($conn, "SELECT * FROM reset_password WHERE code='$code'");
	$search = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
	if(mysqli_num_rows($searchCode) === 1 && mysqli_num_rows($search) === 1){
		$users = mysqli_fetch_assoc($search);
		$pw = password_hash($code, PASSWORD_DEFAULT);
		$query = mysqli_query($conn, "UPDATE user SET password='$pw' WHERE email='$email'");
		if($query){
			mysqli_query($conn, "DELETE FROM reset_password WHERE code = '$code'");
			$_SESSION["login"] = true;
			$_SESSION["id"] = $users["id"];
			header("Location: user.php");
			exit;
		}
	}

}


?>