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
    require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
    }
    else
    {
        echo "<h5>";
        $userLogin = $_POST['search'];
        $userLogin = htmlentities($userLogin,ENT_QUOTES,"UTF-8");//sql injaction
       // $sql = "SELECT*FROM person WHERE login LIKE '%$userLogin%'"; 

       if($result = @$polaczenie->query(sprintf("SELECT*FROM person WHERE login LIKE '%%%s%%'",
       mysqli_real_escape_string($polaczenie,$userLogin))))
        {
            $numberOfRows = $result->num_rows;
            if($numberOfRows<=0)
            {
                echo "Nie znaleziono uzytkownika spelniajacego podane kryteria";
            }
            else
            {
                while($row = $result->fetch_assoc()){
                $idUser = $row['id'];
    
                 echo " <table id = 'tableResult' border ='1' cellpadding = '10' cellspacing = '0'>";
                 echo "<br>";
                 echo " <form action= 'modifyUser.php' method = 'POST'> ";
                 echo "<br>";
                 echo " <tr> <td id='tytul'>Id Uzytkownika </td>  <td>"; 
                 echo $row['id'];
                 echo " </td> </tr><tr>  <td> Imie </td> <td>";            
                 echo $row['firstName'];
                 echo " </td> </tr><tr>  <td> Nazwisko </td> <td>";            
                 echo $row['surname'];
                 echo " </td> </tr><tr>  <td> Login </td> <td>";            
                 echo $row['login'];
                 echo " </td> </tr><tr>  <td> Email </td> <td>";            
                 echo $row['email'];
                 echo " </td> </tr><tr>  <td> Ilosc Wypozyczonych ksiazek </td> <td>";            
                 echo $row['amountOfRented'];
                 echo " </td> </tr> ";
                 echo " </td> </tr> </table> ";
                 echo "<div class = 'clearfix'></div>";
                 echo " <button class = 'button' name = 'modify' value = '$idUser' > Modyfikuj </button> ";
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
header("Location: index.php");
    ?> 
    </div>
</body> 
</html> 