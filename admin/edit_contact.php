<?php
session_start();
include '../includes/db.php';
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST['save'])) {
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $location = $_POST['location'];

  $stmt = $conn->prepare("UPDATE contact SET email=?, phone=?, location=? WHERE id=1");
  $stmt->bind_param("sss", $email, $phone, $location);
  $stmt->execute();
  $msg = "✅ Contact information updated.";
}

$data = $conn->query("SELECT * FROM contact WHERE id=1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Contact Info</title>
  <link rel="icon" href="https://img.icons8.com/ios-filled/50/ffffff/phone.png" type="image/png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    @keyframes bounceSave {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-4px);
      }
    }

    .group:hover .group-hover\:animate-bounce {
      animation: bounceSave 0.3s ease-in-out;
    }

    @keyframes infiniteBounce {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-5px);
      }
    }

    .animate-infinite-bounce {
      animation: infiniteBounce 1s infinite ease-in-out;
    }
  </style>

</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow p-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold text-primary flex items-center gap-2">
        <i class="fas fa-phone animate-infinite-bounce"></i>
        Edit Contact Info
      </h1>
    </div>
  </header>

  <!-- Main Section -->
  <main class="py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow space-y-6">

      <?php if (isset($msg)): ?>
        <div class="bg-green-100 text-green-800 border border-green-300 p-4 rounded">
          <?php echo $msg; ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form method="POST" class="space-y-4">
        <div>
          <label class="block font-medium mb-1">Email</label>
          <input type="email" autocomplete="off" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required class="w-full border p-2 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        <div>
          <label class="block font-medium mb-1">Phone</label>
          <input type="text" autocomplete="off" name="phone" value="<?php echo htmlspecialchars($data['phone']); ?>" required class="w-full border p-2 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        <div>
          <label class="block font-medium mb-1">Location</label>
          <input type="text" autocomplete="off" name="location" value="<?php echo htmlspecialchars($data['location']); ?>" required class="w-full border p-2 rounded bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
        <button type="submit" name="save"
          class="group inline-flex items-center gap-2 bg-primary text-white px-6 py-2 rounded hover:bg-secondary transition">

          <svg xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="w-5 h-5 text-white group-hover:animate-bounce">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
            <polyline points="17 21 17 13 7 13 7 21" />
            <polyline points="7 3 7 8 15 8" />
          </svg>

          Save Changes
        </button>

      </form>
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