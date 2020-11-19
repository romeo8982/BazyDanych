<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />

    <title>Dodawanie tytulu</title> 
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
    date_default_timezone_set("Europe/Warsaw");
    $error = false;
    require_once "connect.php";
  
    
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
    }
    else
    {
      
        if(isset($_POST['addButton']))
        {
            $tytul =$_POST['tytul'] ;
            $autor = $_POST['autor'] ;
            $ilosc = $_POST['ilosc'] ;
            $wydawnictwo =$_POST['wydawnictwo'] ;
            $dataW = $_POST['dataW'] ;  //data wydania
            $condition = $_POST['condition'];
            if($dataW> date('Y'))
            {
                ?>
                <h1>Wystąpił błąd w formularzu</h1>
                <script>
                setTimeout(function(){window.location.href= "myAccount.php"; } , 3000); 
                </script>
                <?php
            }
            else
            {
         
                $sqlAddBook = "INSERT INTO book (title, author, amountOfAvailable, amountOfAll ) VALUES ('$tytul', '$autor', '$ilosc', '$ilosc')";    //umieszczamy nowy tytul w 'book'
                if($polaczenie->query($sqlAddBook))
                {
                    $idBook = $polaczenie->insert_id;   //id dodanej ksiazki
                    $sqlCopyOfBook = "INSERT INTO copy_book (publishingHouse, conditionOfCopy, publicationDate, idBook) VALUES ('$wydawnictwo', '$condition', '$dataW', '$idBook')";   //umieszczamy nowa kopie w 'copy_book'
                    if( $polaczenie->query($sqlCopyOfBook))
                    ?>
                    <h1>Książka została dodana</h1>
                    <script>
                    setTimeout(function(){window.location.href= "myAccount.php"; } , 2000); 
                    </script>
                    <?php
                }
                else
                echo '<h1>Coś poszło nie tak</h1>';

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