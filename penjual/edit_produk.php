<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'penjual') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$id_penjual = $_SESSION['id'];
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$id' AND id_penjual = '$id_penjual'");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    header("Location: produk.php");
    exit;
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Produk | MarketPink</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50/50">
    <?php include '../includes/nav_penjual.php'; ?>
    
    <div class="max-w-3xl mx-auto px-4 py-16">
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-pink-100/20 border border-pink-50 overflow-hidden">
            
            <div class="p-10 border-b border-pink-50 bg-gradient-to-r from-white to-pink-50/30">
                <h1 class="text-3xl font-black text-black tracking-tighter uppercase">Edit <span class="text-pink-500">Product</span></h1>
                <p class="text-gray-500 mt-2 font-medium">Perbarui informasi produk eksklusif Anda.</p>
            </div>

            <form action="proses.php" method="post" enctype="multipart/form-data" class="p-10 space-y-8">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-pink-400 mb-3">Nama Produk</label>
                    <input type="text" name="nama_produk" value="<?= $row['nama_produk'] ?>"
                           class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-pink-500 outline-none transition-all font-bold text-black" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-pink-400 mb-3">Harga (Rp)</label>
                        <input type="number" name="harga" value="<?= $row['harga'] ?>"
                               class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-pink-500 outline-none transition-all font-bold text-black" required />
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-pink-400 mb-3">Stok</label>
                        <input type="number" name="stok" value="<?= $row['stok'] ?>"
                               class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-pink-500 outline-none transition-all font-bold text-black" required />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-pink-400 mb-3">Deskripsi Produk</label>
                    <textarea name="deskripsi" rows="4" 
                              class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-pink-500 outline-none transition-all font-bold text-black" required><?= $row['deskripsi'] ?></textarea>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-pink-400 mb-3">Foto Produk Saat Ini</label>
                    <div class="mt-3 mb-6">
                        <img src="../assets/img/<?= $row['gambar'] ?>" class="w-32 h-32 object-cover rounded-3xl border-2 border-pink-100 shadow-md">
                    </div>
                    
                    <label class="block text-xs font-black uppercase tracking-widest text-pink-400 mb-3">Ganti Foto (Opsional)</label>
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-pink-100 border-dashed rounded-3xl bg-pink-50/30">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-10 w-10 text-pink-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-44h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer font-black text-pink-500 hover:text-pink-600">
                                    <span>Upload new image</span>
                                    <input id="file-upload" name="gambar" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" name="update" 
                            class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-black uppercase tracking-widest text-sm py-4 rounded-full shadow-lg shadow-pink-200 transition-all active:scale-95 hover:-translate-y-1">
                        Update Product
                    </button>
                    <a href="produk.php" 
                       class="flex-1 bg-black hover:bg-gray-800 text-white font-black uppercase tracking-widest text-sm py-4 rounded-full text-center transition-all active:scale-95 hover:-translate-y-1">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>