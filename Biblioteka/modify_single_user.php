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
                //echo"<p>Witaj ".$_SESSION['firstName']." ".$_SESSION['surname'].'![<a href="logout_index.php">Wyloguj się</a>]';
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
    echo "<a href='index.php'>Strona glowna</a>";
    require_once "connect.php";
  
    
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
    }
    else
    {
        if(isset($_POST['modifyButton']))
        {
            $isLoginFromDB = FALSE;     //zmienna informujaca o tym czy login jest pobrany z bazy danych
            $idUser = $_SESSION['idUserToModify'];
            $resultUser = $polaczenie->query("SELECT * FROM person WHERE id = '$idUser' ");
            $rowUser = $resultUser->fetch_assoc();
            $name =$_POST['name'] ;
            
            if($name=="")
                $name = $rowUser['firstName'];
            $surname = $_POST['surname'] ;
            if($surname=="")
                $surname = $rowUser['surname'];
            $login = $_POST['login'] ;
            if($login=="")
            {
                $login = $rowUser['login'];
                $isLoginFromDB = TRUE;      //pobieramy login z bazy danych, wiec zmienna = true
            }
            $email =$_POST['email'] ;
            if($email=="")
                $email = $rowUser['email'];
            $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $login = htmlentities($login,ENT_QUOTES,"UTF-8");//sql injaction

            $resultUserLogin = $polaczenie->query(sprintf("SELECT * FROM person WHERE login ='$login'",
			mysqli_real_escape_string($polaczenie,$login)));
            if($resultUserLogin->num_rows > 0 && $isLoginFromDB==FALSE)
                echo "<h1>Uzytkownik o podanym loginie juz istnieje!!</h1>";
            else
            {
                $name = htmlentities($name,ENT_QUOTES,"UTF-8");//sql injaction
				$surname = htmlentities($surname,ENT_QUOTES,"UTF-8");//sql injaction
				$email = htmlentities($email,ENT_QUOTES,"UTF-8");//sql injaction
				
                if($password_hash== "")
				{
				if($polaczenie->query(sprintf("UPDATE person SET firstName='%s', surname='%s', login ='%s', email ='%s' WHERE id ='$idUser'",
				mysqli_real_escape_string($polaczenie,$name),
				mysqli_real_escape_string($polaczenie,$surname),
				mysqli_real_escape_string($polaczenie,$login),
				mysqli_real_escape_string($polaczenie,$email))))
                {
                  header('Location:myAccount.php');
                }
                  else
                     echo 'cos poszlo nie tak';
				}
				else
				{	
				if($polaczenie->query(sprintf("UPDATE person SET firstName='%s', surname='%s', login ='%s', email ='%s' , password= '%s' WHERE id ='$idUser'",
				mysqli_real_escape_string($polaczenie,$name),
				mysqli_real_escape_string($polaczenie,$surname),
				mysqli_real_escape_string($polaczenie,$login),
				mysqli_real_escape_string($polaczenie,$email),
				mysqli_real_escape_string($polaczenie,$password_hash))))
                {
                  header('Location:myAccount.php');
                }
                  else
                     echo 'cos poszlo nie tak';
				}
            }
            $polaczenie->close();
        }
        
     
     

    }
}
else
header("Location: index.php");
    ?> 
    </div>
</body> 
</html> 