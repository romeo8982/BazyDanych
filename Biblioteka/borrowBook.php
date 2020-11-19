<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Wypozyczanie</title> 
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
    date_default_timezone_set("Europe/Warsaw");
    
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
    }
    else
    {
        $_SESSION['idKsiazki'] = $_POST['borrow'];
        $userId = $_SESSION['idUser'];
        $resultUser = $polaczenie->query("SELECT * FROM person WHERE id = '$userId'");
        $rowUser=$resultUser->fetch_assoc();
        $amountOfRented = $rowUser['amountOfRented'];
        $idBook = $_SESSION['idKsiazki'];

        if($amountOfRented<5 )  //sprawdzamy czy uzytkownik nie wypozyczyl juz wiecej ksiazek niz dozwolone 5
        {
            $idk = $_SESSION['idKsiazki'];
            $sql = "SELECT*FROM book WHERE id = '$idk'";
            $rezultat = @$polaczenie->query($sql);
            $wiersz = $rezultat->fetch_assoc();
            $zmienna = $wiersz['amountOfAvailable'];
            if($zmienna>0)
            {
                $zmienna --;
                $date = date('Y-m-d H:i:s');     //aktualna data
                $resultLend = $polaczenie->query("SELECT * FROM lend WHERE dateOfReturn < '$date'") ;    //wybieramy z bazy danych wypozyczenia ktorych termin zwrotu minal
                $numOfRowsLend = $resultLend->num_rows; //w zmiennej umieszczamy ilosc wierszy
                if($numOfRowsLend>0)    //sprawdzamy czy jest ksiazka, ktora powinna juz byc zwrocona
                    echo "<h1>Proszę zwrócić książkę która jest już po terminie zwrotu</h1>";
                else
                {
                    $polaczenie->query("SET AUTOCOMMIT=0");
                    $polaczenie->query("START TRANSACTION");
            
                    $sqlUpdateAmountOfRented = $polaczenie->query("UPDATE person SET amountOfRented = amountOfRented+1 WHERE id = $userId") or die(mysql_error());
                    $sqlUpdateAmountOfAvailable = $polaczenie->query("UPDATE book SET amountOfAvailable='$zmienna' WHERE id = $idk") or die(mysql_error());
                    $returnDate = date('Y-m-d H:i:s', (strtotime('+30 days',strtotime($date)))); //data zwrotu to aktualna data +30 dni
                    $sqlUpdateLend =$polaczenie->query("INSERT INTO lend (idPerson, idBook, dateOfLend, dateOfReturn, extendedDateOfReturn) VALUES ('$userId', '$idk', '$date','$returnDate' , '0')") or die(mysql_error());
                    if ($sqlUpdateAmountOfRented and $sqlUpdateAmountOfAvailable and $sqlUpdateLend) 
                    {
                        $polaczenie->query("COMMIT");
                        ?>
                        <h1>Książka została wypożyczona</h1>
                        <script>
                            setTimeout(function(){window.location.href= "index.php"; } , 2000); 
                        </script>
                        <?php
                    } 
                    else 
                    {
                        $polaczenie->query("ROLLBACK");
                        ?>
                        <h1>Coś poszło nie tak</h1>
                        <script>
                            setTimeout(function(){window.location.href= "index.php"; } , 3000); 
                        </script>
                        <?php
                    }      
                }
            }
            else
            {
                ?>
                <h1>Niestety, jest za mało książek</h1>
                <script>
                    setTimeout(function(){window.location.href= "index.php"; } , 3000); 
                </script>
                <?php
                $polaczenie->close();
            }
        
        }
        else
        {
            ?>
            <h1>Przykro mi, za dużo juz wypożyczyłeś :(</h1>
            <script>
                setTimeout(function(){window.location.href= "index.php"; } , 3000); 
            </script>
            <?php
        }

    }
}
else
header("Location: index.php"); 
    ?> 
    </div>
</body> 
</html> 