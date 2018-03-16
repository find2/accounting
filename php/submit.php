 <?php
session_start();
include 'connect.php';
if(isset($_POST['login-btn'])){
		$user= $_POST['username'];
		$pass= $_POST['password'];
		$sql="SELECT * FROM users WHERE name='$user' AND password='$pass'";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_assoc();
			$_SESSION['name']=$row['name'];
			$_SESSION['level']=$row['type'];
			$_SESSION['cabang']=$row['monarch'];
			echo "<script>alert('Welcome to Monarch Bali System');
			location.href='../home.php';
			</script>";
			//header('location:../home.php');
		}
		else{
			echo "<script>alert('Failed to Login');
			location.href='../index.php';
			</script>";
		}
	}
if(isset($_POST['logout-btn'])){
	unset($_SESSION['level']);unset($_SESSION['name']);unset($_SESSION['cabang']);
	session_unset();
	session_destroy();
	header('location:../index.php');
}
$conn->close();
?> 
