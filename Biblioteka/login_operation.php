<?php

header('Content-Type: text/html; charset=utf-8');
session_start();
require_once "connect.php";//include connect.php

$connect=@new mysqli($host,$db_user,$db_password,$db_name);
if($connect->connect_errno!=0)
{
	echo "Error".$connect->connect_errno;
}
else
{
$connect -> query ('SET NAMES utf8');
$connect -> query ('SET CHARACTER_SET utf8_unicode_ci');

$login=$_POST['login'];
$password=$_POST['password'];

$login = htmlentities($login,ENT_QUOTES,"UTF-8");//sql injaction

if($result=@$connect->query(sprintf("SELECT * FROM person WHERE login = '%s'",
	mysqli_real_escape_string($connect,$login))))//if(it doesn't work becouse of some sql mistake) sql injaction
{
	$how_many_users=$result->num_rows;//number of return rows
	if($how_many_users>0)
	{
		$row=$result->fetch_assoc();//tablica asocjacyjna zamiast id w tab jest słowo
		if(password_verify($password,$row['password']))
		{
			$_SESSION['log']=true;
			$_SESSION['firstName']=$row['firstName'];
			$_SESSION['surname']=$row['surname'];
			$_SESSION['login']=$row['login'];
		    $_SESSION['amountOfRented'] = $row['amountOfRented'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['idUser'] = $row['id'];
			unset($_SESSION['mistake']);
			$result->close();//remove information from ram
			header('Location:index.php');
		}
		else
		{
		$_SESSION['log']=false;
		$_SESSION['mistake']="<div class=\"wrong\">Nieprawidłowy login lub hasło</div>";
		header('Location:login.php');
		}
	}
	else
	{
		$_SESSION['log']=false;
		$_SESSION['mistake']="<div class=\"wrong\">Nieprawidłowy login lub hasło</div>";
		header('Location:login.php');
		
	}
}
else
{
	echo "Error syntax MySqL";
}

$connect->close();
}
?>



