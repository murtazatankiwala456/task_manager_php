<?php
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $id = $_POST["task_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
   

    if(empty($title)|| empty($description)){
       $_SESSION["error"]  = "Please fill all the fields!";
        header("Location: update-task-form.php?task_id=$id");
        die();

   

    }else {
        try {
            
            require_once "DB-connection.php";
            

            $query = "UPDATE tasks SET title = :title, description = :description WHERE task_id = :task_id";
            $stmt = $pdo->prepare($query);


         

            $stmt->bindParam(":task_id",$id);
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