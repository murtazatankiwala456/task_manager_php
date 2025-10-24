<?php
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $title = $_POST["title"];
    $description = $_POST["description"];
   

    if(empty($title)|| empty($description)){
       $_SESSION["error"]  = "Please fill all the fields!";
        header("Location: add-task-form.php");
        die();

   

    }else {
        try {
            
            require_once "DB-connection.php";
            

            $query = "INSERT INTO tasks (user_id,title,description) VALUES(:user_id, :title, :description)";
            $stmt = $pdo->prepare($query);


         

            $stmt->bindParam(":user_id",$_SESSION["user_id"]);
            $stmt->bindParam(":title",$title);
            $stmt->bindParam(":description",$description);

            $stmt->execute();

            $pdo = null;
            $stmt = null;
            header("Location: tasks.php");
            die();

        } catch (PDOException $e) {
            echo "Query Failed!". $e->getMessage();
        }
       

    }
    

}else {
    header("Location: register.php");
    die();
}