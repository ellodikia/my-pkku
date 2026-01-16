<?php
include 'config/koneksi.php';
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$id'");
$row = mysqli_fetch_assoc($result);
?>
<div class="grid md:grid-cols-2 gap-8">
    <div class="rounded-2xl overflow-hidden">
        <img src="assets/img/<?= $row['gambar'] ?>" class="w-full h-auto">
    </div>
    <div>
        <h3 class="text-3xl font-bold mb-4"><?= $row['nama_produk'] ?></h3>
        <p class="text-primary font-bold text-2xl mb-6">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
        <p class="text-gray-600 mb-8"><?= $row['deskripsi'] ?></p>
        <button onclick="addToCart(<?= $row['id'] ?>)" class="w-full bg-primary text-white py-4 rounded-xl font-bold">
            Tambah ke Keranjang
        </button>
    </div>
</div>