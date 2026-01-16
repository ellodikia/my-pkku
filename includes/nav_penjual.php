<?php
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Penjual';
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-pink-100" x-data="{ open: false }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      
      <div class="flex">
        <div class="flex-shrink-0 flex items-center">
          <div class="bg-pink-500 p-1.5 rounded-lg mr-2 shadow-sm shadow-pink-200">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
          </div>
          <span class="text-xl font-black tracking-tighter text-black uppercase">MY<span class="text-pink-500">PKKU.</span></span>
        </div>
        
        <div class="hidden sm:ml-10 sm:flex sm:space-x-1 sm:items-center">
          <?php
          $menu = [
            'index.php' => 'Dashboard',
            'produk.php' => 'Produk Saya',
            'pesanan.php' => 'Pesanan',
            'laporan.php' => 'Laporan'
          ];

          foreach ($menu as $url => $label):
            $isActive = ($current_page == $url);
          ?>
            <a href="<?= $url ?>" 
               class="<?= $isActive ? 'bg-pink-500 text-white shadow-md shadow-pink-100' : 'text-gray-600 hover:bg-pink-50 hover:text-pink-500' ?> px-4 py-2 rounded-full text-sm font-bold transition-all duration-300">
               <?= $label ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="hidden sm:ml-6 sm:flex sm:items-center">
        <div class="flex items-center space-x-6 border-l border-gray-100 pl-6">
          <div class="text-right">
            <p class="text-[10px] text-pink-400 font-bold uppercase tracking-widest leading-none">Seller Mode</p>
            <p class="text-sm font-black text-black"><?= htmlspecialchars($username) ?></p>
          </div>
          <a href="../logout.php" class="inline-flex items-center justify-center px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest text-white bg-black hover:bg-pink-600 shadow-lg transition-all duration-300 active:scale-95">
            Logout
          </a>
        </div>
      </div>

      <div class="-mr-2 flex items-center sm:hidden">
        <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2.5 rounded-full text-pink-500 hover:bg-pink-50 focus:outline-none transition-all duration-200">
          <svg :class="{'hidden': open, 'block': !open }" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg :class="{'block': open, 'hidden': !open }" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <div 
    x-show="open" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-4"
    class="sm:hidden bg-white/95 border-t border-pink-50"
  >
    <div class="pt-2 pb-6 space-y-1 px-4">
      <?php foreach ($menu as $url => $label): ?>
        <a href="<?= $url ?>" 
           class="block px-4 py-3 rounded-2xl text-base font-bold <?= $current_page == $url ? 'bg-pink-500 text-white' : 'text-gray-700 hover:bg-pink-50 hover:text-pink-500' ?>">
           <?= $label ?>
        </a>
      <?php endforeach; ?>
      
      <div class="pt-4 mt-4 border-t border-pink-100 bg-pink-50/50 rounded-3xl p-4">
        <div class="mb-4">
          <p class="text-[10px] text-pink-400 font-bold uppercase tracking-widest">Logged in as</p>
          <p class="text-md font-black text-black"><?= htmlspecialchars($username) ?></p>
        </div>
        <a href="../logout.php" class="block w-full text-center py-3 rounded-2xl text-sm font-black uppercase tracking-widest bg-black text-white hover:bg-pink-600 transition-colors">
          Logout
        </a>
      </div>
    </div>
  </div>
</nav>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>