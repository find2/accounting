<?php
session_start(); 
unset($_SESSION['level']);unset($_SESSION['username']);unset($_SESSION['monarch']);unset($_SESSION['monarch_name']);
	//header('location:index.php');
	echo "<script>
		location.href='index.php';
	</script>";
?>