<?php
session_start();
include 'config/koneksi.php';
$query = "SELECT * FROM produk ORDER BY id DESC LIMIT 8";
$result = mysqli_query($koneksi, $query);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MarketPink | Premium Marketplace</title>
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
                        'fade-in': 'fadeIn 1s ease-out'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title></title>
    <style>
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
        .product-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-card:hover { transform: translateY(-8px); }
        .image-zoom-container { overflow: hidden; }
        .image-zoom-container img { transition: transform 0.7s ease; }
        .image-zoom-container:hover img { transform: scale(1.1); }
        
        .masonry-item {
            break-inside: avoid;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body class="font-sans bg-light text-dark">
    <?php include 'includes/nav.php'; ?>
    
    <section class="relative pt-24 pb-20 overflow-hidden">
        <div class="absolute inset-0 gradient-bg opacity-5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 text-primary font-semibold text-sm mb-8">
                    </div>
                    <h1 class="text-5xl md:text-7xl font-display font-black leading-tight mb-6">
                        Website penjualan <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Produk PKKU</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-10 max-w-xl">
                        Platform yang menghubungkan kreativitas siswa dengan produk hasil project PKKU. Temukan karya terbaik dari komunitas kreatif.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="produk.php" 
                           class="px-8 py-4 bg-gradient-to-r from-primary to-secondary text-white font-bold rounded-xl hover:shadow-xl hover:shadow-primary/30 transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fas fa-store mr-3"></i>
                            Jelajahi Produk
                        </a>
                        <a href="#featured" 
                           class="px-8 py-4 bg-white border-2 border-gray-200 font-semibold rounded-xl hover:border-primary hover:text-primary transition-all">
                            <i class="fas fa-eye mr-3"></i>
                            Lihat Koleksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="featured" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-display font-black mb-4">Produk <span class="text-primary">Unggulan</span></h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Koleksi terpilih dari produk-produk premium yang dibuat dengan kreativitas terbaik</p>
            </div>
            
            <div class="columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6">
                <?php 
                mysqli_data_seek($result, 0);
                while($row = mysqli_fetch_assoc($result)): 
                ?>
                <div class="masonry-item">
                    <div class="product-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden group">
                        <div class="relative overflow-hidden">
                            <div class="image-zoom-container">
                                <img src="assets/img/<?= $row['gambar'] ?>" 
                                     alt="<?= $row['nama_produk'] ?>"
                                     class="w-full h-auto object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                        </div>
                        
                        <div class="p-4 md:p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-sm md:text-lg line-clamp-2"><?= $row['nama_produk'] ?></h3>
                                <button onclick="shareProduct('<?= addslashes($row['nama_produk']) ?>', '<?= $row['id'] ?>')"
                                        class="text-gray-400 hover:text-primary transition-colors ml-2">
                                    <i class="fas fa-share-alt text-sm"></i>
                                </button>
                            </div>
                            <p class="text-primary font-bold text-base md:text-xl mb-3">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] md:text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-box mr-1 md:mr-2"></i>
                                    Stok: <?= $row['stok'] ?>
                                </span>
                                <button onclick="addToCartFeatured(<?= $row['id'] ?>)"
                                        class="p-2 md:px-4 md:py-2 bg-gray-100 text-dark rounded-lg hover:bg-primary hover:text-white transition-all">
                                    <i class="fas fa-cart-plus text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="produk.php" 
                   class="inline-flex items-center px-8 py-4 border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition-all duration-300">
                    Lihat Semua Produk
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        </div>
    </section>
    
    <div id="quickViewModal" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <h3 class="text-2xl font-bold">Detail Produk</h3>
                <button onclick="closeQuickView()" 
                        class="text-gray-400 hover:text-dark text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="quickViewContent" class="p-6">
            </div>
        </div>
    </div>
    
    <div id="shareModal" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold">Bagikan Produk</h3>
                <button onclick="closeShareModal()" class="text-gray-400 hover:text-dark">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-4 gap-4">
                <button onclick="shareWhatsApp()" class="p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                    <i class="fab fa-whatsapp text-2xl text-green-500"></i>
                </button>
                <button onclick="shareFacebook()" class="p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                    <i class="fab fa-facebook text-2xl text-blue-500"></i>
                </button>
                <button onclick="shareTwitter()" class="p-4 bg-sky-50 rounded-xl hover:bg-sky-100 transition-colors">
                    <i class="fab fa-twitter text-2xl text-sky-500"></i>
                </button>
                <button onclick="shareCopy()" class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <i class="fas fa-link text-2xl text-gray-500"></i>
                </button>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script>
        let currentProductId = null;
        let currentProductName = '';
        
        function openQuickView(id, name, price, image) {
            fetch(`detail_ajax.php?id=${id}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('quickViewContent').innerHTML = html;
                    document.getElementById('quickViewModal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
        }
        
        function closeQuickView() {
            document.getElementById('quickViewModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        function shareProduct(name, id) {
            currentProductId = id;
            currentProductName = name;
            document.getElementById('shareModal').classList.remove('hidden');
        }
        
        function closeShareModal() {
            document.getElementById('shareModal').classList.add('hidden');
        }
        
        function shareWhatsApp() {
            const url = `${window.location.origin}/detail.php?id=${currentProductId}`;
            window.open(`https://wa.me/?text=Lihat produk ini: ${currentProductName} ${url}`, '_blank');
        }
        
        function shareFacebook() {
            const url = `${window.location.origin}/detail.php?id=${currentProductId}`;
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
        }
        
        function shareTwitter() {
            const url = `${window.location.origin}/detail.php?id=${currentProductId}`;
            window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(currentProductName)}&url=${encodeURIComponent(url)}`, '_blank');
        }
        
        function shareCopy() {
            const url = `${window.location.origin}/detail.php?id=${currentProductId}`;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link berhasil disalin!');
            });
        }
        
        function addToCartFeatured(id) {
            const formData = new FormData();
            formData.append('id_produk', id);
            formData.append('jumlah', 1);
            
            fetch('aksi_keranjang.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-fade-in';
                        notification.innerHTML = `
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                <span>Produk berhasil ditambahkan ke keranjang!</span>
                            </div>
                        `;
                        document.body.appendChild(notification);
                        setTimeout(() => notification.remove(), 3000);
                    }
                });
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeQuickView();
                closeShareModal();
            }
        });
    </script>
</body>
</html>