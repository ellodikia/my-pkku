<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'penjual') {
    header("Location: ../login.php");
    exit;
}

$id_penjual = $_SESSION['id'];

if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    $ambil = mysqli_query($koneksi, "SELECT gambar FROM produk WHERE id = '$id_hapus' AND id_penjual = '$id_penjual'");
    $data = mysqli_fetch_assoc($ambil);
    
    if ($data['gambar'] && file_exists("../assets/img/" . $data['gambar'])) {
        unlink("../assets/img/" . $data['gambar']);
    }

    mysqli_query($koneksi, "DELETE FROM produk WHERE id = '$id_hapus' AND id_penjual = '$id_penjual'");
    header("Location: produk.php");
}

$query = "SELECT * FROM produk WHERE id_penjual = '$id_penjual' ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk Saya | MarketPink</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body class="bg-gray-50/50">

    <?php include '../includes/nav_penjual.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-black text-black tracking-tighter uppercase">My <span class="text-pink-500">Inventory</span></h1>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Total: <?= mysqli_num_rows($result) ?> Produk</p>
            </div>
            <a href="tambah_produk.php" class="inline-flex items-center justify-center bg-pink-500 hover:bg-black text-white px-6 py-3 rounded-full font-black uppercase tracking-widest text-[10px] shadow-lg shadow-pink-100 transition-all duration-300 active:scale-95">
                + Add Product
            </a>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="group bg-white rounded-[2rem] border border-pink-50 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden flex flex-col">
                        
                        <div class="relative aspect-square overflow-hidden bg-gray-50">
                            <?php if ($row['gambar']): ?>
                                <img id="prod-img-<?= $row['id'] ?>" src="../assets/img/<?= $row['gambar'] ?>" alt="<?= $row['nama_produk'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-pink-100">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-3">
                                <div class="flex gap-2">
                                    <button onclick="shareToStory('<?= addslashes($row['nama_produk']) ?>', '<?= $row['harga'] ?>', 'prod-img-<?= $row['id'] ?>')" 
                                            class="bg-pink-500 p-3 rounded-full text-white hover:bg-white hover:text-pink-500 transition-colors" title="Share ke IG Story">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 100-2.684 3 3 0 000 2.684zm0 12.684a3 3 0 100-2.684 3 3 0 000 2.684z" />
                                        </svg>
                                    </button>

                                    <a href="edit_produk.php?id=<?= $row['id'] ?>" class="bg-white p-3 rounded-full text-black hover:bg-blue-500 hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="produk.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus produk?')" class="bg-white p-3 rounded-full text-black hover:bg-red-600 hover:text-white transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 text-center">
                            <h3 class="font-black text-black text-sm uppercase tracking-tight truncate"><?= $row['nama_produk'] ?></h3>
                            <p class="text-pink-500 font-black text-sm mt-1">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="story-template" style="position: absolute; left: -9999px; top: 0;">
        <div id="capture-area" style="width: 1080px; height: 1920px;" class="bg-white p-20 flex flex-col items-center justify-between font-sans">
            <div class="text-center">
                <h2 style="font-size: 80px;" class="font-black tracking-tighter uppercase text-black italic">Market<span class="text-pink-500">Pink.</span></h2>
                <div style="height: 15px; width: 300px;" class="bg-pink-500 mx-auto mt-4"></div>
            </div>

            <div class="w-full flex gap-10 h-[1100px]">
                <div style="flex: 1.5; border-radius: 80px;" class="overflow-hidden bg-gray-100 shadow-2xl">
                    <img id="story-img-preview" src="" style="width: 100%; height: 100%; object-cover: cover;">
                </div>
                <div style="flex: 1;" class="flex flex-col gap-10">
                    <div style="border-radius: 80px;" class="bg-pink-500 flex-1 flex items-center justify-center p-12 text-white shadow-xl">
                        <h3 id="story-name-preview" style="font-size: 70px;" class="font-black uppercase leading-tight tracking-tighter">PRODUCT NAME</h3>
                    </div>
                    <div style="border-radius: 80px;" class="border-[10px] border-black flex-1 flex flex-col items-center justify-center shadow-xl">
                        <p style="font-size: 40px;" class="font-bold text-gray-400 uppercase tracking-widest">Price</p>
                        <p id="story-price-preview" style="font-size: 80px;" class="font-black text-black">Rp 0</p>
                    </div>
                </div>
            </div>

            <div class="text-center w-full">
                <div style="border-radius: 100px;" class="bg-black text-white py-10 px-20 inline-block shadow-2xl">
                    <p style="font-size: 40px;" class="font-black tracking-[0.3em] uppercase">Shop Now at MarketPink</p>
                </div>
            </div>
        </div>
    </div>

    <script>
async function shareToStory(nama, harga, imgId) {
    const btn = event.currentTarget;
    const originalContent = btn.innerHTML;
    
    btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

    document.getElementById('story-name-preview').innerText = nama;
    document.getElementById('story-price-preview').innerText = "Rp" + parseInt(harga).toLocaleString('id-ID');
    
    const sourceImg = document.getElementById(imgId);
    const imgPrev = document.getElementById('story-img-preview');
    imgPrev.src = sourceImg.src;

    setTimeout(() => {
        const captureArea = document.getElementById('capture-area');
        
        html2canvas(captureArea, {
            scale: 2,
            useCORS: true, 
            allowTaint: false,
            backgroundColor: "#ffffff"
        }).then(async (canvas) => {
            const imageData = canvas.toDataURL("image/png");
            
            try {
                const response = await fetch(imageData);
                const blob = await response.blob();
                const file = new File([blob], 'marketpink-share.png', { type: 'image/png' });

                if (navigator.canShare && navigator.canShare({ files: [file] })) {
                    await navigator.share({
                        files: [file],
                        title: 'MarketPink Collections',
                        text: `Cek ${nama} di toko kami!`,
                    });
                } else {
                    const link = document.createElement('a');
                    link.download = nama + '-story.png';
                    link.href = imageData;
                    link.click();
                    alert('Browser tidak mendukung share langsung. Gambar telah di-download, silakan upload manual ke IG!');
                }
            } catch (err) {
                console.error("Error sharing:", err);
                alert("Gagal memproses gambar.");
            } finally {
                btn.innerHTML = originalContent; 
            }
        });
    }, 1000); 
}
    </script>
    <?php include '../includes/footer_penjual.php'; ?>

</body>
</html>