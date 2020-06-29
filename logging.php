<?php

    session_start();

    if($_SESSION['loggin'])
        header("Location: index.php");
    else{
        $login = $_POST['login'];
        $pass = $_POST['pass'];
    
        try{
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'UTF8'",
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );
            $dbh = new PDO("mysql:host=localhost;dbname=projekt3", "root", "", $options);
            
            
            $stmt = $dbh->prepare("SELECT id, name FROM klienci WHERE login= :login AND password= :pass;");
    
            $stmt->bindValue(":login", $login, PDO::PARAM_STR);
            $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
    
            //stmtFetch potrzebny jest do policzenia ilosci wynikow
            $stmtFetch = $stmt->fetchAll();
    
            if( count($stmtFetch) ){
                $_SESSION['loggin'] = $stmtFetch[0]['id'];
                $_SESSION['userName'] = $stmtFetch[0]['name'];
                header("Location: index.php");
            }else{
                $_SESSION['registerFailed'] = 2;
                header("Location: index.php");
            }
            $stmt->closeCursor();
    
            $dbh = null;
    
        }catch(PDOException $e){
            echo "Error: ". $e->getMessage();
        }
    }

    
?>