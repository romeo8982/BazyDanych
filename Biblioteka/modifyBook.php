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
    $_SESSION['idBookToModify'] = $_POST['modify'];
	$idToFill=$_POST['modify'];
    $date = date('Y');
	
	require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
    }
    else
    {
		$resultCopy = $polaczenie->query("SELECT * FROM copy_book WHERE idBook = '$idToFill'");
		$rowCopy = $resultCopy->fetch_assoc();
		
		$idBookCopy = $rowCopy['idBook'];
		
		$resultBook = $polaczenie->query("SELECT * FROM book WHERE id = '$idBookCopy'");
		
		$rowBook = $resultBook->fetch_assoc();
		
		echo "<h2> Modyfikuj książkę</h2>";
		echo "<form action= 'modify_single_book.php' method = 'POST'>";
		echo "<label>Tytuł</label><br/>";
		$titleCopy = $rowBook['title'];
		echo "<input type='textSearch'pattern='[a-zA-Z0-9\s]{1,}' placeholder = '$titleCopy' name='tytul'><br>";
		echo "<label>Autor</label><br/>";
		$authorCopy = $rowBook['author'];
		echo "<input type='textSearch' pattern='[a-zA-Z\s]{1,}' placeholder = '$authorCopy' name='autor'><br>";
		echo "<label>Wydawnictwo</label><br/>";
		$publishingHouseCopy = $rowCopy['publishingHouse'];
		echo" <input type='textSearch' placeholder = '$publishingHouseCopy' name='wydawnictwo'><br>";
		echo "<label>Data wydania</label><br/>";
		$publicationDateCopy = $rowCopy['publicationDate'];
		echo" <input type='number' placeholder = '$publicationDateCopy' min='1500' max='$date' name='dataW'><br>";
		echo "<label>Ilość</label><br/>";
		$amountOfAllCopy = $rowBook['amountOfAll'];
		echo" <input type='number' placeholder = '$amountOfAllCopy' min='0' name='ilosc'><br>";
		echo "<label>Kondycja</label><br/>";
		$conditionOfCopy = $rowCopy['conditionOfCopy'];
		if($conditionOfCopy=='nowa')
		{
			echo"<select name = 'condition'> 
					<option selected value = 'nowa'>Nowa</option>
					<option value = 'używana'>Używana</option>
				</select><br>";
		}
		else
		{
			echo"<select name = 'condition'> 
					<option value = 'nowa'>Nowa</option>
					<option selected value = 'używana'>Używana</option>
				</select><br>";
		}
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