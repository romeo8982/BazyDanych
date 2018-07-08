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
    $notError = true;
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
    }
    else
    {
      
        if(isset($_POST['modifyButton']))
        {
            $idBook = $_SESSION['idBookToModify'];         //zapisujemy w zmiennej id ksiazki do modyfikacji
            $resultBook = $polaczenie->query("SELECT * FROM book WHERE id = '$idBook' ");   
            $rowBook = $resultBook->fetch_assoc();
            $resultCopy = $polaczenie->query("SELECT * FROM copy_book WHERE idBook = '$idBook'");
            $rowCopy = $resultCopy->fetch_assoc();
            $idCopy = $rowCopy['id'];
            $tytul =$_POST['tytul'] ;
            $amountOfAvailable = $rowBook['amountOfAvailable'];
            if($tytul=="")                      //sprawdzamy czy pole 'tytul' pozostawiono puste
                $tytul = $rowBook['title'];         //jesli tak, to w zmiennej tytul dajemy wartosc z bazy danych
            $autor = $_POST['autor'] ;
            if($autor=="")
                $autor = $rowBook['author'];
            $iloscWszystkich = $_POST['ilosc'] ;
            if($iloscWszystkich=="")
                $iloscWszystkich = $rowBook['amountOfAll'];
            else
            {
                $roznica = $rowBook['amountOfAll'] - $rowBook['amountOfAvailable'];
                if($iloscWszystkich<$roznica)
                    $notError = false;
                else
                $amountOfAvailable = $iloscWszystkich - $roznica;
            }
            $wydawnictwo =$_POST['wydawnictwo'] ;
            if($wydawnictwo=="")
                $wydawnictwo=$rowCopy['publishingHouse'];
            $dataW = $_POST['dataW'] ;
            if($dataW=="")
                $dataW = $rowCopy['publicationDate'];
            $condition = $_POST['condition'];

            $polaczenie->query("SET AUTOCOMMIT=0");
            $polaczenie->query("START TRANSACTION");
            
            $tytul = htmlentities($tytul,ENT_QUOTES,"UTF-8");//sql injaction
            $autor = htmlentities($autor,ENT_QUOTES,"UTF-8");//sql injaction
            $ilosc = htmlentities($iloscWszystkich,ENT_QUOTES,"UTF-8");//sql injaction
            
            
            $sqlUpdateBook = $polaczenie->query(sprintf("UPDATE book SET title='%s', author='%s', amountOfAll='%s', amountOfAvailable = '$amountOfAvailable' WHERE id='$idBook'",
		mysqli_real_escape_string($polaczenie,$tytul),
		mysqli_real_escape_string($polaczenie,$autor),
        mysqli_real_escape_string($polaczenie,$ilosc)))or die(mysql_error());
        
        $wydawnictwo = htmlentities($wydawnictwo,ENT_QUOTES,"UTF-8");//sql injaction
        $dataW = htmlentities($dataW,ENT_QUOTES,"UTF-8");//sql injaction

            $sqlCopyOfBook = $polaczenie->query(sprintf("UPDATE copy_book SET publishingHouse='%s', conditionOfCopy='$condition', publicationDate='%s' WHERE id = '$idCopy' ",
            mysqli_real_escape_string($polaczenie,$wydawnictwo),
            mysqli_real_escape_string($polaczenie,$dataW)))or die(mysql_error());
            if( $sqlUpdateBook and $sqlCopyOfBook and $notError)
            {
                $polaczenie->query("COMMIT");
                ?>
                <h1>Książka została zmodyfikowana</h1>
                <script>
                setTimeout(function(){window.location.href= "myAccount.php"; } , 2000); 
                </script>
                <?php
                 $polaczenie->close();
            }
            else
            {
                $polaczenie->query("ROLLBACK");
                ?>
                <h1>Coś poszło nie tak</h1>
                <script>
                <setTimeout(function(){window.location.href= "myAccount.php"; } , 2000); 
                </script>
                <?php
                 $polaczenie->close();
            }
            
        }

    }
    
}
else
header("Location: index.php");
    ?> 
    </div>
</body> 
</html> 