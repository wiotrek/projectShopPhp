<?php
session_start();

require_once("products.php");

//site=[numer] w linku pokazuje wyzszy numer niz rzeczywista zmienna $currentSite

//zmiana strony oraz indeksu produktu
if (!isset($_GET['site'])) {
    $currentSite = 0;
} else {
    $getSite = $_GET['site'] + 1;
    if ($getSite == $countResults)
        $currentSite = 0;
    else
        $currentSite = $getSite;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Folder3</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
    <script src="skrypt.js"></script>

</head>

<body>
    <header>
        <h1>Sklep</h1>
    </header>
    <menu>
        <ul>
            <?php
            if (isset($_SESSION['loggin'])) {
                $userName = $_SESSION['userName'];
                echo "<li>Jestes zalogowany $userName </li>";
                echo "<li><a href='?logout'>Wyloguj sie</a></li>";
            } else {
                echo "<li class='hideLogging'>Chcesz sie zalogowac?</li>";
                echo "<li class='hideLogging'><button class='logging'>Logowanie</button></li>";

                echo "<li class='hideRegister'>Nie masz konta?</li>";
                echo "<li class='hideRegister'><button class='registerButton'>Rejestracja</button></li>";
            }

            if (isset($_SESSION['registerFailed'])) {
                switch ($_SESSION['registerFailed']) {
                    case 1:
                        echo "<li class='registerFailed'>Istnieje juz taki uzytkownik</li>";
                        break;
                    case 2:
                        echo "<li class='registerFailed'>Zle haslo lub login</li>";
                        break;
                    case 3:
                        echo "<li class='registerFailed'>Podane dane rejestracyjne zawieraja blad</li>";
                        break;
                    case 4:
                        echo "<li class='registerFailed'>Blad logowania</li>";
                        break;
                    case 5:
                        echo "<li class='registerFailed'>Nie udalo sie kupic produktu</li>";
                        break;
                }


                session_destroy();
            }

            if (isset($_GET['logout'])) {
                $_SESSION['loggin'] = 0;
                session_destroy();
                header("Location: index.php");
            }

            ?>
        </ul>
    </menu>

    <main>
        <div class="upSide">
            <!-- <div class='basket'>
                    <ul>
                        <li>Zakupione przedmioty:</li>
                        <li>Kwota do zaplaty:</li>
                        <li>Zakupione przedmioty:</li>
                        <li>Kwota do zaplaty:</li>
                    </ul>
                </div> -->
        </div>
        <div class="leftSide">
            <div class="borderPicture">
                <?php
                $getPicture = $stmtFetch[$currentSite]['zdjecie'];
                echo "<img class='imgPicture' src='assets/$getPicture'>";
                ?>
            </div>
        </div>
        <div class="rightSide">

            <div class="rsHeading">
                <h3>
                    <?php
                    echo $stmtFetch[$currentSite]['nazwa'];
                    ?>
                </h3>
            </div>
            <div class="rsDescription">
                <p>
                    <?php
                    echo $stmtFetch[$currentSite]['opis'];
                    ?>
                </p>
                <p>
                    <?php
                    echo "cena: " . $stmtFetch[$currentSite]['cena'];
                    ?>
                </p>
                <form action='order.php' method='post'>
                    <?php
                    if (isset($_SESSION['loggin'])) {
                        $getProductId = $stmtFetch[$currentSite]['id'];
                        $getProductCash = $stmtFetch[$currentSite]['cena'];
                        echo "<input type='hidden' name='productIdOrder' value='$getProductId' />";
                        echo "<input type='hidden' name='productCashOrder' value='$getProductCash' />";

                        echo "<p>";
                        echo "<button class='pluseOrder' value='+'>+</button>";
                        echo "<input type='text' class='countOrder' value='1' name='countOrder' />";
                        echo "<button class='minuseOrder'>-</button>";
                        echo "</p>";
                        echo "<p>";
                        echo "<button>Dodaj do koszyka</button>";
                        echo "</p>";
                        echo "<p>";
                        echo "<button type='submit'>Zakoncz i zaplac</button>";
                        echo "</p>";
                    }
                    ?>
                </form>
                <p>
                    <?php
                    echo "<button><a href='?site=$currentSite'>Nastepna strona</a></button>";
                    ?>
                </p>
            </div>
        </div>
    </main>
</body>
</html>