<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

$msg = "";

if (isset($_POST['upload']) && isset($_FILES['file'])) {
  $title = $_POST['title'];
  $file = $_FILES['file']['name'];
  $tmp = $_FILES['file']['tmp_name'];
  $target = "../uploads/" . basename($file);

  if (move_uploaded_file($tmp, $target)) {
    $stmt = $conn->prepare("INSERT INTO certificates (title, file) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $file);
    $stmt->execute();
    $msg = "✅ Certificate uploaded.";
  } else {
    $msg = "❌ Upload failed.";
  }
}

if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $result = $conn->query("SELECT file FROM certificates WHERE id=$id");

  if ($result && $row = $result->fetch_assoc()) {
    $file = $row['file'];
    $filePath = "../uploads/" . $file;

    if (!empty($file) && file_exists($filePath) && is_file($filePath)) {
      unlink($filePath);
    }

    $conn->query("DELETE FROM certificates WHERE id=$id");
    $msg = "🗑️ Certificate deleted successfully.";
  } else {
    $msg = "⚠️ Certificate not found.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Certificates</title>
  <link rel="icon" href="https://img.icons8.com/ios-filled/50/ffffff/certificate.png" type="image/png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://kit.fontawesome.com/a2e0e6adfe.js" crossorigin="anonymous"></script>
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
    @keyframes bounceUpload {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-4px);
      }
    }

    .group:hover .group-hover\:animate-bounce {
      animation: bounceUpload 0.3s ease-in-out;
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
  </style>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow p-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold text-primary flex items-center gap-2">
        <i class="fa-regular fa-file animate-infinite-bounce"></i>
        Manage Certificates
      </h1>
    </div>
  </header>

  <!-- Main Section -->
  <main class="py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow space-y-6">

      <?php if (!empty($msg)): ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded">
          <?php echo htmlspecialchars($msg); ?>
        </div>
      <?php endif; ?>

      <!-- Upload Form -->
      <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
          <label class="block mb-1 font-medium">Certificate Title</label>
          <input type="text" name="title" required class="w-full border p-2 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            PDF File
          </label>
          <input
            type="file"
            name="file"
            accept="application/pdf, image/png, image/jpeg"
            required
            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-600 transition">
        </div>


        <button type="submit" name="upload"
          class="group inline-flex items-center gap-2 bg-primary text-white px-6 py-2 rounded hover:bg-secondary transition">

          <svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="w-5 h-5 text-white group-hover:animate-bounce">
            <path d="M16 16v-4a4 4 0 0 0-8 0v4" />
            <polyline points="12 12 12 2 8 6" />
            <line x1="12" y1="2" x2="16" y2="6" />
            <path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2" />
          </svg>

          Upload Certificate
        </button>

      </form>

      <!-- Certificate List -->
      <div class="mt-8">
        <h2 class="text-lg font-semibold mb-4">Uploaded Certificates</h2>
        <ul class="space-y-3">
          <?php
          $certs = $conn->query("SELECT * FROM certificates");
          while ($row = $certs->fetch_assoc()) {
            echo "<li class='flex justify-between items-center bg-gray-50 px-4 py-2 rounded shadow-sm'>";
            echo "<a href='../uploads/" . htmlspecialchars($row['file']) . "' target='_blank' class='text-primary'>" . htmlspecialchars($row['title']) . "</a>";
            echo "
<a href='?delete=" . $row['id'] . "'
   onclick='return confirm(\"Delete this certificate?\")'
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