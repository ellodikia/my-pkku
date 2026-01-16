<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'penjual') {
    header("Location: ../login.php");
    exit;
}

$id_penjual = $_SESSION['id'];

if (isset($_GET['update_status'])) {
    $id_pesanan = mysqli_real_escape_string($koneksi, $_GET['update_status']);
    mysqli_query($koneksi, "UPDATE pesanan SET status = 'Selesai' WHERE id = '$id_pesanan'");
    header("Location: pesanan_masuk.php");
    exit;
}

$query = "SELECT p.id, p.nama_pembeli, p.tanggal, p.status, pr.nama_produk, dp.jumlah, (pr.harga * dp.jumlah) as total_harga
          FROM pesanan p
          JOIN detail_pesanan dp ON p.id = dp.id_pesanan
          JOIN produk pr ON dp.id_produk = pr.id
          WHERE pr.id_penjual = '$id_penjual'
          ORDER BY p.tanggal DESC;";

$result = mysqli_query($koneksi, $query);
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Orders | MarketPink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .masonry-item { break-inside: avoid; margin-bottom: 1.5rem; }
    </style>
</head>
<body class="bg-[#FAFAFA] text-zinc-900 font-sans">

    <?php include '../includes/nav_penjual.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-5xl font-black tracking-tighter uppercase italic">
                    Recent <span class="text-pink-500">Orders</span>
                </h1>
                <p class="text-zinc-400 mt-2 font-bold text-xs uppercase tracking-[0.2em]">Management Dashboard</p>
            </div>
            <div class="text-right">
                <span class="bg-black text-white px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest">
                    Total: <?= mysqli_num_rows($result) ?> Orders
                </span>
            </div>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6">
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="masonry-item">
                        <div class="group relative bg-white border border-zinc-100 rounded-[2rem] p-6 shadow-sm hover:shadow-2xl hover:shadow-pink-200/50 transition-all duration-500 cursor-pointer overflow-hidden">
                            
                            <div class="flex justify-between items-start mb-6">
                                <span class="text-[10px] font-black text-zinc-300 uppercase italic">#ID-<?= $row['id'] ?></span>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-zinc-400 uppercase tracking-tighter"><?= date('d M Y', strtotime($row['tanggal'])) ?></p>
                                    <p class="text-[8px] font-bold text-pink-400"><?= date('H:i', strtotime($row['tanggal'])) ?></p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-xs font-black text-zinc-400 uppercase tracking-widest mb-1">Customer</h3>
                                <p class="text-lg font-black text-black leading-none uppercase italic tracking-tighter"><?= $row['nama_pembeli'] ?></p>
                            </div>

                            <div class="bg-zinc-50 rounded-2xl p-4 mb-6">
                                <p class="text-[10px] font-black text-zinc-400 uppercase mb-2">Item</p>
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-sm truncate pr-4"><?= $row['nama_produk'] ?></span>
                                    <span class="bg-white px-2 py-1 rounded-md text-[10px] font-black border border-zinc-100">x<?= $row['jumlah'] ?></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <p class="text-[10px] font-black text-zinc-400 uppercase">Total Earnings</p>
                                    <p class="text-xl font-black text-pink-500 tracking-tighter">Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></p>
                                </div>
                            </div>

                            <?php if($row['status'] == 'Proses' || $row['status'] == 'Pending'): ?>
                                <a href="?update_status=<?= $row['id'] ?>" 
                                   onclick="return confirm('Tandai pesanan ini sebagai Selesai?')"
                                   class="block w-full text-center bg-black text-white py-4 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-pink-500 transition-colors duration-300">
                                    Mark as Finished
                                </a>
                            <?php else: ?>
                            <?php endif; ?>

                            <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-pink-500/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="py-24 text-center">
                <div class="mb-6 opacity-20">
                    <i class="fa-solid fa-box-open text-8xl text-zinc-300"></i>
                </div>
                <h3 class="text-2xl font-black uppercase italic tracking-tighter">No Orders Yet</h3>
                <p class="text-zinc-400 text-sm mt-2">Don't worry, your customers will find you soon!</p>
            </div>
        <?php endif; ?>
    </div>

    <?php include '../includes/footer_penjual.php'; ?>

</body>
</html>