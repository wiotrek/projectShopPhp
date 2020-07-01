<?php
    session_start();

    if(!isset($_SESSION['loggin']))
        header("Location: index.php");

    //id obecnego klienta
    $idClient = $_SESSION['loggin'];
    //ilosc produktow ktore kupilismy
    $countOrder = $_POST['countOrder'];
    //id produktu
    $idProductsOrder = $_POST['productIdOrder'];
    //kwota produktu za sztuke
    $cashProductOrder = $_POST['productCashOrder'];

    try{
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'UTF8'",
            PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
        );
        $dbh = new PDO("mysql:host=localhost;dbname=projekt3", "root", "", $options);

        $cashProductOrderAll = $countOrder * $cashProductOrder;
        
        $stmt = $dbh->prepare("INSERT INTO zamowienia (id, id_klienta, id_produktu, ilosc, cena_za_szt, cena_razem) 
        VALUES (Null, :id_klienta, :id_produktu, :ilosc, :cena_za_szt, :cena_razem);");
        $stmt->bindParam(":id_klienta", $idClient, PDO::PARAM_INT);
        $stmt->bindParam(":id_produktu", $idProductsOrder, PDO::PARAM_INT);
        $stmt->bindParam(":cena_za_szt", $cashProductOrder, PDO::PARAM_INT);
        $stmt->bindParam(":ilosc", $countOrder, PDO::PARAM_INT);
        $stmt->bindParam(":cena_razem", $cashProductOrderAll, PDO::PARAM_INT);
   
        $stmt->execute();
        $stmt->closeCursor();

        $dbh = null;

        header("Location: index.php");



    }catch(PDOException $e){
        echo "Error: ". $e->getMessage();

        $_SESSION['registerFailed'] = 5;
        header("Location: index.php");
    }
