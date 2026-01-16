<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'penjual') {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Penjual | MarketPink</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-white overflow-x-hidden">

    <?php include '../includes/nav_penjual.php'; ?>

    <main class="relative isolate">
        <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
            <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" 
                 class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff1493] to-[#ff80b5] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
        </div>

        <div class="mx-auto max-w-3xl py-24 sm:py-32 lg:py-40 px-6">
            <div class="hidden sm:mb-10 sm:flex sm:justify-center">
                <div class="relative rounded-full px-4 py-1.5 text-xs font-black uppercase tracking-widest leading-6 text-pink-600 ring-1 ring-pink-200 bg-pink-50/50 backdrop-blur-sm shadow-sm">
                    Welcome back, <span class="text-black"><?= htmlspecialchars($username); ?>!</span> ✨
                </div>
            </div>
            
            <div class="text-center">
                <h1 class="text-5xl font-black tracking-tighter text-black sm:text-7xl uppercase">
                    Level Up Your <span class="text-pink-500">Business</span>
                </h1>
                <p class="mt-8 text-lg leading-8 text-gray-500 font-medium max-w-2xl mx-auto">
                    Pantau stok produk, kelola pesanan masuk, dan kendalikan bisnis Anda dengan gaya yang lebih berani dan elegan.
                </p>
                
                <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="tambah_produk.php" class="w-full sm:w-auto rounded-full bg-pink-500 px-10 py-4 text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-pink-200 hover:bg-pink-600 hover:-translate-y-1 transition-all duration-300">
                        Tambah Produk
                    </a>
                    <a href="pesanan.php" class="w-full sm:w-auto rounded-full bg-black px-10 py-4 text-sm font-black uppercase tracking-widest text-white shadow-xl shadow-gray-200 hover:bg-gray-800 hover:-translate-y-1 transition-all duration-300">
                        Lihat Pesanan
                    </a>
                </div>
            </div>
        </div>

        <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
            <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" 
                 class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#000000] opacity-10 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"></div>
        </div>
    </main>

    <?php include '../includes/footer_penjual.php'; ?>

</body>
</html>