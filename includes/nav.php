<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center h-20 md:h-24">
            
            <a href="index.php" class="font-black text-2xl md:text-3xl tracking-tighter uppercase italic group shrink-0">
                MY<span class="text-pink-500 group-hover:text-black transition-colors duration-500">PKKU.</span>
            </a>

            <div class="hidden md:flex gap-10 items-center">
                <a href="index.php" class="group flex flex-col items-center">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-pink-500' : 'text-zinc-400 group-hover:text-pink-500' ?> transition-colors">Home</span>
                    <span class="h-1 w-1 rounded-full bg-pink-500 mt-1 transition-all <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'opacity-100' : 'opacity-0' ?>"></span>
                </a>
                <a href="produk.php" class="group flex flex-col items-center">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] <?= basename($_SERVER['PHP_SELF']) == 'produk.php' ? 'text-pink-500' : 'text-zinc-400 group-hover:text-pink-500' ?> transition-colors">Produk</span>
                    <span class="h-1 w-1 rounded-full bg-pink-500 mt-1 transition-all <?= basename($_SERVER['PHP_SELF']) == 'produk.php' ? 'opacity-100' : 'opacity-0' ?>"></span>
                </a>
                <a href="cart.php" class="relative group p-2">
                    <i class="fa-solid fa-bag-shopping text-lg <?= basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'text-pink-500' : 'text-zinc-400 group-hover:text-pink-500' ?> transition-all"></i>
                    <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <span class="absolute top-0 right-0 bg-black text-white text-[8px] font-black w-4 h-4 rounded-full flex items-center justify-center ring-2 ring-white">
                            <?= array_sum($_SESSION['cart']) ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>

            <div class="flex items-center gap-3 md:gap-6">
                <div class="h-8 w-[1px] bg-gray-100 hidden sm:block"></div>
                
                <?php if(isset($_SESSION['login'])): ?>
                    <div class="flex items-center gap-4">
                        <span class="hidden lg:block text-[9px] font-bold text-gray-400 uppercase tracking-widest italic">Welcome, <?= htmlspecialchars($_SESSION['username']) ?></span>
                        <a href="logout.php" class="bg-black text-white px-5 md:px-8 py-2.5 md:py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-pink-500 transition-all duration-500 shadow-lg shadow-gray-200">
                            Logout
                        </a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="text-[10px] font-black uppercase tracking-widest text-zinc-400 hover:text-pink-500 transition-colors mr-2">Sign In</a>
                <?php endif; ?>

                <button id="mobile-menu-button" class="md:hidden text-zinc-800 p-2">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 animate-fade-in">
        <div class="px-6 py-8 flex flex-col gap-6">
            <a href="index.php" class="text-xs font-black uppercase tracking-widest <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-pink-500' : 'text-zinc-500' ?>">Home</a>
            <a href="produk.php" class="text-xs font-black uppercase tracking-widest <?= basename($_SERVER['PHP_SELF']) == 'produk.php' ? 'text-pink-500' : 'text-zinc-500' ?>">Produk</a>
            <a href="cart.php" class="flex items-center gap-2 text-xs font-black uppercase tracking-widest <?= basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'text-pink-500' : 'text-zinc-500' ?>">
                Keranjang 
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <span class="bg-pink-500 text-white text-[9px] px-2 py-0.5 rounded-full"><?= array_sum($_SESSION['cart']) ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</nav>

<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        const icon = btn.querySelector('i');
        if(menu.classList.contains('hidden')) {
            icon.classList.replace('fa-xmark', 'fa-bars-staggered');
        } else {
            icon.classList.replace('fa-bars-staggered', 'fa-xmark');
        }
    });
</script>