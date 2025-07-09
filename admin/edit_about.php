<?php
session_start();
include '../includes/db.php';
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

if (isset($_POST['save'])) {
  $content = $_POST['content'];
  $stmt = $conn->prepare("UPDATE about SET content=? WHERE id=1");
  $stmt->bind_param("s", $content);
  $stmt->execute();
  $message = "About updated!";
}

$about = $conn->query("SELECT content FROM about WHERE id=1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit About</title>
  <link rel="icon" href="https://img.icons8.com/ios-filled/50/ffffff/user.png" type="image/png" />
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
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow p-6">
    <div class="max-w-4xl mx-auto">
      <style>
        @keyframes bounceUser {

          0%,
          100% {
            transform: translateY(0);
          }

          50% {
            transform: translateY(-4px);
          }
        }

        .animate-user {
          animation: bounceUser 1.2s ease-in-out infinite;
        }
      </style>

      <h1 class="text-2xl font-bold text-primary flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="w-6 h-6 animate-user">
          <circle cx="12" cy="8" r="4" />
          <path d="M4 20v-1c0-2.5 4-4 8-4s8 1.5 8 4v1" />
        </svg>
        User Profile
      </h1>

    </div>
  </header>

  <!-- Content -->
  <main class="py-10 px-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
      <?php if (isset($message)): ?>
        <p class="text-green-600 font-medium mb-4"><?php echo $message; ?></p>
      <?php endif; ?>

      <form method="POST" class="space-y-4">
        <label class="block text-gray-700 font-medium">About Me Content:</label>
        <textarea name="content" rows="10" class="w-full p-4 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-gray-50" required><?php echo htmlspecialchars($about['content']); ?></textarea> <button type='submit' name='save'
          class='group inline-flex items-center gap-2 bg-primary text-white px-6 py-2 rounded hover:bg-secondary transition'>
          <svg xmlns='http://www.w3.org/2000/svg'
            fill='none'
            viewBox='0 0 24 24'
            stroke='currentColor'
            stroke-width='2'
            stroke-linecap='round'
            stroke-linejoin='round'
            class='w-5 h-5 text-white group-hover:animate-bounce'>
            <path d='M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z' />
            <polyline points='17 21 17 13 7 13 7 21' />
            <polyline points='7 3 7 8 15 8' />
          </svg>
          <span class='font-medium'>Save</span>
        </button>
      </form>

      <div class="mt-6">
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