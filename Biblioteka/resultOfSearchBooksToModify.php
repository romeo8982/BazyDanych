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
        $title = $_POST['search'];
        $title = htmlentities($title,ENT_QUOTES,"UTF-8");//sql injaction
        
        if($result = @$polaczenie->query(sprintf("SELECT*FROM book WHERE title LIKE '%%%s%%'",
		mysqli_real_escape_string($polaczenie,$title))))
        {
            $numberOfRows = $result->num_rows;
            if($numberOfRows<=0)
            {
                echo "Nie znaleziono ksiazki o podanym tytule";
            }
            
            else
            {
                
                while($row = $result->fetch_assoc()){
                $idBook = $row['id'];
                $resultCopy = $polaczenie->query("SELECT * FROM copy_book WHERE idBook = '$idBook'");
                $rowCopy = $resultCopy->fetch_assoc();
                 echo " <table id = 'tableResult' border ='1' cellpadding = '10' cellspacing = '0' width = '35%'>";
                 echo "<br>";
                 echo " <form action= 'modifyBook.php' method = 'POST'> ";
                 echo "<br>";
                 echo " <tr> <td id='tytul'>Id ksiazki </td>  <td>"; 
                 $idCopy = $rowCopy['id'];
                 echo $row['id'];
                 echo " </td> </tr><tr>  <td> Id kopii </td> <td>";            
                 echo $rowCopy['id'];
                 echo " </td> </tr><tr>  <td> Wydawnictwo </td> <td>";            
                 echo $rowCopy['publishingHouse'];
                 echo " </td> </tr><tr>  <td> Data publikacji </td> <td>";            
                 echo $rowCopy['publicationDate'];
                 echo " </td> </tr><tr>  <td> Stan egzemplarza </td> <td>";            
                 echo $rowCopy['conditionOfCopy'];
                 echo " </td> </tr><tr>  <td> Tytul </td> <td>";            
                 echo $row['title'];
                 echo " </td> </tr><tr>  <td> Autor </td> <td>"; 
                 echo $row['author'];
                 echo " </td> </tr> <tr>  <td> Ilosc dostepnych sztuk </td><td>"; 
                 echo $row['amountOfAvailable'];
                 echo " </td> </tr> ";
              
                 echo "   </table> ";
                 echo"<div class = 'clearfix'></div>";
                 echo " <button name = 'modify' value = '$idBook' class = 'button' > Modyfikuj </button> ";
                 echo "</form>";
                 
                 
                
        
            }
        }
            $result->free_result();
        }
        $polaczenie->close();
        echo "</h5>";
 
    }
}
else
header("Location : index.php");
    ?> 
    </div>
</body> 
</html> 