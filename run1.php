<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$amount = $_POST['amount'];
	$name = $_POST['name'];
	$reason = $_POST['reason'];
	$servername = "localhost";
	$username = "root";
	$password = "smitpatel1996";
	$conn = mysqli_connect($servername, $username, $password);
	if (!$conn) {
   		die("Connection failed: " . mysqli_connect_error());
	}
	mysqli_select_db($conn,"finaldb");
	$bool = "INSERT INTO firsttable VALUES ('B','{$_SERVER['REMOTE_ADDR']}','{$amount}','{$name}','{$reason}',CURDATE());";
	mysqli_query($conn, $bool);
	mysqli_close($conn);
	header('Location: http://smitpatel1996.github.io/PalWallet/index.html#success');
	die();
}
?>