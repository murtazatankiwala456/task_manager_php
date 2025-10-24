<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Register Page</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&amp;display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
      rel="stylesheet"
    />
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#60A5FA",
              "background-light": "#F0F4F8",
              "background-dark": "#1A202C",
              "card-light": "#FFFFFF",
              "card-dark": "#2D3748",
              "text-light": "#1A202C",
              "text-dark": "#E2E8F0",
              "subtext-light": "#4A5568",
              "subtext-dark": "#A0AEC0",
              "input-light": "#F7FAFC",
              "input-dark": "#4A5568",
              "border-light": "#E2E8F0",
              "border-dark": "#4A5568",
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
      .gradient-bg {
        background-image: linear-gradient(to right, #dbeafe, #e0e7ff);
      }
      .dark .dark-gradient-bg {
        background-image: linear-gradient(to right, #1e293b, #2d3748);
      }
      .gradient-button {
        background-image: linear-gradient(to right, #60a5fa, #3b82f6);
      }
    </style>
  </head>
  <body
    class="bg-background-light dark:bg-background-dark font-display gradient-bg dark:dark-gradient-bg"
  >
    <div class="flex items-center justify-center min-h-screen">
      <div
        class="bg-card-light dark:bg-card-dark p-8 md:p-12 rounded-lg shadow-2xl w-full max-w-md mx-4"
      >
        <h1
          class="text-3xl font-bold text-center mb-6 text-text-light dark:text-text-dark"
        >
          Register
        </h1>
        <?php if(isset($_SESSION["error"])){ ?>

        <?php echo "<p class ='bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-3 rounded'>" . $_SESSION["error"]  . "</p>" ?>
        <?php unset($_SESSION["error"])  ?>

         <?php } ?>

        <form action="create-user.php" method="POST">
          <div class="mb-4">
           
            <input
              class="w-full px-4 py-3 bg-input-light dark:bg-input-dark border border-border-light dark:border-border-dark rounded-md focus:outline-none focus:ring-2 focus:ring-primary text-text-light dark:text-text-dark placeholder-subtext-light dark:placeholder-subtext-dark"
              id="username"
              name="username"
              placeholder="User Name"
              type="text"
            />
          </div>

          <div class="mb-4">
           
            <input
              class="w-full px-4 py-3 bg-input-light dark:bg-input-dark border border-border-light dark:border-border-dark rounded-md focus:outline-none focus:ring-2 focus:ring-primary text-text-light dark:text-text-dark placeholder-subtext-light dark:placeholder-subtext-dark"
              id="email"
              name="email"
              placeholder="Email"
              type="text"
            />
          </div>
          <div class="mb-6 relative">
           
            <input
              class="w-full px-4 py-3 bg-input-light dark:bg-input-dark border border-border-light dark:border-border-dark rounded-md focus:outline-none focus:ring-2 focus:ring-primary text-text-light dark:text-text-dark placeholder-subtext-light dark:placeholder-subtext-dark"
              id="password"
              name="password"
              placeholder="Password"
              type="password"
            />
            <button
              class="absolute inset-y-0 right-0 px-3 flex items-center text-subtext-light dark:text-subtext-dark"
              id="togglePassword"
              type="button"
            >
              <span class="material-icons-outlined">visibility_off</span>
            </button>
          </div>
          <div class="mb-6 relative">
           
            
            <input
              class="w-full px-4 py-3 bg-input-light dark:bg-input-dark border border-border-light dark:border-border-dark rounded-md focus:outline-none focus:ring-2 focus:ring-primary text-text-light dark:text-text-dark placeholder-subtext-light dark:placeholder-subtext-dark"
              id="confirm-password"
              name="confirm-password"
              placeholder="Confirm Password"
              type="confirm-password"
            />
          </div>
          <button
            class="w-full gradient-button text-white font-bold py-3 px-4 rounded-md hover:opacity-90 transition-opacity duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 dark:focus:ring-offset-card-dark"
            type="submit"
          >
            Register
          </button>
        </form>
        <p
          class="text-center mt-6 text-sm text-subtext-light dark:text-subtext-dark"
        >
          Already have an account?
          <a class="font-medium text-primary hover:underline" href="index.php">Login</a>
        </p>
      </div>
    </div>
    <script>
      const togglePassword = document.querySelector("#togglePassword");
      const password = document.querySelector("#password");
      const eyeIcon = togglePassword.querySelector("span");
      togglePassword.addEventListener("click", function (e) {
        // toggle the type attribute
        const type =
          password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        // toggle the eye slash icon
        eyeIcon.textContent =
          type === "password" ? "visibility_off" : "visibility";
      });
    </script>
  </body>
</html>
