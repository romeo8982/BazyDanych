<?php
	session_start();
	
	if(isset($_POST['a_email']))
	{
		//Udana walidacja
		$_everything_ok=true;
		//Sprawdź login
		$a_login=$_POST['a_login'];
		//Sprawdzenie dł
		if((strlen($a_login)<3)||(strlen($a_login)>20))
		{
			$_everything_ok=false;
			$_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
		}
		if (ctype_alnum($a_login)==false)
		{
			$_everything_ok=false;
			$_SESSION['e_login']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		$a_email = $_POST['a_email'];
		$a_emailB = filter_var($a_email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($a_emailB, FILTER_VALIDATE_EMAIL)==false) || ($a_emailB!=$a_email))
		{
			$_everything_ok=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		$a_password1 = $_POST['a_password1'];
		$a_password2 = $_POST['a_password2'];
		
		if ((strlen($a_password1)<8) || (strlen($a_password1)>20))
		{
			$_everything_ok=false;
			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($a_password1!=$a_password2)
		{
			$_everything_ok=false;
			$_SESSION['e_password']="Podane hasła nie są identyczne!";
		}	
		
		$password_hash = password_hash($a_password1, PASSWORD_DEFAULT);

		$a_first_name=$_POST['a_first_name'];
		//Sprawdzenie dł 
		if((strlen($a_first_name)<2)||(strlen($a_first_name)>20))
		{
			$_everything_ok=false;
			$_SESSION['e_first_name']="Imie musi posiadać od 2 do 20 znaków!";
		}
		
		$a_surname=$_POST['a_surname'];
		//Sprawdzenie dł 
		if((strlen($a_surname)<2)||(strlen($a_surname)>20))
		{
			$_everything_ok=false;
			$_SESSION['e_surname']="Nazwisko musi posiadać od 2 do 20 znaków!";
		}
		
		$secret="6LdMMD0UAAAAABeth7XasV4lm_kO-IZxuw7hmjG0";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$response = json_decode($check);
		
		if($response->success==false)
		{
			$_everything_ok=false;
			$_SESSION['e_bot']="Potwierdź że nie jesteś botem";
		}
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		try 
		{
			$connect = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connect->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$a_login = htmlentities($a_login,ENT_QUOTES,"UTF-8");//sql injaction
				$a_email = htmlentities($a_email,ENT_QUOTES,"UTF-8");//sql injaction

				//Czy email już istnieje?
				$result = $connect->query(sprintf("SELECT id FROM person WHERE email='%s'",mysqli_real_escape_string($connect,$a_email)));
				
				if (!$result) throw new Exception($connect->error);
			
				$how_many_email = $result->num_rows;
				
				if($how_many_email>0)
				{
					$_everything_ok=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		
				//Czy login jest już zarezerwowany?
				$result = $connect->query(sprintf("SELECT id FROM person WHERE login='%s'",mysqli_real_escape_string($connect,$a_login)));
				if (!$result) throw new Exception($connect->error);
				$how_many_login = $result->num_rows;
				if($how_many_login>0)
				{
					$_everything_ok=false;
					$_SESSION['e_login']="Istnieje już użytkownik o takim loginie! Wybierz inny.";
				}
				if ($_everything_ok==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy użytkownika do bazy
					$a_first_name = htmlentities($a_first_name,ENT_QUOTES,"UTF-8");//sql injaction
					$a_surname = htmlentities($a_surname,ENT_QUOTES,"UTF-8");//sql injaction
					
					
					
					if ($connect->query(sprintf("INSERT INTO person VALUES (NULL, '$a_login', '$a_email', '$password_hash', '%s', '%s', 0, 0)",
					mysqli_real_escape_string($connect,$a_first_name),
					mysqli_real_escape_string($connect,$a_surname))))
					{
						
					}
					else
					{
						throw new Exception($connect->error);
					}		
				}
				$connect->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			//echo '<br />Informacja developerska: '.$e;
		}
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<title>Biblioteka Logowanie/Rejestracja</title>
<meta name="description" content="Biblioteka miejsce gdzie można wypożyczyć książki" />
<meta name="keywords" content="Biblioteka,Książka,Wypożyczać" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<link rel="stylesheet" href="css/style2.css" "type/css"/>
<link href='http://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>	
<script src='https://www.google.com/recaptcha/api.js'></script>
</head> 

<body> 
    <header>
        <div class ="logo">
            <h1>
                <a href ="index.php">
                <img src = "logo_ksiazki.jpg" width = "100" height = "100"/>
                </a>
            </h1>
        </div>
            
        <div class = "data">
			<p>Aktualna data: </p>
			<?php 
             date_default_timezone_set("Europe/Warsaw");
            echo date('d-m-Y');
             ?>
        </div>
        <div class = "clearfix"></div>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Strona Główna</a>
                </li>
                <?php
                if(isset($_SESSION['log'])&&($_SESSION['log']==true))
                {
                    ?>
                <li>
                    <a href="myAccount.php">Moje Konto</a>
                <li>
                    <a href = "logout_index.php">Wyloguj się</a>
                </li>
                <?php
                }
                ?>
            </ul>
            <div class = "clearfix"> </div>
        </nav>
    </header>

    <div class = "web_page" >
		<section id = "login">
			<article id = "login">
				<div id="main">
					<div id="login">
						<div id="label_login" class="titles" >Logowanie</div>
						<div id="form">
							<form action="login_operation.php" method="post">
								<label>Podaj login</label>
								<input type="text2" name="login" ><br />
								<div class = "clearfix"></div>
								<label>Podaj hasło</label>
								<input type="password" name="password" ><br />
								<div class = "clearfix"></div>
								<input type="submit" value="Zaloguj się" class="button"/><br/>
								<?php if(isset($_SESSION['mistake'])) echo $_SESSION['mistake']; ?>
							</form>
						</div>
					</div>
		</article>
	</section>
				<section id = "register">
					<article id = "register">
						<div id="register">
						<div id="label_login" class="titles" >Zarejestruj</div>
						<div id="reg_form">
<form method="post">
	<label>Podaj login</label>
	<input type="text2" name="a_login"><br/>
	<?php
			if (isset($_SESSION['e_login']))
			{
				echo '<div class="error">'.$_SESSION['e_login'].'</div>';
				unset($_SESSION['e_login']);
			}
	?>
	<label>Podaj hasło</label>
	<input type="password" name="a_password1"><br/>
		<?php
			if (isset($_SESSION['e_password']))
			{
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
		?>
	<label>Powrtórz hasło</label>		
	<input type="password" name="a_password2"><br/>
	<label>Podaj imię</label>
	<input type="text2" name="a_first_name"><br/>
		<?php
			if (isset($_SESSION['e_first_name']))
			{
				echo '<div class="error">'.$_SESSION['e_first_name'].'</div>';
				unset($_SESSION['e_first_name']);
			}
		?>
	<label>Podaj nazwisko</label>		
	<input type="text2" name="a_surname"><br/>
		<?php
			if (isset($_SESSION['e_surname']))
			{
				echo '<div class="error">'.$_SESSION['e_surname'].'</div>';
				unset($_SESSION['e_surname']);
			}
		?>
	<label>Podaj email</label>
	<input type="text2" name="a_email"><br/>
	<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
	?>
	<div class="g-recaptcha" data-sitekey="6LdMMD0UAAAAANt1JCh9RCW-BCE4YWIYElkAGHXL"></div>
	<?php
			if (isset($_SESSION['e_bot']))
			{
				echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
				unset($_SESSION['e_bot']);
			}
	?>		
	<input type="submit" value="Zarejsetruj się" class="button"/><br/>
</form>
</div>
						</div>
					</article>
				</section>
				</div>

</body>
</html>
