<?php
session_start();
include 'config/koneksi.php';

$error = "";
if(isset($_SESSION['login'])) {
    if($_SESSION['role'] == 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: penjual/index.php");
    }
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $row['id']; 
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: penjual/index.php");
            }
            exit;
        }
    }
    $error = true;
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | MarketPink Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#EC4899',
                        secondary: '#8B5CF6',
                        dark: '#1F2937',
                        light: '#F9FAFB'
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                        'display': ['Poppins', 'Inter', 'sans-serif']
                    },
                    animation: {
                        'gradient': 'gradient 3s ease infinite',
                        'fade-in': 'fadeIn 0.5s ease-out'
                    },
                    keyframes: {
                        gradient: {
                            '0%, 100%': { 'background-position': '0% 50%' },
                            '50%': { 'background-position': '100% 50%' }
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .gradient-border {
            position: relative;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #EC4899, #8B5CF6) border-box;
            border: 2px solid transparent;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="font-sans bg-light min-h-screen flex items-center justify-center p-4">
    <div class="fixed inset-0 gradient-bg opacity-5"></div>
    
    <div class="relative w-full max-w-md">
        <div class="text-center mb-10">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-lg">
                <i class="fas fa-store text-3xl text-white"></i>
            </div>
            <h1 class="text-4xl font-display font-black tracking-tight">
                MY<span class="text-primary">PKKU.</span>
            </h1>
            <p class="text-gray-500 text-sm mt-2 font-medium">Dashboard Access Portal</p>
        </div>

        <div class="gradient-border rounded-2xl p-8 bg-white shadow-2xl">
            <div class="flex items-center mb-8">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mr-3">
                    <i class="fas fa-lock text-primary"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold">Welcome Back</h2>
                    <p class="text-gray-500 text-sm">Masuk ke dashboard Anda</p>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
                    <div class="flex items-center text-red-600">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        <span class="font-medium">Username atau password salah</span>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input 
                            class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Enter your username" 
                            required 
                        />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            class="w-full pl-10 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter your password" 
                            required 
                        />
                        <button type="button" 
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-400 hover:text-primary"></i>
                        </button>
                    </div>
                </div>

                <button 
                    class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-4 rounded-xl hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 transform hover:-translate-y-1 active:scale-95"
                    type="submit" 
                    name="login">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In to Dashboard
                </button>
            </form>

        </div>

        <div class="text-center mt-8">
            <a href="index.php" 
               class="inline-flex items-center text-gray-500 hover:text-primary transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Toko
            </a>
        </div>

    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const icon = event.currentTarget.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>