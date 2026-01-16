<?php
session_start();
include 'config/koneksi.php';
$query_daftar_kelas = mysqli_query($koneksi, "SELECT DISTINCT users.kelas FROM produk JOIN users ON produk.id_penjual = users.id WHERE users.kelas IS NOT NULL");
$filter = isset($_GET['kelas']) ? mysqli_real_escape_string($koneksi, $_GET['kelas']) : '';
$query_sql = "SELECT produk.*, users.kelas FROM produk JOIN users ON produk.id_penjual = users.id";
if ($filter != '') { $query_sql .= " WHERE users.kelas = '$filter'"; }
$query_sql .= " ORDER BY produk.id DESC";
$result = mysqli_query($koneksi, $query_sql);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Katalog Produk | MarketPink</title>
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
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        .masonry-item {
            break-inside: avoid;
            margin-bottom: 1.5rem;
        }
        .image-hover-zoom { overflow: hidden; }
        .image-hover-zoom img { transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-card:hover .image-hover-zoom img { transform: scale(1.05); }
    </style>
</head>
<body class="font-sans bg-light text-dark">
    <?php include 'includes/nav.php'; ?>
    
    <main class="pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-6xl font-display font-black mb-6">
                    Katalog <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Produk</span>
                </h1>
                
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <a href="produk.php" 
                       class="px-5 py-2.5 rounded-full text-xs md:text-sm font-bold transition-all <?= $filter == '' ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'bg-white text-gray-600 border border-gray-200' ?>">
                        Semua
                    </a>
                    <?php while($k = mysqli_fetch_assoc($query_daftar_kelas)): ?>
                    <a href="produk.php?kelas=<?= urlencode($k['kelas']) ?>" 
                       class="px-5 py-2.5 rounded-full text-xs md:text-sm font-bold transition-all <?= $filter == $k['kelas'] ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'bg-white text-gray-600 border border-gray-200' ?>">
                        <?= $k['kelas'] ?>
                    </a>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <div class="flex justify-between items-center mb-8 px-2">
                <div class="text-xs md:text-sm text-gray-500 font-medium">
                    <span class="text-dark font-bold"><?= mysqli_num_rows($result) ?></span> Produk Ditemukan
                </div>
                <div class="flex gap-2">
                    <select class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none">
                        <option>Terbaru</option>
                        <option>Termurah</option>
                    </select>
                </div>
            </div>
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="columns-2 md:columns-3 lg:columns-4 gap-4 px-2">
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="masonry-item">
                        <div class="product-card group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-500">
                            <div class="relative image-hover-zoom">
                                <img src="assets/img/<?= $row['gambar'] ?>" 
                                     alt="<?= $row['nama_produk'] ?>"
                                     class="w-full h-auto object-cover">
                                
                                <div class="absolute top-2 left-2">
                                    <span class="px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-black rounded-lg shadow-sm uppercase">
                                        <?= $row['kelas'] ?>
                                    </span>
                                </div>

                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <button onclick="zoomImage('assets/img/<?= $row['gambar'] ?>')" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-dark"><i class="fas fa-search-plus text-xs"></i></button>
                                    <button onclick="shareProduct('<?= addslashes($row['nama_produk']) ?>', '<?= $row['id'] ?>')" class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-dark"><i class="fas fa-share-alt text-xs"></i></button>
                                </div>
                            </div>
                            
                            <div class="p-3 md:p-4">
                                <h3 class="font-bold text-sm md:text-base leading-tight mb-1 group-hover:text-primary transition-colors"><?= $row['nama_produk'] ?></h3>
                                <p class="text-primary font-black text-sm md:text-lg mb-3">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                                
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[10px] text-gray-400"><i class="fas fa-box mr-1"></i><?= $row['stok'] ?></span>
                                    <button onclick="addToCart(<?= $row['id'] ?>)"
                                            class="flex-1 bg-dark text-white text-[10px] md:text-xs font-bold py-2 rounded-lg hover:bg-primary transition-colors uppercase tracking-wider">
                                        + Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-20">
                    <div class="text-gray-300 text-6xl mb-4"><i class="fas fa-ghost"></i></div>
                    <h3 class="text-xl font-bold text-gray-800">Ups! Produk Tidak Ada</h3>
                    <p class="text-gray-500 text-sm">Coba cari kategori atau kelas yang lain.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <div id="imageZoomModal" class="fixed inset-0 bg-black/95 z-[60] hidden items-center justify-center p-4 transition-all">
        <button onclick="closeZoom()" class="absolute top-6 right-6 text-white text-3xl"><i class="fas fa-times"></i></button>
        <img id="zoomedImage" src="" class="max-w-full max-h-full rounded-lg shadow-2xl">
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script>
        function zoomImage(src) {
            document.getElementById('zoomedImage').src = src;
            document.getElementById('imageZoomModal').classList.remove('hidden');
            document.getElementById('imageZoomModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        
        function closeZoom() {
            document.getElementById('imageZoomModal').classList.add('hidden');
            document.getElementById('imageZoomModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
        
        function addToCart(id) {
            const formData = new FormData();
            formData.append('id_produk', id);
            formData.append('jumlah', 1);
            fetch('aksi_keranjang.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') showNotification('Berhasil ditambah!', 'success');
                });
        }
        
        function shareProduct(name, id) {
            const url = `${window.location.origin}/detail.php?id=${id}`;
            if (navigator.share) {
                navigator.share({ title: name, url: url });
            } else {
                navigator.clipboard.writeText(url);
                showNotification('Link disalin!', 'info');
            }
        }
        
        function showNotification(message, type) {
            const el = document.createElement('div');
            el.className = `fixed bottom-6 left-1/2 -translate-x-1/2 z-[70] px-6 py-3 rounded-full text-white text-xs font-bold shadow-2xl animate-bounce ${type === 'success' ? 'bg-green-500' : 'bg-primary'}`;
            el.innerHTML = message;
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 3000);
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeZoom(); });
    </script>
</body>
</html>