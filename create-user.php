<?php
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm-password"];

    if(empty($username)|| empty($email)|| empty($password)|| empty($confirmPassword)){
       $_SESSION["error"]  = "Please fill all the fields!";
        header("Location: register.php");
        die();

    }else if($password !== $confirmPassword){
        $_SESSION["error"]= "Password and confirm password doesn't match!";
        header("Location: register.php");
        die();
        
    }else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
         $_SESSION["error"]= "Please Enter Valid Email Address!";
         header("Location: register.php");
        die();

    }else {
        try {
            
            require_once "DB-connection.php";
            //Check Query
           $checkQuery = "SELECT COUNT(*) FROM users WHERE email = :email";
           $checkStmt = $pdo->prepare($checkQuery);
           $checkStmt->bindParam(":email",$email);
           $checkStmt->execute();

            $email_count = $checkStmt->fetchColumn();

            
             if($email_count > 0){
                  $_SESSION["error"] = "Email Already Exists!";
                  header("Location: register.php");
                  die();
             }
           //Check Query

            $query = "INSERT INTO users (username,email,pwd) VALUES(:username, :email, :pwd)";
            $stmt = $pdo->prepare($query);


            //Hashing the Password
            $options = [
                "cost" => 12
            ];
            $hashedPassword =  password_hash($password,PASSWORD_BCRYPT,$options);
            //Hashing the Password

            $stmt->bindParam(":username",$username);
            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":pwd",$hashedPassword);

            $stmt->execute();

            $pdo = null;
            $stmt = null;
            header("Location: index.php");
            die();

        } catch (PDOException $e) {
            echo "Query Failed!". $e->getMessage();
        }
       

    }
    

}else {
    header("Location: register.php");
    die();
}