<?php
session_start();

if(isset($_GET["task_id"])){

  $id = $_GET["task_id"];
   try {
            
            require_once "DB-connection.php";
            

            $query = "DELETE FROM tasks WHERE task_id = :task_id";
            $stmt = $pdo->prepare($query);


         

            $stmt->bindParam(":task_id",$id);
           

            $stmt->execute();

            $pdo = null;
            $stmt = null;
            
            header("Location: tasks.php");
            die();

        } catch (PDOException $e) {
            echo "Query Failed!". $e->getMessage();
        }
       

}
    

 
       

    
    