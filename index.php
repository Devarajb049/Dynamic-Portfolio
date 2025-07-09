<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bhojanapu Deva Raj Portfolio</title>
  <link rel="icon" href="https://img.icons8.com/ios-filled/50/ffffff/user.png" type="image/png" />
  <meta name="description" content="Bhojanapu Deva Raj - Fullstack Developer Portfolio built with PHP, MySQL & Tailwind.">
  <meta name="author" content="Bhojanapu Deva Raj">
  <meta name="keywords" content="portfolio, web developer, PHP, Tailwind CSS, projects, Deva Raj">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#6366F1',
            secondary: '#4F46E5'
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    /*Eye Icon Animation*/
    @keyframes viewPulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.15);
      }
    }

    .group:hover .group-hover\:animate-view {
      animation: viewPulse 0.3s ease-in-out;
    }

    /*Header Bg Animate*/
    @keyframes animatedBackground {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    .animated-bg {
      background: linear-gradient(-45deg, #4f46e5, #9333ea, #8b5cf6, #6366f1);
      background-size: 400% 400%;
      animation: animatedBackground 10s ease infinite;
    }
  </style>
</head>

<nav class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
    <div class="text-2xl font-bold text-primary">Bhojanapu Deva Raj</div>

    <!-- Hamburger -->
    <button id="menu-btn" class="md:hidden focus:outline-none">
      <i class="fas fa-bars text-2xl text-gray-800"></i>
    </button>

    <!-- Desktop Menu -->
    <ul id="menu" class="hidden md:flex gap-8 text-sm font-medium text-gray-700">
      <li><a href="#about" class="hover:text-primary transition">About</a></li>
      <li><a href="#skills" class="hover:text-primary transition">Skills</a></li>
      <li><a href="#projects" class="hover:text-primary transition">Projects</a></li>
      <li><a href="#certificates" class="hover:text-primary transition">Certificates</a></li>
      <li><a href="#contact" class="hover:text-primary transition">Contact</a></li>
    </ul>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 transition">
    <ul class="flex flex-col gap-4 text-sm text-gray-700">
      <li><a href="#about" class="block py-1 hover:text-primary transition">About</a></li>
      <li><a href="#skills" class="block py-1 hover:text-primary transition">Skills</a></li>
      <li><a href="#projects" class="block py-1 hover:text-primary transition">Projects</a></li>
      <li><a href="#certificates" class="block py-1 hover:text-primary transition">Certificates</a></li>
      <li><a href="#contact" class="block py-1 hover:text-primary transition">Contact</a></li>
    </ul>
  </div>
</nav>
<!--Header-->
<header class="animated-bg text-white text-center pt-32 pb-24 relative shadow-lg">
  <div class="flex flex-col items-center">
    <div class="w-24 h-24 bg-white text-indigo-700 flex items-center justify-center rounded-full shadow-md mb-4 animate-bounce">
      <i class="fas fa-user text-5xl"></i>
    </div>
    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight animate-bounce">Bhojanapu Deva Raj</h1>
    <p class="mt-2 text-lg md:text-xl text-indigo-100 font-bold animate-bounce">Student</p>
  </div>
</header>
<!--About-->
<section id="about" class="py-20 px-4 bg-gradient-to-b from-indigo-50 to-white">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-3xl md:text-4xl font-bold mb-8 text-indigo-700 flex items-center gap-3">
      <i class="fas fa-user text-indigo-700 text-2xl"></i>
      About Me
    </h2>
    <?php
    $about = $conn->query("SELECT content FROM about LIMIT 1")->fetch_assoc();
    echo "<div class='bg-white p-8 rounded-2xl shadow-md border border-indigo-100 animate-fade-in'>";
    echo "<p class='text-gray-800 text-lg leading-relaxed tracking-wide'>";
    echo nl2br(htmlspecialchars($about['content']));
    echo "</p></div>";
    ?>
  </div>
</section>
<!--Skills-->
<section id="skills" class="py-20 px-4 bg-gradient-to-br from-indigo-50 to-gray-100">
  <div class="max-w-5xl mx-auto">
    <h2 class="text-3xl font-bold mb-10 text-indigo-700 flex items-center gap-3">
      <i class="fas fa-code text-2xl"></i> Skills
    </h2>
    <div class="flex flex-wrap justify-center gap-8">
      <?php
      $skills = $conn->query("SELECT name, icon FROM skills");
      while ($row = $skills->fetch_assoc()) {
        echo "<div class='flex flex-col items-center gap-3 transition-transform hover:-translate-y-1 duration-300'>";
        echo "<div class='w-24 h-24 rounded-full bg-white shadow-md flex items-center justify-center text-3xl text-indigo-600 hover:bg-indigo-100 transition'>";
        echo "<i class='" . htmlspecialchars($row['icon']) . "'></i>";
        echo "</div>";
        echo "<span class='text-gray-800 font-medium text-base text-center'>" . htmlspecialchars($row['name']) . "</span>";
        echo "</div>";
      }
      ?>
    </div>
  </div>
</section>
<!--Projects-->
<section id="projects" class="py-20 px-4 bg-gradient-to-br from-white to-gray-50">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-3xl font-bold mb-10 text-indigo-700 flex items-center gap-3">
      <i class="fas fa-laptop-code text-2xl"></i> Projects
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php
      $projects = $conn->query("SELECT title, description, link, image FROM projects");
      while ($row = $projects->fetch_assoc()) {
        echo "<div class='bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col'>";
        echo "<div class='h-48 bg-cover bg-center' style='background-image: url(assets/images/" . htmlspecialchars($row['image']) . ")'></div>";
        echo "<div class='p-5 flex flex-col flex-grow'>";
        echo "<h3 class='text-xl font-semibold text-gray-800 mb-2'>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p class='text-gray-600 text-sm flex-grow'>" . htmlspecialchars($row['description']) . "</p>";
        echo "
<a href='" . htmlspecialchars($row['link']) . "'
   target='_blank'
   class='group mt-4 inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition'>

 <svg xmlns='http://www.w3.org/2000/svg'
       viewBox='0 0 24 24'
       fill='none'
       stroke='currentColor'
       stroke-width='2'
       stroke-linecap='round'
       stroke-linejoin='round'
       class='w-4 h-4 group-hover:animate-view'>
    <path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z' />
    <circle cx='12' cy='12' r='3' />
  </svg>

  View Project
</a>";
        echo "</div>";

        echo "</div>";
      }
      ?>
    </div>
  </div>
</section>
<!--Certificates-->
<section id="certificates" class="py-20 px-4 bg-gradient-to-br from-indigo-50 to-gray-100">
  <div class="max-w-5xl mx-auto">
    <h2 class="text-3xl font-bold mb-10 text-indigo-700 flex items-center gap-3">
      <i class="fa-regular fa-file text-2xl"></i> Certificates
    </h2>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
      <?php
      $certs = $conn->query("SELECT title, file FROM certificates");
      while ($row = $certs->fetch_assoc()) {
        echo "<div class='bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 flex flex-col items-center text-center'>";
        echo "<div class='w-14 h-14 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-4'>";
        echo "<i class='fas fa-award fa-lg'></i>";
        echo "</div>";

        echo "<h3 class='text-lg font-semibold text-gray-800 mb-2'>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<a href='uploads/" . htmlspecialchars($row['file']) . "' target='_blank'
                class='group inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-800 transition'>
                <svg xmlns='http://www.w3.org/2000/svg'
                     viewBox='0 0 24 24'
                     fill='none'
                     stroke='currentColor'
                     stroke-width='2'
                     stroke-linecap='round'
                     stroke-linejoin='round'
                     class='w-4 h-4 transition-transform group-hover:scale-110'>
                  <path d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z' />
                  <circle cx='12' cy='12' r='3' />
                </svg>
                View Certificate
              </a>";

        echo "</div>";
      }
      ?>
    </div>
  </div>
</section>
<!--Contact-->
<section id="contact" class="py-20 px-4 bg-gradient-to-br from-white to-slate-100">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold mb-10 text-indigo-700 flex items-center gap-3">
      <i class="fas fa-envelope text-2xl"></i> Contact Me
    </h2>
    <?php
    $contact = $conn->query("SELECT * FROM contact LIMIT 1")->fetch_assoc();
    echo "<div class='grid md:grid-cols-3 gap-6'>";

    // Email
    echo "<div class='bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300'>";
    echo "<div class='flex items-center gap-3 text-indigo-600 mb-2'>";
    echo "<i class='fas fa-envelope text-lg'></i>";
    echo "<span class='font-semibold text-base'>Email</span></div>";
    echo "<a href='mailto:" . htmlspecialchars($contact['email']) . "' class='text-black'>" . htmlspecialchars($contact['email']) . "</a>";
    echo "</div>";

    // Phone
    echo "<div class='bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300'>";
    echo "<div class='flex items-center gap-3 text-indigo-600 mb-2'>";
    echo "<i class='fas fa-phone text-lg'></i>";
    echo "<span class='font-semibold text-base'>Phone</span></div>";
    echo "<a href='tel:" . htmlspecialchars($contact['phone']) . "' class='text-black'>" . htmlspecialchars($contact['phone']) . "</a>";
    echo "</div>";

    // Location
    echo "<div class='bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition duration-300'>";
    echo "<div class='flex items-center gap-3 text-indigo-600 mb-2'>";
    echo "<i class='fas fa-map-marker-alt text-lg'></i>";
    echo "<span class='font-semibold text-base'>Location</span></div>";
    $mapQuery = urlencode($contact['location']);
    echo "<a href='https://www.google.com/maps/search/?api=1&query=$mapQuery' target='_blank' class='text-black'>" . htmlspecialchars($contact['location']) . "</a>";
    echo "</div>";


    // Social Links (LinkedIn & GitHub)
    if (!empty($contact['linkedin']) || !empty($contact['github'])) {
      echo "<div class='md:col-span-3 mt-10 flex flex-wrap justify-center gap-6'>";

      // LinkedIn Button
      if (!empty($contact['linkedin'])) {
        echo "<a href='" . htmlspecialchars($contact['linkedin']) . "' target='_blank'
            class='inline-flex items-center gap-2 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition duration-300'>
            <i class='fab fa-linkedin text-lg'></i> LinkedIn</a>";
      }

      // GitHub Button
      if (!empty($contact['github'])) {
        echo "<a href='" . htmlspecialchars($contact['github']) . "' target='_blank'
            class='inline-flex items-center gap-2 text-gray-800 hover:bg-gray-800 hover:text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition duration-300'>
            <i class='fab fa-github text-lg'></i> GitHub</a>";
      }

      echo "</div>";
    }

    echo "</div>";
    ?>
  </div>
</section>
<!--Footer-->
<footer class="bg-gray-900 text-white py-6 mt-10">
  <div class="max-w-4xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-2 text-center md:text-left">
    <p class="text-sm">
      &copy; <?php echo date('Y'); ?>
      <a href="https://mrvibecoder.netlify.app" target="_blank"
        class="font-semibold text-indigo-400 hover:text-indigo-600 transition-colors duration-200">
        Bhojanapu Deva Raj
      </a> All rights reserved.
    </p>
    <a href="admin/login.php"
      class="text-sm font-semibold text-indigo-400 hover:text-white transition-colors duration-200">
      Admin Login
    </a>
  </div>
</footer>

<script>
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();

      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth'
        });
      }
      const mobileMenu = document.getElementById('mobile-menu');
      if (window.innerWidth < 768) {
        mobileMenu.classList.add('hidden');
      }
    });
  });
  document.getElementById('menu-btn').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('hidden');
  });
</script>
</body>

</html>