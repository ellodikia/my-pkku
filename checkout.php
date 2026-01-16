<?php
session_start();
include 'config/koneksi.php';
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) { header("Location: produk.php"); exit; }
$ids = array_keys($_SESSION['cart']);
$ids_string = implode(',', $ids);
$result = mysqli_query($koneksi, "SELECT * FROM produk WHERE id IN ($ids_string)");
$total = 0;
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout | MarketPink</title>
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
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .input-field { transition: all 0.3s ease; }
        .input-field:focus { box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1); }
        .checkout-step { transition: all 0.3s ease; }
        .checkout-step.active { border-color: #EC4899; background: linear-gradient(135deg, #FDF2F8 0%, #F5F3FF 100%); }
    </style>
</head>
<body class="font-sans bg-light text-dark">
    <?php include 'includes/nav.php'; ?>
    
    <main class="pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-display font-black tracking-tight">Checkout</h1>
                        <p class="text-gray-500 mt-2">Selesaikan pembelian Anda dengan aman</p>
                    </div>
                </div>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8">
                <div class="space-y-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center mr-4">
                                <i class="fas fa-shipping-fast text-primary text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Data Pembeli</h3>
                                <p class="text-gray-500 text-sm">Isi data penerima dengan benar</p>
                            </div>
                        </div>
                        
                        <form action="proses_checkout.php" method="POST" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap Penerima <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" 
                                           name="nama_pembeli" 
                                           required
                                           class="input-field w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary"
                                           placeholder="Masukkan nama lengkap">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kelas & Jurusan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fas fa-graduation-cap absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" 
                                           name="kelas_pembeli" 
                                           required
                                           class="input-field w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary"
                                           placeholder="Contoh: XII RPL 1">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    WhatsApp Aktif <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="fab fa-whatsapp absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="tel" 
                                           name="no_wa" 
                                           required
                                           class="input-field w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary"
                                           placeholder="08XXXXXXXXXX">
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <div class="flex items-center mb-4">
                                    <input type="checkbox" id="terms" required class="w-5 h-5 text-primary rounded border-gray-300">
                                    <label for="terms" class="ml-3 text-sm text-gray-600">
                                        Saya setuju dengan <a href="#" class="text-primary font-medium hover:underline">Syarat & Ketentuan</a>
                                    </label>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-5 rounded-xl hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fas fa-lock mr-2"></i>
                                    Buat Pesanan Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                    
                </div>
                
                <div class="space-y-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sticky top-24">
                        <h3 class="text-2xl font-bold mb-8 pb-4 border-b border-gray-100">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-6 mb-8 max-h-96 overflow-y-auto pr-2">
                            <?php while($row = mysqli_fetch_assoc($result)): 
                                $sub = $row['harga'] * $_SESSION['cart'][$row['id']];
                                $total += $sub;
                            ?>
                            <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors">
                                <div class="relative flex-shrink-0">
                                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100">
                                        <img src="assets/img/<?= $row['gambar'] ?>" 
                                             alt="<?= $row['nama_produk'] ?>"
                                             class="w-full h-full object-cover">
                                    </div>
                                    <span class="absolute -top-2 -right-2 bg-primary text-white text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center">
                                        <?= $_SESSION['cart'][$row['id']] ?>
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-semibold text-sm truncate"><?= $row['nama_produk'] ?></h5>
                                    <p class="text-gray-500 text-xs">Rp <?= number_format($row['harga'], 0, ',', '.') ?> × <?= $_SESSION['cart'][$row['id']] ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-primary">Rp <?= number_format($sub, 0, ',', '.') ?></p>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <div class="space-y-4 border-t border-gray-100 pt-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Biaya Pengiriman</span>
                                <span class="font-medium text-green-600">GRATIS</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="text-lg font-bold">Total Pembayaran</span>
                                <span class="text-2xl font-black text-primary">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>