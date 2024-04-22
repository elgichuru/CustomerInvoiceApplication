//file to be called by the require_once function
<?php
    $dsn='mysql:host=localhost;dbname=mmabooks';
    $username='Mutwiri';
    $password='Reztraint@90!';
            
            try{
                $db=new PDO($dsn,$username,$password);
            } catch (PDOException $e) {
                $errormessage=$e->getMessage();
                include 'database_error.php';
                exit();
            }
