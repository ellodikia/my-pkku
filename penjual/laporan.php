<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'penjual') {
    header("Location: ../login.php");
    exit;
}

$id_penjual = $_SESSION['id'];

$query_pendapatan = "SELECT SUM(pr.harga * dp.jumlah) as total 
                    FROM detail_pesanan dp 
                    JOIN produk pr ON dp.id_produk = pr.id 
                    WHERE pr.id_penjual = '$id_penjual'";
$res_pendapatan = mysqli_query($koneksi, $query_pendapatan);
$data_pendapatan = mysqli_fetch_assoc($res_pendapatan);
$total_pendapatan = $data_pendapatan['total'] ?? 0;

$query_terjual = "SELECT SUM(dp.jumlah) as qty 
                  FROM detail_pesanan dp 
                  JOIN produk pr ON dp.id_produk = pr.id 
                  WHERE pr.id_penjual = '$id_penjual'";
$res_terjual = mysqli_query($koneksi, $query_terjual);
$data_terjual = mysqli_fetch_assoc($res_terjual);
$total_terjual = $data_terjual['qty'] ?? 0;

$query_pesanan = "SELECT COUNT(DISTINCT dp.id_pesanan) as jml 
                  FROM detail_pesanan dp 
                  JOIN produk pr ON dp.id_produk = pr.id 
                  WHERE pr.id_penjual = '$id_penjual'";
$res_pesanan = mysqli_query($koneksi, $query_pesanan);
$data_pesanan = mysqli_fetch_assoc($res_pesanan);
$jml_pesanan = $data_pesanan['jml'] ?? 0;

$query_history = "SELECT p.tanggal, pr.nama_produk, dp.jumlah, (pr.harga * dp.jumlah) as subtotal
                  FROM detail_pesanan dp
                  JOIN pesanan p ON dp.id_pesanan = p.id
                  JOIN produk pr ON dp.id_produk = pr.id
                  WHERE pr.id_penjual = '$id_penjual'
                  ORDER BY p.tanggal DESC LIMIT 10";
$res_history = mysqli_query($koneksi, $query_history);
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Penjualan | MarketPink</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50/50">

    <?php include '../includes/nav_penjual.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-black text-black tracking-tighter uppercase">Sales <span class="text-pink-500">Report</span></h1>
            <p class="text-gray-500 mt-2 font-medium">Analisis performa bisnis Anda secara real-time.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-black p-8 rounded-[2.5rem] shadow-xl shadow-gray-200">
                <p class="text-pink-500 text-xs font-black uppercase tracking-[0.2em] mb-4">Total Revenue</p>
                <h2 class="text-3xl font-black text-white">Rp<?= number_format($total_pendapatan, 0, ',', '.') ?></h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="w-8 h-1 bg-pink-500 rounded-full"></span>
                    <p class="text-gray-400 text-[10px] font-bold uppercase">Update Live</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-pink-100/20 border border-pink-50">
                <p class="text-gray-400 text-xs font-black uppercase tracking-[0.2em] mb-4">Items Sold</p>
                <h2 class="text-3xl font-black text-black"><?= number_format($total_terjual, 0, ',', '.') ?> <span class="text-sm font-medium text-gray-400">Pcs</span></h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="w-8 h-1 bg-black rounded-full"></span>
                    <p class="text-gray-400 text-[10px] font-bold uppercase">Product Volume</p>
                </div>
            </div>

            <div class="bg-pink-500 p-8 rounded-[2.5rem] shadow-xl shadow-pink-200">
                <p class="text-white text-xs font-black uppercase tracking-[0.2em] mb-4">Total Orders</p>
                <h2 class="text-3xl font-black text-white"><?= $jml_pesanan ?> <span class="text-sm font-medium text-pink-200">Orders</span></h2>
                <div class="mt-4 flex items-center gap-2">
                    <span class="w-8 h-1 bg-white rounded-full"></span>
                    <p class="text-pink-200 text-[10px] font-bold uppercase">Customer Reach</p>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-black text-black uppercase tracking-tight mb-6">Recent Transactions</h3>
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-pink-100/20 border border-pink-50 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-black uppercase tracking-widest text-gray-400">
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5">Product Name</th>
                            <th class="px-8 py-5 text-center">Qty</th>
                            <th class="px-8 py-5">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-50">
                        <?php while($row = mysqli_fetch_assoc($res_history)): ?>
                            <tr class="hover:bg-pink-50/20 transition-colors">
                                <td class="px-8 py-5 text-xs font-bold text-gray-500"><?= date('d/m/Y H:i', strtotime($row['tanggal'])) ?></td>
                                <td class="px-8 py-5 font-black text-black uppercase text-sm"><?= $row['nama_produk'] ?></td>
                                <td class="px-8 py-5 text-center font-bold text-gray-700"><?= $row['jumlah'] ?></td>
                                <td class="px-8 py-5 font-black text-pink-500 text-sm">Rp<?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include '../includes/footer_penjual.php'; ?>

</body>
</html>