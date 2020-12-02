<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />

    <title>Modyfikowanie</title> 
    <link rel="stylesheet" href="css/style2.css" "type/css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>	
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
                session_start();
if(isset($_SESSION['log'])&&($_SESSION['log']==true)&&!empty($_POST))
{
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
                <li>
                    <a href="myAccount.php">Moje Konto</a>
                </li>
                <?php
                require_once "connect.php";
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $idUser=$_SESSION['idUser'];
                $sql = "SELECT * FROM person WHERE id = $idUser ";
                $result=$polaczenie->query($sql);
                $row= $result->fetch_assoc();
                if($row['admin']==TRUE)
                {
                ?>
                <li id = 'adminMenu'><a href="#">Panel admina</a>
                    <ul>
                        <li>
                            <a href="addBook.php">Dodaj książkę</a>
                        </li>
                        <li>
                            <a href="searchBookToModify.php">Modyfikuj książki</a>
                        </li>
						<li>
                            <a href="searchBookToDelete.php">Usuń książki</a>
                        </li>
                        <li>
                            <a href="searchUserToModify.php">Modyfikuj użytkowników</a>
                        </li>
						<li>
                            <a href="searchUserToDelete.php">Usuń użytkowników</a>
                        </li>
                    </ul>
                    <?php
                }
                    ?>
                    <li id = "logout">
                        <a href = "logout_index.php">Wyloguj się</a>
                </li>
            </ul>
            <div class = "clearfix"> </div>
        </nav>
    </header>

    <div class = "web_page" >
    <?php
    $_SESSION['idUserToModify'] = $_POST['modify'];
	$idToFill=$_POST['modify'];
	
	require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
    }
    else
    {
		$resultPerson = $polaczenie->query("SELECT * FROM person WHERE id = '$idToFill'");
		
		$rowPerson = $resultPerson->fetch_assoc();
		
		echo "<h2>Modyfikuj użytkownika</h2>";
		echo "<form action= 'modify_single_user.php' method = 'POST'>";
		echo "<label>Imię</label><br/>";
		$firstName = $rowPerson['firstName'];
		echo " <input type='textSearch' placeholder = '$firstName' name='name' pattern='[a-zA-Z]{1,}'><br>";
		echo "<label>Nazwisko</label><br/>";
		$surname = $rowPerson['surname'];
		echo" <input type='textSearch' placeholder = '$surname' name='surname' pattern='[a-zA-Z]{1,}'><br>";
		echo "<label>Login</label><br/>";
		$login = $rowPerson['login'];
		echo" <input type='textSearch' placeholder = '$login' name='login' pattern='[a-zA-Z0-9]{1,}'><br>";
		echo "<label>Email</label><br/>";
		$email = $rowPerson['email'];
		echo" <input type='textSearch' placeholder = '$email' name='email'><br>";
		echo "<label>Hasło</label><br/>";
		echo"  <input type='password' id = 'passwordModify' name='password'><br>";
		echo " <button name = 'modifyButton' onclick =\"return confirm('Czy jestes pewien?');\" class = 'button' > Zmien  </button> ";
		echo" </form>";
	}
}
else
header("Location: index.php");

    ?> 
    </div>
</body> 
</html> 