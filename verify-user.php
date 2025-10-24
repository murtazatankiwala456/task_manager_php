<?php
session_start();
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];

    if(empty($email)|| empty($password)){

    $_SESSION["error"]  = "Please fill all the fields!";
    header("Location:index.php");
    die();
   

    }else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $_SESSION["error"]= "Please Enter Valid Email Address!";
                  header("Location: index.php");
                die();
                
           }else{
                try {
                    require_once "DB-connection.php";
                      $query = "SELECT * FROM users WHERE email = :email";
                        $stmt = $pdo->prepare($query);

                        $stmt->bindParam(":email",$email);
         
                         $stmt->execute();

                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        $pdo = null;
                         $stmt = null;

                   if(!$user){
                        $_SESSION["error"]= "No user is available with this email!";
                         header("Location: index.php");
                         die();
                   }
         

                if(password_verify($password,$user["pwd"])){
                     $_SESSION["user_id"] = $user["user_id"];
                     $_SESSION["username"] = $user["username"];
                        header("Location: tasks.php");
                    die();

                 }else {
                     $_SESSION["error"] = "Invalid  password!";
                    header("Location: index.php");
                    die();
            }

        }catch (PDOException $e) {
            echo "Query Failed!" . $e->getMessage();
        }
    }   

        }else {
        header("Location: index.php");
        die();
    }