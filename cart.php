<?php
session_start();
include 'config/koneksi.php';
$keranjang_kosong = (!isset($_SESSION['cart']) || empty($_SESSION['cart']));
if (!$keranjang_kosong) {
    $ids = array_keys($_SESSION['cart']);
    $ids_string = implode(',', $ids);
    $result = mysqli_query($koneksi, "SELECT * FROM produk WHERE id IN ($ids_string)");
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Keranjang Belanja | MarketPink</title>
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
                        'slide-up': 'slideUp 0.3s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-effect { backdrop-filter: blur(10px); }
        .product-image { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-image:hover { transform: scale(1.05); }
        .quantity-btn { transition: all 0.2s ease; }
        .quantity-btn:hover { transform: scale(1.1); }
        .cart-item { transition: all 0.3s ease; }
        .cart-item:hover { box-shadow: 0 10px 25px -5px rgba(236, 72, 153, 0.1); }
    </style>
</head>
<body class="font-sans bg-light text-dark">
    <?php include 'includes/nav.php'; ?>
    
    <main class="pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-display font-black tracking-tight">Keranjang <span class="text-primary">B</span>elanja</h1>
                        <p class="text-gray-500 mt-2">Kelola produk yang akan Anda beli</p>
                    </div>
                    <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                        <span>Beranda</span>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="text-primary font-medium">Keranjang</span>
                    </div>
                </div>
                
                <?php if ($keranjang_kosong): ?>
                    <div class="animate-fade-in">
                        <div class="max-w-md mx-auto text-center py-16">
                            <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-pink-50 to-purple-50 flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-5xl text-gray-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Keranjang Anda Kosong</h3>
                            <p class="text-gray-500 mb-8">Tambahkan produk favorit Anda untuk mulai berbelanja</p>
                            <a href="produk.php" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <i class="fas fa-store mr-3"></i>
                                Jelajahi Produk
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="grid lg:grid-cols-3 gap-8">
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-bold text-lg">Produk dalam Keranjang</h3>
                                        <span class="text-sm text-gray-500"><?= count($_SESSION['cart']) ?> item</span>
                                    </div>
                                </div>
                                
                                <div class="divide-y divide-gray-100">
                                    <?php 
                                    $total = 0;
                                    while($row = mysqli_fetch_assoc($result)): 
                                        $sub = $row['harga'] * $_SESSION['cart'][$row['id']];
                                        $total += $sub;
                                    ?>
                                    <div class="cart-item p-6 hover:bg-gray-50/50">
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                                            <div class="relative flex-shrink-0">
                                                <div class="w-28 h-28 rounded-xl overflow-hidden bg-gray-100">
                                                    <img src="assets/img/<?= $row['gambar'] ?>" 
                                                         alt="<?= $row['nama_produk'] ?>"
                                                         class="w-full h-full object-cover product-image">
                                                </div>
                                                <button onclick="openImageModal('assets/img/<?= $row['gambar'] ?>')"
                                                        class="absolute bottom-2 right-2 w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-primary hover:bg-white transition-all">
                                                    <i class="fas fa-expand-alt text-xs"></i>
                                                </button>
                                            </div>
                                            
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-bold text-lg mb-1 truncate"><?= $row['nama_produk'] ?></h4>
                                                <p class="text-primary font-bold text-lg mb-2">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <span class="flex items-center">
                                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                                        Stok: <?= $row['stok'] ?>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex flex-col items-end space-y-4">
                                                <div class="flex items-center bg-gray-50 rounded-xl px-4 py-2">
                                                    <a href="aksi_cart_update.php?id=<?= $row['id'] ?>&act=min"
                                                       class="quantity-btn w-8 h-8 flex items-center justify-center text-gray-400 hover:text-primary hover:bg-white rounded-lg">
                                                        <i class="fas fa-minus"></i>
                                                    </a>
                                                    <span class="mx-4 font-bold text-lg min-w-[40px] text-center"><?= $_SESSION['cart'][$row['id']] ?></span>
                                                    <a href="aksi_cart_update.php?id=<?= $row['id'] ?>&act=plus"
                                                       class="quantity-btn w-8 h-8 flex items-center justify-center text-gray-400 hover:text-primary hover:bg-white rounded-lg">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <p class="text-xs text-gray-500 mb-1">Subtotal</p>
                                                    <p class="font-bold text-xl text-secondary">Rp <?= number_format($sub, 0, ',', '.') ?></p>
                                                </div>
                                            </div>
                                            
                                            <a href="aksi_cart_update.php?id=<?= $row['id'] ?>&act=del"
                                               class="text-gray-300 hover:text-red-500 transition-colors p-2"
                                               onclick="return confirm('Hapus produk dari keranjang?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="lg:col-span-1">
                            <div class="sticky top-24">
                                <div class="bg-gradient-to-br from-dark to-gray-900 rounded-2xl text-white p-8 shadow-xl">
                                    <h3 class="text-2xl font-bold mb-6">Ringkasan Pesanan</h3>
                                    
                                    <div class="space-y-4 mb-6">
                                        <div class="flex justify-between items-center py-3 border-b border-white/10">
                                            <span class="text-gray-300">Subtotal</span>
                                            <span class="font-bold">Rp <?= number_format($total, 0, ',', '.') ?></span>
                                        </div>
                                        <div class="flex justify-between items-center pt-4">
                                            <span class="text-lg">Total</span>
                                            <span class="text-3xl font-black">Rp <?= number_format($total, 0, ',', '.') ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <a href="checkout.php"
                                           class="block w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-4 rounded-xl text-center hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 transform hover:-translate-y-1">
                                            <i class="fas fa-lock mr-2"></i>
                                            Lanjutkan ke Pembayaran
                                        </a>
                                        
                                        <a href="produk.php"
                                           class="block w-full bg-white/10 backdrop-blur-sm text-white font-medium py-4 rounded-xl text-center hover:bg-white/20 transition-all">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Lanjutkan Belanja
                                        </a>
                                    </div>
                                    
                                    <div class="mt-8 pt-6 border-t border-white/10">
                                        <p class="text-sm text-gray-300 mb-2 flex items-center">
                                            <i class="fas fa-shield-alt mr-2 text-primary"></i>
                                            Pembayaran dengan sistem COD
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <div id="imageModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-[90vh]">
            <button onclick="closeImageModal()" 
                    class="absolute -top-12 right-0 text-white text-2xl hover:text-primary transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="Preview" class="w-full h-auto rounded-xl">
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeImageModal();
        });
    </script>
</body>
</html>