<?php
session_start();
include '../includes/db.php';
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST['add'])) {
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $link = $_POST['link'];

  // Handle image upload
  $imageName = 'project-default.jpg';
  if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = 'project_' . time() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $imageName);
  }

  $stmt = $conn->prepare("INSERT INTO projects (title, description, link, image) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $title, $desc, $link, $imageName);
  $stmt->execute();
}

if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  $result = $conn->query("SELECT image FROM projects WHERE id=$id");
  if ($result && $row = $result->fetch_assoc()) {
    $img = $row['image'];
    if ($img && $img !== 'project-default.jpg' && file_exists("../assets/images/$img")) {
      unlink("../assets/images/$img");
    }
    $conn->query("DELETE FROM projects WHERE id=$id");
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Projects</title>
  <link rel="icon" href="https://img.icons8.com/ios-filled/50/ffffff/artificial-intelligence.png" type="image/png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6366F1',
            secondary: '#818cf8',
            red: '#f43f5e',
            red2: '#fb7185'
          }
        }
      }
    }
  </script>
  <style>
    @keyframes bounceFAFA {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-5px);
      }
    }

    .animate-infinite-bounce {
      animation: bounceFAFA 1s infinite ease-in-out;
    }

    @keyframes rotatePlus {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(180deg);
      }
    }

    .group:hover .group-hover\:animate-plus {
      animation: rotatePlus 0.3s ease-in-out;
    }

    @keyframes shake {

      0%,
      100% {
        transform: rotate(0);
      }

      25% {
        transform: rotate(-10deg);
      }

      75% {
        transform: rotate(10deg);
      }
    }

    .group:hover .group-hover\:animate-shake {
      animation: shake 0.4s ease-in-out;
    }
  </style>

</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow p-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold text-primary flex items-center gap-2">
        <i class="fas fa-laptop-code animate-infinite-bounce"></i>
        Manage Projects
      </h1>
    </div>

  </header>

  <!-- Main Content -->
  <main class="py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow space-y-6">
      <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label class="block font-medium mb-1">Project Title</label>
          <input type="text" name="title" required class="w-full border p-2 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        <div>
          <label class="block font-medium mb-1">Description</label>
          <textarea name="description" required class="w-full border p-2 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary" rows="4"></textarea>
        </div>

        <div>
          <label class="block font-medium mb-1">Project Link</label>
          <input type="url" autocomplete="off" name="link" required class="w-full border p-2 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Project Image
          </label>
          <input
            type="file"
            name="image"
            accept="image/*"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-600 transition">
        </div>
        <button type="submit" name="add" class="group inline-flex items-center gap-2 bg-primary text-white px-6 py-2 rounded hover:bg-secondary transition">

          <svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="w-5 h-5 text-white group-hover:animate-plus">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
          </svg>Add Project</button>
      </form>

      <!-- Project List -->
      <div>
        <h2 class="text-lg font-semibold mb-3">Your Projects</h2>
        <ul class="space-y-4">
          <?php
          $projects = $conn->query("SELECT * FROM projects");
          while ($row = $projects->fetch_assoc()) {
            $img = htmlspecialchars($row['image']);
            echo "<li class='bg-gray-50 p-4 rounded shadow-sm flex flex-col sm:flex-row gap-4 sm:items-center'>";
            echo "<img src='../assets/images/$img' alt='project' class='w-24 h-24 object-cover rounded border'>";
            echo "<div class='flex-1'>";
            echo "<h3 class='font-semibold text-primary'>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p class='text-gray-600 text-sm'>" . htmlspecialchars($row['description']) . "</p>";
            echo "<a href='" . htmlspecialchars($row['link']) . "' target='_blank'
        class='text-primary px-6 py-2 rounded hover:text-secondary transition inline-flex items-center gap-1 group'>
        Visit
        <svg xmlns='http://www.w3.org/2000/svg'
             class='w-4 h-4 transition-transform duration-300 group-hover:translate-x-1'
             fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
          <path stroke-linecap='round' stroke-linejoin='round' d='M14 3h7v7m0-7L10 14M5 5v14h14' />
        </svg>
      </a>";
            echo "</div>";
            echo "
<a href='?delete={$row['id']}'
   onclick='return confirm(\"Delete this project?\")'
   class='group inline-flex items-center gap-2 text-white bg-red px-6 py-2 rounded hover:bg-red2 transition'>

  <svg xmlns='http://www.w3.org/2000/svg'
       fill='none'
       viewBox='0 0 24 24'
       stroke='currentColor'
       stroke-width='2'
       stroke-linecap='round'
       stroke-linejoin='round'
       class='w-5 h-5 text-white group-hover:animate-shake'>
    <polyline points='3 6 5 6 21 6' />
    <path d='M19 6l-1 14H6L5 6' />
    <path d='M10 11v6' />
    <path d='M14 11v6' />
    <path d='M9 6V4h6v2' />
  </svg>

  Delete
</a>";
            echo "</li>";
          }
          ?>
        </ul>
      </div>
      <div>
        <a href="dashboard.php" class="group inline-flex items-center gap-2 text-indigo-600 text-sm no-underline hover:text-red">
          <svg class="w-5 h-5 transition-all duration-300 group-hover:-translate-x-1 group-hover:opacity-100 opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M11 17L6 12L11 7" />
            <path d="M18 17L13 12L18 7" />
          </svg>
          Back to Dashboard
        </a>
      </div>
    </div>
  </main>

</body>

</html>