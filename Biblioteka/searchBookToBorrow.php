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
    require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
    }
    else
    {
        echo "<h5>";
        $wyszukiwanyTytul = $_POST['search'];
        $wyszukiwanyTytul = htmlentities($wyszukiwanyTytul,ENT_QUOTES,"UTF-8");//sql injaction
       // $sql = "SELECT*FROM book WHERE title LIKE '%$wyszukiwanyTytul%'"; 

       if($rezultat = @$polaczenie->query(sprintf("SELECT*FROM book WHERE title LIKE '%%%s%%'",
       mysqli_real_escape_string($polaczenie,$wyszukiwanyTytul))))
        {
            $id = 1;
            $iloscZnalezionych = $rezultat->num_rows;
            if($iloscZnalezionych<=0)
            {
                echo "<h1>Nie znaleziono książki o podanym tytule</h1>";
            }
            else
            {
                while($wiersz = $rezultat->fetch_assoc())
                {
                    $tabIdKsiazki[$id] = $wiersz['id'];
                    $tab[$id]['tytul'] = $wiersz['title'];
                    $tab[$id]['autor'] = $wiersz['author'];
                    $tab[$id]['amount'] = $wiersz['amountOfAvailable'];
                    $idBook = $wiersz['id'];
                    $ifLog = "";
                    if(isset($_SESSION['log'])&&($_SESSION['log']==true))
                        $ifLog = "borrowBook.php";
                    else
                        $ifLog = "login.php";
                    
                    echo " <table id = 'tableBorrow' border ='1' cellpadding = '2' cellspacing = '1' >";
                        if($id==1)
                        {
                            ?>
                            <tr>
                                <th>Tytuł</th>
                                <th>Autor</th>
                                <th colspan = '2'>Ilość dostępnych sztuk</th>
                                
                            </tr>
                            
                            <?php
                           
                        }
                        
                        echo " <form action= '$ifLog' method = 'POST'> "; 
                            echo "<tr height = '60'><td width='40%' >";    
                                echo $wiersz['title'];
                                echo "<td width='40%'>"; 
                                echo $wiersz['author'];
                                echo "<td width='15%'>";
                                echo $wiersz['amountOfAvailable'];
                                echo " <button name = 'borrow' value = '$idBook' class= 'buttonSearch' > Wypozycz </button>  ";
                            echo "</td> </tr> ";
                        echo " </form> ";
                    echo "</table> ";
                    echo "<br>";
                    $id++;
                    $_SESSION['tablica'] = $tab; 
                }
            }
            $rezultat->free_result();
        }
        $polaczenie->close();
        echo "</h5>";
    }
}
else
header("Location: index.php");
    ?> 
    </div>
</body> 
</html> 