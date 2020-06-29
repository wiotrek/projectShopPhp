<?php
    


    session_start();

    if(isset($_SESSION['loggin']))
        header("Location: index.php");
    else{
        
    
        try{
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'UTF8'",
                PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
            );
            $dbh = new PDO("mysql:host=localhost;dbname=projekt3", "root", "", $options);

            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];

            
            
            $stmt = $dbh->prepare("SELECT id FROM klienci WHERE login= :login LIMIT 1");
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);
            
            $stmt->execute();
            $countResults = $stmt->rowCount();
            $stmt->closeCursor();

            

            if($countResults){
                $_SESSION['registerFailed'] = 1;
                header("Location: index.php");
                return false;
            }   
            else{
                try{
                    $stmt = $dbh->prepare("INSERT INTO klienci (login, password, name, surname) VALUES (:login, :pass, :name, :surname);");
                    $stmt->bindParam(":login", $login, PDO::PARAM_STR);
                    $stmt->bindParam(":pass", $pass, PDO::PARAM_STR);
                    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
                    $stmt->bindParam(":surname", $surname, PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt->closeCursor();

                    

                    $stmt = $dbh->prepare("SELECT id, name FROM klienci WHERE login= :login LIMIT 1");
                    $stmt->bindParam(":login", $login, PDO::PARAM_STR);

                    $stmt->execute();
                    

                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    
                    $stmtFetch = $stmt->fetchAll();
            
                    if( count($stmtFetch) ){
                        $_SESSION['loggin'] = $stmtFetch[0]['id'];
                        $_SESSION['userName'] = $stmtFetch[0]['name'];
                        header("Location: index.php");
                        $stmt->closeCursor();
                    }else{
                        $_SESSION['registerFailed'] = 4;
                        header("Location: index.php");
                    }
                    

                }catch(PDOException $e){
                    $_SESSION['registerFailed'] = 3;
                    // header("Location: index.php");
                    echo "Error: ". $e->getMessage();
                }
                
            }
            
    
            
            
            
            
    
            $dbh = null;
    
        }catch(PDOException $e){
            echo "Error: ". $e->getMessage();
        }
    }
?>