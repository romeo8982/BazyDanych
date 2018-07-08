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
                <?php
                session_start ();
                if(isset($_SESSION['log'])&&($_SESSION['log']==true))
                {
                    ?>
                <li>
                    <a href="myAccount.php">Moje Konto</a>
                <li id = "logout">
                    <a href = "logout_index.php">Wyloguj się</a>
                </li>
                <?php
				}
				else
				{
				?>
				<li id = "logout">
				<a href = "login.php">Zaloguj się</a>
				</li>
				<?php
				}
                ?>
            </ul>
            <div class = "clearfix"> </div>
        </nav>
    </header>

    <div class = "web_page" >
<div id="main">
<div id="high">

	
	<div id="biblioteka"><a href="index.php" class="title">Biblioteka</a> </div>
	<form action= "searchBookToBorrow.php" method = "post">  
	<div id="searchbox"><input type="text" name="search" placeholder ="Wyszukaj książki" required></div>
</div>

</body>
</html>