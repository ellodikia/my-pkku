<?php
session_start();
include 'config/koneksi.php';
$error = ""; $success = "";
if(isset($_SESSION['login'])) {
    header("Location: " . ($_SESSION['role'] == 'admin' ? 'admin/index.php' : 'penjual/index.php'));
    exit;
}
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $check = mysqli_query($koneksi, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) { $error = "Username sudah terdaftar"; }
    elseif ($password !== $confirm) { $error = "Konfirmasi password salah"; }
    else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        if (mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', 'penjual')")) {
            $success = "Registrasi Berhasil";
        } else { $error = "Gagal mendaftar"; }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun | MarketPink</title>
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
                        'float': 'float 3s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.8s ease-out'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
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
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="font-sans bg-light min-h-screen flex items-center justify-center p-4">
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-secondary/5 rounded-full blur-3xl animate-float" style="animation-delay: 1.5s"></div>
    </div>
    
    <div class="relative w-full max-w-2xl">
        <div class="text-center mb-12">
            <div class="w-24 h-24 mx-auto mb-8 rounded-3xl bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-2xl">
                <i class="fas fa-user-plus text-4xl text-white"></i>
            </div>
            <h1 class="text-5xl font-display font-black tracking-tight mb-4">
                Bergabung dengan <span class="text-primary">MarketPink</span>
            </h1>
            <p class="text-gray-600 text-lg max-w-md mx-auto">
                Mulai jual produk kreatif Anda dan menjadi bagian dari komunitas premium kami
            </p>
        </div>

        <div class="gradient-border rounded-3xl p-8 md:p-12 bg-white shadow-2xl">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-8">
                    <h3 class="text-2xl font-bold">Keuntungan Bergabung</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-store text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1">Toko Digital Premium</h4>
                                <p class="text-gray-600 text-sm">Tampilkan produk dengan desain profesional</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-chart-line text-secondary"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1">Analitik Penjualan</h4>
                                <p class="text-gray-600 text-sm">Pantau performa produk secara real-time</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1">Komunitas Eksklusif</h4>
                                <p class="text-gray-600 text-sm">Terhubung dengan penjual kreatif lainnya</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-shield-alt text-secondary"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1">Keamanan Transaksi</h4>
                                <p class="text-gray-600 text-sm">Sistem pembayaran yang aman dan terpercaya</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-6 border-t border-gray-100">
                        <p class="text-sm text-gray-500">
                            Sudah punya akun?
                            <a href="login.php" class="text-primary font-medium hover:underline ml-1">
                                Masuk ke Dashboard
                            </a>
                        </p>
                    </div>
                </div>
                
                <div>
                    <?php if ($error): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl animate-fade-in">
                            <div class="flex items-center text-red-600">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                <span class="font-medium"><?= $error; ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-xl animate-fade-in">
                            <div class="flex items-center text-green-600">
                                <i class="fas fa-check-circle mr-3"></i>
                                <span class="font-medium"><?= $success; ?>! 
                                    <a href="login.php" class="underline font-bold">Login Sekarang</a>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <form action="" method="post" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input 
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                    type="text" 
                                    name="username" 
                                    placeholder="Buat username unik"
                                    required 
                                />
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Minimal 3 karakter, tanpa spasi</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
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
                                    placeholder="Buat password kuat"
                                    required
                                    oninput="checkPasswordStrength(this.value)"
                                />
                                <button type="button" 
                                        onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-primary"></i>
                                </button>
                            </div>
                            <div class="mt-2">
                                <div class="flex space-x-1 mb-1">
                                    <div id="strength-1" class="password-strength flex-1 bg-gray-200"></div>
                                    <div id="strength-2" class="password-strength flex-1 bg-gray-200"></div>
                                    <div id="strength-3" class="password-strength flex-1 bg-gray-200"></div>
                                    <div id="strength-4" class="password-strength flex-1 bg-gray-200"></div>
                                </div>
                                <p id="strength-text" class="text-xs text-gray-500"></p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input 
                                    class="w-full pl-10 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                    type="password" 
                                    id="confirm_password"
                                    name="confirm_password" 
                                    placeholder="Ketik ulang password"
                                    required
                                />
                                <button type="button" 
                                        onclick="togglePassword('confirm_password')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-primary"></i>
                                </button>
                            </div>
                            <p id="confirm-text" class="text-xs mt-2"></p>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="terms" required class="w-5 h-5 text-primary rounded border-gray-300">
                            <label for="terms" class="ml-3 text-sm text-gray-600">
                                Saya setuju dengan 
                                <a href="#" class="text-primary font-medium hover:underline">Syarat & Ketentuan</a>
                                dan 
                                <a href="#" class="text-primary font-medium hover:underline">Kebijakan Privasi</a>
                            </label>
                        </div>
                        
                        <button 
                            class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-4 rounded-xl hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 transform hover:-translate-y-1 active:scale-95"
                            type="submit" 
                            name="register">
                            <i class="fas fa-user-plus mr-3"></i>
                            Daftar Akun Penjual
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="index.php" 
               class="inline-flex items-center text-gray-500 hover:text-primary transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = event.currentTarget.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        function checkPasswordStrength(password) {
            const strengthBars = [
                document.getElementById('strength-1'),
                document.getElementById('strength-2'),
                document.getElementById('strength-3'),
                document.getElementById('strength-4')
            ];
            const strengthText = document.getElementById('strength-text');
            const confirmText = document.getElementById('confirm-text');
            const confirmField = document.getElementById('confirm_password');
            
            // Reset bars
            strengthBars.forEach(bar => {
                bar.className = 'password-strength flex-1 bg-gray-200';
            });
            
            let strength = 0;
            let text = 'Password lemah';
            let color = 'red';
            
            // Check password criteria
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Update UI based on strength
            for (let i = 0; i < strength; i++) {
                if (strength === 1) {
                    strengthBars[i].className = 'password-strength flex-1 bg-red-500';
                    text = 'Password lemah';
                    color = 'red';
                } else if (strength === 2) {
                    strengthBars[i].className = 'password-strength flex-1 bg-yellow-500';
                    text = 'Password cukup';
                    color = 'yellow';
                } else if (strength === 3) {
                    strengthBars[i].className = 'password-strength flex-1 bg-blue-500';
                    text = 'Password kuat';
                    color = 'blue';
                } else if (strength >= 4) {
                    strengthBars[i].className = 'password-strength flex-1 bg-green-500';
                    text = 'Password sangat kuat';
                    color = 'green';
                }
            }
            
            strengthText.textContent = text;
            strengthText.className = `text-xs text-${color}-500 mt-1`;
            
            // Check password confirmation
            if (confirmField.value) {
                if (password === confirmField.value) {
                    confirmText.textContent = '✓ Password cocok';
                    confirmText.className = 'text-xs text-green-500 mt-2';
                } else {
                    confirmText.textContent = '✗ Password tidak cocok';
                    confirmText.className = 'text-xs text-red-500 mt-2';
                }
            }
        }
        
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmText = document.getElementById('confirm-text');
            
            if (this.value) {
                if (password === this.value) {
                    confirmText.textContent = '✓ Password cocok';
                    confirmText.className = 'text-xs text-green-500 mt-2';
                } else {
                    confirmText.textContent = '✗ Password tidak cocok';
                    confirmText.className = 'text-xs text-red-500 mt-2';
                }
            } else {
                confirmText.textContent = '';
            }
        });
    </script>
</body>
</html>