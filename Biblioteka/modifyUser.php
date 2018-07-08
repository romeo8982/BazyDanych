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
                            <a href="searchUserToModify.php">Modyfikuj użytkowników</a>
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
    echo "<h2>Modyfikuj użytkownika</h2>";
    echo "<form action= 'modify_single_user.php' method = 'POST'>";
    echo " <input type='textSearch' name='name' placeholder = 'Imię ' pattern='[a-zA-Z]{1,}'><br>";
    echo" <input type='textSearch' name='surname' placeholder = 'Nazwisko' pattern='[a-zA-Z]{1,}'><br>";
    echo" <input type='textSearch' name='login' placeholder = 'login ' pattern='[a-zA-Z0-9]{1,}'><br>";
    echo" <input type='textSearch' name='email' placeholder = 'email '><br>";
    echo"  <input type='password' id = 'passwordModify' name='password' placeholder = 'hasło '><br>";
    echo " <button name = 'modifyButton' class = 'button' > Zmien  </button> ";
    echo" </form>";
}
else
header("Location: index.php");

    ?> 
    </div>
</body> 
</html> 