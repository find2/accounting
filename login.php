 <?php
session_start();
include 'connect.php';

if(isset($_POST['login-btn'])){
		$user= $_POST['username'];
		$pass= $_POST['password'];
		$pass=md5($pass);
		$sql="SELECT * FROM users WHERE username='$user' AND password='$pass'";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$row=$res->fetch_assoc();
			$_SESSION['level']=$row['level'];
			$_SESSION['username']=$row['username'];
			$_SESSION['name']=$row['name'];
			$_SESSION['monarch']=$row['monarch'];
			$_SESSION['monarch_name']=$row['monarch_name'];
			echo "<script>
			location.href='home.php';
			</script>";
			//header('location:results.php');
		}
		else{
			echo "<script>alert('Failed to Login');
			location.href='index.php';
			</script>";
		}
	}
	
if(isset($_POST['logout-btn'])){
	unset($_SESSION['level']);unset($_SESSION['username']);unset($_SESSION['name']);unset($_SESSION['monarch']);unset($_SESSION['monarch_name']);
	header('location:index.php');
	echo "<script>
		location.href='index.php';
	</script>";
}
$conn->close();
?> 
