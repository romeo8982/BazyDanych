<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />

    <title>Wyszukiwanie</title> 
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
if(isset($_SESSION['log'])&&($_SESSION['log']==true))
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
<body> 
    <?php
        echo"<form action= 'resultOfSearchUsersToModify.php' method = 'post'>";  
        echo"<div id='searchbox'><input type='textSearch' name='search' placeholder ='Wyszukaj Uzytkownika' required></div>";
        echo "<button name = 'searchButton' class= 'button' >Wyszukaj </button> ";
        echo"</div>";
}
else
header("Location: index.php");
    ?> 
    </div>
</body> 
</html> 