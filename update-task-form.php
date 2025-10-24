<?php
session_start();
if(!isset($_SESSION["user_id"])){
  header("Location: index.php");
  die();
}

      if(isset($_GET["task_id"])){

        $id = $_GET["task_id"];
      }

 try {
            
            require_once "DB-connection.php";
            

            $query = "SELECT * FROM tasks WHERE task_id = :task_id";
            $stmt = $pdo->prepare($query);


         

           
            $stmt->bindParam(":task_id",$id);

            $stmt->execute();
           $task = $stmt->fetch(PDO::FETCH_ASSOC);
            

           if(!$task){

            echo "Nothing is available";
           }
           
           
            $pdo = null;
            $stmt = null;
            
            

        } catch (PDOException $e) {
            echo "Query Failed!". $e->getMessage();
        }
       

    
    



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    primary: "#3B82F6",
                    "background-light": "#F9FAFB",
                    "background-dark": "#111827",
                    "card-light": "#FFFFFF",
                    "card-dark": "#1F2937",
                    "text-light": "#1F2937",
                    "text-dark": "#F9FAFB",
                    "muted-light": "#6B7280",
                    "muted-dark": "#9CA3AF",
                },
                fontFamily: {
                    display: ["Inter", "sans-serif"],
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
        font-family: "Inter", sans-serif;
    }

    .gradient-button {
        background-image: linear-gradient(to right, #60a5fa, #3b82f6);
    }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark font-display">
    <div class="flex flex-col min-h-screen">
        <header class="bg-card-light dark:bg-card-dark shadow-sm">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <span class="font-semibold text-lg text-text-light dark:text-text-dark">User:
                            <?php echo htmlspecialchars($_SESSION["username"]) ?></span>
                    </div>
                    <button
                        class="flex items-center text-sm font-medium text-muted-light dark:text-muted-dark hover:text-primary dark:hover:text-primary transition-colors duration-200">
                        <span class="material-icons mr-1 text-base">logout</span>
                        <a href="logout.php"> Logout </a>
                    </button>
                </div>
            </div>
        </header>
        <main class="flex-grow">
            <div class="max-w-xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="bg-card-light dark:bg-card-dark rounded-lg shadow p-8">
                    <h1 class="text-2xl font-bold text-center mb-6 text-text-light dark:text-text-dark">
                        Update Task
                    </h1>

                    <?php if(isset($_SESSION["error"])){ ?>

                    <?php echo "<p class ='bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-3 rounded'>" . $_SESSION["error"]  . "</p>" ?>
                    <?php unset($_SESSION["error"])  ?>

                    <?php } ?>

                    <form action="update-task.php" class="space-y-6" method="POST">
                        <!-- hidden task id input to submit with form data for updating -->
                        <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['task_id'])?>">
                        <!-- hidden task id input to submit with form data for updating -->
                        <div>
                            <label class="block text-sm font-medium text-muted-light dark:text-muted-dark"
                                for="title">Title</label>
                            <div class="mt-1">
                                <input
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark"
                                    id="title" name="title" placeholder="Enter task title" type="text"
                                    value="<?= htmlspecialchars($task['title']);?>" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-muted-light dark:text-muted-dark"
                                for="description">Description</label>
                            <div class="mt-1">
                                <textarea
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-primary focus:ring-primary sm:text-sm bg-background-light dark:bg-background-dark text-text-light dark:text-text-dark"
                                    id="description" name="description" placeholder="Enter task description"
                                    rows="4"><?php echo htmlspecialchars($task["description"])?></textarea>
                            </div>
                        </div>
                        <div>
                            <button
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white gradient-button focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200"
                                type="submit">
                                <span class="material-icons mr-2">update</span>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>