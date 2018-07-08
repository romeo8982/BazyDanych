<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />

    <title>Moje konto</title> 
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
    date_default_timezone_set("Europe/Warsaw");
    require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    $idUser=$_SESSION['idUser'];
    if(isset($_POST['return']))
    {
        $idBook = $_POST['return']; //zapisujemy w zmiennej id ksiazki pobranej metoda POST
        $resultPerson = $polaczenie->query("SELECT * FROM person WHERE id = '$idUser'");        //wybieramy z bazy danych person danego uzytkownika
        $rowPerson = $resultPerson->fetch_assoc();
        $resultLend = $polaczenie->query("SELECT * FROM lend WHERE idPerson = '$idUser' && idBook='$idBook'");      //wybieramy z bazy danych lend, gdzie zgadza sie ID uzytkownika i ID ksiazki
        $rowLend = $resultLend->fetch_assoc();
        $resultTitle = $polaczenie->query("SELECT * FROM book WHERE id='$idBook'");
        $rowTitle = $resultTitle->fetch_assoc();
        $title = $rowTitle['title'];
        $date = date('Y-m-d H:i:s');
        $firstName = $rowPerson['firstName'];
        $dateOfLand = $rowLend['dateOfLend'];
        $surname =$rowPerson['surname'];
        $idLend=$rowLend['id'];
        $resultCopy = $polaczenie->query("SELECT * FROM copy_book WHERE idBook = '$idBook'");
        $rowCopy = $resultCopy->fetch_assoc();
        $idCopy = $rowCopy['id'];
        $condition = $rowCopy['conditionOfCopy'];
        $polaczenie->query("SET AUTOCOMMIT=0");
        $polaczenie->query("START TRANSACTION");

        $sqlInsertIntoArch = $polaczenie->query("INSERT INTO archives (idPerson, firstName, surname, idBook, title, idLend, dateOfLend, dateOfReturn, idCopy, conditionOfCopy) VALUES ('$idUser', '$firstName','$surname', '$idBook', '$title', '$idLend','$dateOfLand', '$date', '$idCopy', '$condition')") or die(mysql_error());    //dodajemy do archiwum
        $sqlDeleteFromLend = $polaczenie->query("DELETE FROM lend WHERE idPerson = '$idUser' && idBook='$idBook' && id ='$idLend'") or die(mysql_error());   //usuwamy wypozyczenie
        $sqlUpdateAmountOfRented = $polaczenie->query("UPDATE person SET amountOfRented = amountOfRented-1 WHERE id = '$idUser' ")or die(mysql_error()); 
        $sqlUpdateAmountofAvailable = $polaczenie->query("UPDATE book SET amountOfAvailable = amountOfAvailable+1 WHERE id = '$idBook'")or die(mysql_error()); 
        if($sqlInsertIntoArch and $sqlDeleteFromLend and $sqlUpdateAmountOfRented and $sqlUpdateAmountofAvailable)
        {
            $polaczenie->query("COMMIT");
            ?>
            <h1>Dziękujemy za zwrot książki</h1>
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
        $polaczenie->close();

    }
    elseif(isset($_POST['extend']))
    {
        $idBook = $_POST['extend'];
        $resultPerson = $polaczenie->query("SELECT * FROM person WHERE id = '$idUser'");
        $rowPerson = $resultPerson->fetch_assoc();
        $resultLend = $polaczenie->query("SELECT * FROM lend WHERE idPerson = '$idUser' && idBook='$idBook'");
        $rowLend = $resultLend->fetch_assoc();
        $isExtended = $rowLend['extendedDateOfReturn'];     //zmienna rowna wartosci w kolumnie 'extendedDateOfReturn' dla danego uzytkownika
        if($isExtended==0)  //sprawdzamy czy uzytkownika nie przedluzal juz terminu oddania ksiazki
        {
            $dateOfReturn = $rowLend['dateOfReturn'];
            $returnDate = date('Y-m-d H:i:s', (strtotime('+30 days',strtotime($dateOfReturn))));    //przedluzamy termin oddania ksiazki o 30 dni od planowanego terminu zwrotu
            if($sqlUpdateExtendedDate = $polaczenie->query("UPDATE lend SET extendedDateOfReturn = 1, dateOfReturn = '$returnDate' WHERE idPerson = '$idUser' && idBook='$idBook' "))
            {
                ?>
                <h1>Termin wypożyczenia został przedłużony!</h1>
                <script>
                    setTimeout(function(){window.location.href= "myAccount.php"; } , 2000); 
                </script>
                <?php
            }
            else
            {
                ?>
                <h1>Coś poszło nie tak</h1>
                <script>
                    setTimeout(function(){window.location.href= "myAccount.php"; } , 3000); 
                </script>
                <?php  
            }
           
        }
        else
        {
            ?>
            <h1>Niestety, nie możesz już przedłużyć terminu oddania ksiazki</h1>
            <script>
                setTimeout(function(){window.location.href= "myAccount.php"; } , 2000); 
            </script>
            <?php
        }
        $polaczenie->close();
    }
}
else
header("Location: index.php");
    ?> 
    </div>
</body> 
</html> 