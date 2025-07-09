<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <link rel="icon" href="https://img.icons8.com/ios-filled/50/ffffff/administrator-male.png" type="image/png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6366F1',
            secondary: '#818cf8',
            red: '#f43f5e',
            red2: '#fb7185',
          },
        }
      }
    }
  </script>
  <style>
    @keyframes bounceShield {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-4px);
      }
    }

    .animate-shield {
      animation: bounceShield 1.2s ease-in-out infinite;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow py-6 px-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold text-primary flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="w-6 h-6 text-primary animate-shield">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
          <path d="M9 12l2 2 4-4" />
        </svg>
        Admin Dashboard
      </h1>
      <a href="logout.php" class="flex items-center gap-2 bg-red text-white px-4 py-2 rounded hover:bg-red2 hover:text-black transition font-medium">
        <i class="fas fa-sign-out-alt transform transition-transform duration-300 hover:-translate-y-1"></i> Logout
      </a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
      <h2 class="text-xl font-semibold mb-6">Welcome, <span class="text-primary">Admin</span>!</h2>
      <ul class="space-y-4">
        <li>
          <a href="edit_about.php" class="group block p-4 bg-gray-100 rounded hover:bg-primary hover:text-white transition flex items-center gap-2">
            <i class="fas fa-user transform transition-transform duration-300 group-hover:-translate-y-1"></i>
            <span class="transform transition-transform duration-300 group-hover:scale-105">Edit About</span>
          </a>
        </li>
        <li>
          <a href="manage_skills.php" class="group block p-4 bg-gray-100 rounded hover:bg-primary hover:text-white transition flex items-center gap-2">
            <i class="fas fa-code transform transition-transform duration-300 group-hover:-translate-y-1"></i>
            <span class="transform transition-transform duration-300 group-hover:scale-105">Manage Skills</span>
          </a>
        </li>
        <li>
          <a href="manage_projects.php" class="group block p-4 bg-gray-100 rounded hover:bg-primary hover:text-white transition flex items-center gap-2">
            <i class="fas fa-laptop-code transform transition-transform duration-300 group-hover:-translate-y-1"></i>
            <span class="transform transition-transform duration-300 group-hover:scale-105">Manage Projects</span>
          </a>
        </li>
        <li>
          <a href="manage_certificates.php" class="group block p-4 bg-gray-100 rounded hover:bg-primary hover:text-white transition flex items-center gap-2">
            <i class="fa-regular fa-file transform transition-transform duration-300 group-hover:-translate-y-1"></i>
            <span class="transform transition-transform duration-300 group-hover:scale-105">Manage Certificates</span>
          </a>
        </li>
        <li>
          <a href="edit_contact.php" class="group block p-4 bg-gray-100 rounded hover:bg-primary hover:text-white transition flex items-center gap-2">
            <i class="fas fa-phone transform transition-transform duration-300 group-hover:-translate-y-1"></i>
            <span class="transform transition-transform duration-300 group-hover:scale-105">Edit Contact Info</span>
          </a>
        </li>
      </ul>
      <a href="../index.php" class="group text-primary p-4 bg-gray-100 rounded hover:text-black transition flex items-center gap-2 mt-4 font-bold">
        Go to Website
        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </a>

    </div>
  </main>
</body>

</html>