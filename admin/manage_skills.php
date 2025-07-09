<?php
session_start();
include '../includes/db.php';
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

// Add skill
if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $icon = $_POST['icon'];
  $stmt = $conn->prepare("INSERT INTO skills (name, icon) VALUES (?, ?)");
  $stmt->bind_param("ss", $name, $icon);
  $stmt->execute();
}

// Edit skill
if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $icon = $_POST['icon'];
  $stmt = $conn->prepare("UPDATE skills SET name=?, icon=? WHERE id=?");
  $stmt->bind_param("ssi", $name, $icon, $id);
  $stmt->execute();
}

// Delete skill
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM skills WHERE id=$id");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Skills</title>
  <link rel="icon" href="https://img.icons8.com/ios-filled/50/ffffff/source-code.png" type="image/png" />
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
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

    @keyframes bounceCode {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-4px);
      }
    }

    .animate-code {
      animation: bounceCode 1.2s ease-in-out infinite;
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

    @keyframes rotateUpdate {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .group:hover .group-hover\:animate-rotate {
      animation: rotateUpdate 0.5s linear;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow p-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold text-primary flex items-center gap-2">
        <div class="w-9 h-9 flex items-center justify-center animate-code">
          <span class="text-primary text-lg font-mono font-bold">&lt;/&gt;</span>
        </div>
        Manage Skills
      </h1>
    </div>
  </header>

  <!-- Content -->
  <main class="py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow space-y-8">

      <!-- Add Skill Form -->
      <form method="POST" class="grid md:grid-cols-2 gap-4">
        <input type="text" autocomplete="off" name="name" placeholder="Skill name" required class="px-4 py-2 border rounded-md bg-gray-50 focus:ring-2 focus:ring-primary">
        <input type="text" autocomplete="off" name="icon" placeholder="FA icon (e.g., fa-html5)" required class="px-4 py-2 border rounded-md bg-gray-50 focus:ring-2 focus:ring-primary">
        <div class="md:col-span-2">
          <button type="submit" name="add"
            class="group inline-flex items-center gap-2 bg-primary text-white px-6 py-2 rounded hover:bg-secondary transition">

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
            </svg>

            Add Skill
          </button>
        </div>
      </form>

      <ul class="space-y-4">
        <?php
        $skills = $conn->query("SELECT * FROM skills");
        while ($row = $skills->fetch_assoc()) {
          echo "<li class='bg-gray-50 p-4 rounded-md shadow-sm'>";
          echo "<form method='POST' class='grid md:grid-cols-3 gap-4 items-center'>";
          echo "<input type='hidden' name='id' value='{$row['id']}'>";
          echo "<input type='text' name='name' value='" . htmlspecialchars($row['name']) . "' class='px-3 py-2 border rounded bg-white'>";
          echo "<input type='text' name='icon' value='" . htmlspecialchars($row['icon']) . "' class='px-3 py-2 border rounded bg-white'>";
          echo "<div class='flex gap-3 items-center'>";
          echo "
<button type='submit' name='edit'
        class='group inline-flex items-center gap-2 bg-primary text-white px-6 py-2 rounded hover:bg-secondary transition'>

  <svg xmlns='http://www.w3.org/2000/svg'
       fill='none'
       viewBox='0 0 24 24'
       stroke='currentColor'
       stroke-width='2'
       stroke-linecap='round'
       stroke-linejoin='round'
       class='w-5 h-5 text-white group-hover:animate-rotate'>
    <polyline points='23 4 23 10 17 10' />
    <path d='M20.49 15A9 9 0 1 1 12 3v1' />
  </svg>

  Update
</button>";

          echo "
<a href='?delete={$row['id']}'
   onclick='return confirm(\"Delete this skill?\")'
   class='group inline-flex items-center gap-2 bg-red text-white px-4 py-2 rounded hover:bg-red2 transition'>
  
  <svg xmlns='http://www.w3.org/2000/svg'
       fill='none'
       viewBox='0 0 24 24'
       stroke='currentColor'
       stroke-width='2'
       stroke-linecap='round'
       stroke-linejoin='round'
       class='w-4 h-4 group-hover:animate-shake'>
    <polyline points='3 6 5 6 21 6' />
    <path d='M19 6l-1 14H6L5 6' />
    <path d='M10 11v6' />
    <path d='M14 11v6' />
    <path d='M9 6V4h6v2' />
  </svg>
  Delete
</a>";
          echo "</div>";
          echo "</form>";
          echo "</li>";
        }
        ?>
      </ul>

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