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
            session_start ();
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
        <aside>
            <h2>Menu</h2>
            <nav>
                <ul>
                    <li>
                        <a href = "MyAccount.php">Moje dane</a>
                    </li>
                    <li>
                    <a href = "MyAccountBorrowed.php">Wypożyczenia</a>
                    </li>
                </ul>

            </nav>
        </aside>
        <section id ="user">
            <?php
            ?>
            <article id ="user">
                <h2>Dane Użytkownika</h2>
                <h4>
                <?php
                    echo "<table border ='0' cellpadding = '7' cellspacing = '0'>";
                    echo "<tr><td>Imie: </td><td>";
                    echo $row['firstName'];
                    echo "</td></tr>";
                    echo "<tr><td>Nazwisko: </td><td>";
                    echo $row['surname'];
                    echo "</td></tr>";
                    echo "<tr><td>login: </td><td>";
                    echo $row['login'];
                    echo "</td></tr>";
                    echo "<tr><td>email: </td><td>";
                    echo $row['email'];
                    echo "</td></tr>";
                    echo "<tr><td>Ilosc wypozyczonych ksiazek</td><td> ";
                    echo $row['amountOfRented'];
                    echo "</td></tr>";
                 ?>
                </h4>
            </article>
            <?php
            if(isset($_POST['borrowed']))
            {
                ?>
                <article id ="borrowedBooks">
                    <h2>Wypożyczone książki</h2>
                    <h4>
                    <?php
                    $sqlBorrowedBooks = "SELECT * FROM lend WHERE idPerson = '$idUser' ";
                    $resultBorrowedBooks = $polaczenie->query($sqlBorrowedBooks);
                    while($rowBorrowedBooks = $resultBorrowedBooks->fetch_assoc())
                    {     //petla do wyswietlania tabeli
                         echo " <br><table border ='1' cellpadding = '10' cellspacing = '0' align = 'center'>";
                        echo " <tr> <td> Tytul ksiazki </td> <td>";    
                        $idBook = $rowBorrowedBooks['idBook'];
                        $sqlTitleOfBook = "SELECT * FROM book WHERE id = '$idBook'";
                        $resultTitleOfBook = $polaczenie->query($sqlTitleOfBook);
                        $rowTitleOfBook = $resultTitleOfBook->fetch_assoc();
                        $_SESSION['title'] = $rowTitleOfBook['title'];
                        echo $rowTitleOfBook['title'];
                        echo " </td> </tr><tr>  <td> data wypozyczenia </td> <td>"; 
                        echo $rowBorrowedBooks['dateOfLend'];
                        echo " </td> </tr> <tr>  <td> Data do zwrotu </td><td>"; 
                        echo $rowBorrowedBooks['dateOfReturn'];
                        echo " </td> </tr> <tr>  <td> Czy przedluzano termin </td><td>"; 
                        echo $rowBorrowedBooks['extendedDateOfReturn'];
                        echo " <form action= 'return_book.php' method = 'POST'> ";
                        echo " <button name = 'return' value = '$idBook' > Zwroc ksiazke </button> "; 
                        echo " <button name = 'extend' value = '$idBook' > Przedluz </button> ";
                        echo " </form> </td> </tr></table>  ";  
                    } 
                ?> 
                    </h4>
                </article>
                <?php
            }
}
else
header('Location: index.php');
                ?>
        </section>
        <div class = "clearfix"></div>
    </div> 

</body> 
</html> 