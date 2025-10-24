<?php
session_start();
if(!isset($_SESSION["user_id"])){
  header("Location: index.php");
  die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Task Management Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    primary: "#4F46E5",
                    "background-light": "#F9FAFB",
                    "background-dark": "#111827",
                    "card-light": "#FFFFFF",
                    "card-dark": "#1F2937",
                    "text-light": "#1F2937",
                    "text-dark": "#F9FAFB",
                    "subtext-light": "#6B7280",
                    "subtext-dark": "#9CA3AF",
                    "border-light": "#E5E7EB",
                    "border-dark": "#374151",
                },
                fontFamily: {
                    display: ["Poppins", "sans-serif"],
                },
                borderRadius: {
                    DEFAULT: "0.5rem",
                },
            },
        },
    };
    </script>
    <style>
    body {
        font-family: "Poppins", sans-serif;
    }

    .gradient-button {
        background-image: linear-gradient(to right, #60a5fa, #3b82f6);
    }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display">
    <div class="min-h-screen flex flex-col p-4 sm:p-6 lg:p-8">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-text-light dark:text-text-dark">
                    Welcome, <?php echo htmlspecialchars($_SESSION["username"]) ?>
                </h1>
            </div>
            <button
                class="flex items-center space-x-2 text-subtext-light dark:text-subtext-dark hover:text-primary dark:hover:text-primary transition-colors">
                <span class="material-icons">logout</span>
                <a href="logout.php"><span class="font-medium">Logout</span></a>
            </button>
        </header>
        <main class="flex-grow">
            <div class="flex justify-end mb-6">
                <button
                    class="gradient-button text-white font-medium py-2 px-4 rounded-lg flex items-center space-x-2 shadow-lg hover:bg-opacity-90 transition-all transform hover:scale-105">
                    <span class="material-icons">add</span>
                    <a href="add-task-form.php"><span>Add Task</span></a>
                </button>
            </div>
            <div class="bg-card-light dark:bg-card-dark rounded-lg shadow-md overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b border-border-light dark:border-border-dark">
                        <?php
               try {
            
            require_once "DB-connection.php";
           

          $query = "SELECT 
              task_id ,
              title,
              description,
              DATE_FORMAT(created_at, '%D %M %Y') AS 'created_at'
             FROM tasks
             WHERE user_id = :user_id";
            $stmt = $pdo->prepare($query);


            

            $stmt->bindParam(":user_id",$_SESSION["user_id"]);
           

            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $pdo = null;
            $stmt = null;
           

        } catch (PDOException $e) {
            echo "Query Failed!". $e->getMessage();
        }
       
              
              ?>

                    </thead>

                    <tr>
                        <th
                            class="p-4 text-sm font-semibold text-subtext-light dark:text-subtext-dark uppercase tracking-wider">
                            Task ID
                        </th>
                        <th
                            class="p-4 text-sm font-semibold text-subtext-light dark:text-subtext-dark uppercase tracking-wider">
                            Title
                        </th>
                        <th
                            class="p-4 text-sm font-semibold text-subtext-light dark:text-subtext-dark uppercase tracking-wider">
                            Description
                        </th>
                        <th
                            class="p-4 text-sm font-semibold text-subtext-light dark:text-subtext-dark uppercase tracking-wider">
                            Created at
                        </th>
                        <th
                            class="p-4 text-sm font-semibold text-subtext-light dark:text-subtext-dark uppercase tracking-wider text-center">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light dark:divide-border-dark">

                        <?php
              if(empty($tasks)){
                 
               echo"<h1>No Tasks was added!</h1>";
              
                
              }else{
               foreach($tasks as $task){

            echo  ' <tr
                class="hover:bg-background-light dark:hover:bg-background-dark transition-colors"
              >
                <td class="p-4 text-text-light dark:text-text-dark">'.htmlspecialchars($task["task_id"]).'</td>
                <td class="p-4 text-text-light dark:text-text-dark font-medium">
                '.htmlspecialchars($task["title"]).'
                </td>
                <td
                  class="p-4 text-subtext-light dark:text-subtext-dark max-w-xs truncate"
                >
                  '.htmlspecialchars($task["description"]).'
                </td>
                <td class="p-4 text-text-light dark:text-text-dark">
                  '.htmlspecialchars($task["created_at"]).'
                </td>
                <td class="p-4">
                  <div class="flex justify-center items-center space-x-4">
                    <button
                      class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-400 transition-colors"
                    >
                    <a href="update-task-form.php?task_id='.htmlspecialchars($task["task_id"]).'"><span class="material-icons">edit</span></a>
                      
                    </button>
                    <button
                      class="text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors"
                    >
                    <a href="delete-task.php?task_id='.htmlspecialchars($task["task_id"]).'"><span class="material-icons">delete</span></a>
                     
                    </button>
                  </div>
                </td>
              </tr>
              <tr
                class="hover:bg-background-light dark:hover:bg-background-dark transition-colors"
              >';
           

               }

              
              }
              
              
              ?>

                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>