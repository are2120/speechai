<x-app-layout>
    <x-slot name="header">
        Belajar Bahasa Isyarat
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Hero Banner -->
        <div class="relative bg-gradient-to-br from-blue-500 via-purple-600 to-indigo-700 rounded-2xl p-7 overflow-hidden shadow-xl">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-white rounded-full"></div>
                <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-white rounded-full"></div>
            </div>
            <div class="relative flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-white">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-3xl">🤟</span>
                        <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wide">Pusat Pembelajaran</span>
                    </div>
                    <h2 class="text-2xl font-bold mb-1">Belajar Bahasa Isyarat Indonesia</h2>
                    <p class="text-white/80 text-sm max-w-lg">Pelajari BISINDO dan SIBI secara interaktif. Panduan gestur lengkap, tips praktis, dan latihan kamera real-time.</p>
                </div>
                <div class="flex flex-col gap-2 flex-shrink-0 text-center">
                    <div class="px-6 py-3 bg-white/20 backdrop-blur-sm rounded-xl text-white font-semibold text-sm">
                        ✅ Modul Dasar GRATIS
                    </div>
                    <p class="text-white/60 text-xs">80+ gestur • Panduan langkah demi langkah</p>
                </div>
            </div>
        </div>

        <!-- Learning Module Grid (FREE) -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">📖 Modul Pembelajaran</h3>
                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 text-xs font-bold rounded-full">Gratis</span>
            </div>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach([
                    ['🔤','Alfabet A–Z','Pelajari 26 huruf SIBI dengan posisi jari yang benar','26 gestur','huruf','bg-blue-500'],
                    ['🔢','Angka 0–9','Kuasai cara menyebut angka dalam bahasa isyarat','10 gestur','angka','bg-green-500'],
                    ['👋','Sapaan & Ekspresi','Halo, Terima Kasih, Maaf, dan frasa sehari-hari','15 gestur','sapaan','bg-purple-500'],
                    ['😊','Emosi & Perasaan','Ungkapkan senang, sedih, marah, takut dengan gestur','12 gestur','emosi','bg-yellow-500'],
                    ['🏃','Kata Kerja Dasar','Makan, minum, tidur, belajar, bekerja, pergi','12 gestur','aktivitas','bg-red-500'],
                    ['💬','Kata Tanya','Apa, Siapa, Kapan, Dimana, Mengapa, Bagaimana','8 gestur','tanya','bg-indigo-500'],
                ] as $mod)
                <button onclick="openModule('{{ $mod[4] }}')" class="group text-left p-5 rounded-xl border-2 border-gray-100 dark:border-gray-700 hover:border-{{ explode('-',$mod[5])[0] }}-400 hover:shadow-lg transition-all">
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 {{ $mod[5] }} rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                            <span class="text-2xl">{{ $mod[0] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm mb-1">{{ $mod[1] }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">{{ $mod[2] }}</p>
                            <span class="inline-block mt-2 px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs rounded-full">{{ $mod[3] }}</span>
                        </div>
                    </div>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Interactive Gesture Guide -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">🗂️ Panduan Gestur Lengkap</h3>
                <div class="flex items-center gap-2">
                    <input type="text" id="searchInput" placeholder="Cari gestur..." class="px-3 py-1.5 text-sm border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-400 w-40">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="flex gap-2 flex-wrap mb-5">
                <button class="filter-btn active-filter px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-500 text-white" data-cat="all">Semua</button>
                <button class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300" data-cat="sapaan">Sapaan</button>
                <button class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300" data-cat="angka">Angka</button>
                <button class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300" data-cat="emosi">Emosi</button>
                <button class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300" data-cat="aktivitas">Aktivitas</button>
                <button class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300" data-cat="kata">Kata Dasar</button>
            </div>

            <!-- Gesture Cards Grid -->
            <div id="gestureGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            </div>
        </div>

        <!-- Gesture Detail Modal -->
        <div id="gestureModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div id="modalHeader" class="bg-gradient-to-br from-blue-500 to-purple-600 p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span id="modalEmoji" class="text-5xl"></span>
                        <button onclick="closeModal()" class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <h3 id="modalTitle" class="text-2xl font-bold"></h3>
                    <p id="modalCategory" class="text-white/70 text-sm mt-1"></p>
                    <div class="flex items-center gap-2 mt-2">
                        <span id="modalDifficulty" class="px-2 py-0.5 bg-white/20 rounded-full text-xs font-semibold"></span>
                        <span id="modalStandard" class="px-2 py-0.5 bg-white/20 rounded-full text-xs font-semibold"></span>
                    </div>
                </div>
                <!-- Modal Body -->
                <div class="p-6 space-y-5">
                    <!-- Description -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">📝 Deskripsi</h4>
                        <p id="modalDesc" class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed"></p>
                    </div>
                    <!-- Steps -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-3">👆 Langkah-Langkah</h4>
                        <ol id="modalSteps" class="space-y-2"></ol>
                    </div>
                    <!-- Tips -->
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4">
                        <h4 class="text-sm font-bold text-green-700 dark:text-green-400 mb-2">💡 Tips</h4>
                        <ul id="modalTips" class="space-y-1"></ul>
                    </div>
                    <!-- Common Mistakes -->
                    <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4">
                        <h4 class="text-sm font-bold text-red-700 dark:text-red-400 mb-2">⚠️ Kesalahan Umum</h4>
                        <ul id="modalMistakes" class="space-y-1"></ul>
                    </div>
                    <!-- Practice Link -->
                    <a href="{{ route('sign-language.index') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                        📸 Latihan dengan Kamera
                    </a>
                </div>
            </div>
        </div>

        <!-- Module Detail Modal -->
        <div id="moduleModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 id="moduleTitle" class="text-lg font-bold text-gray-900 dark:text-white"></h3>
                    <button onclick="closeModuleModal()" class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center hover:bg-gray-200 transition-all">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div id="moduleContent" class="p-6"></div>
            </div>
        </div>

        <!-- Premium Modules -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border border-amber-200 dark:border-amber-800 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Modul Lanjutan — Premium</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Percakapan, frasa kompleks, latihan AI, dan sertifikasi</p>
                </div>
                <button onclick="document.getElementById('premiumModal').classList.remove('hidden')" class="ml-auto px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl text-sm hover:shadow-lg transition-all">
                    Upgrade →
                </button>
            </div>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach([
                    ['💬','Percakapan Dasar','Perkenalan, nama, usia, asal, hobi'],
                    ['🏡','Aktivitas Sehari-hari','Kalimat lengkap tentang rutinitas'],
                    ['🎭','Situasi Umum','Rumah sakit, transportasi, belanja'],
                    ['🤝','Percakapan Lanjutan','Dialog panjang & konteks sosial'],
                    ['🧠','AI Coach','Latihan real-time dengan skor kesesuaian'],
                    ['🏆','Sertifikasi','Sertifikat resmi penyelesaian kursus'],
                ] as $m)
                <div class="bg-white/60 dark:bg-gray-800/60 rounded-xl p-4 flex items-center gap-3 opacity-75">
                    <span class="text-xl">{{ $m[0] }}</span>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $m[1] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $m[2] }}</p>
                    </div>
                    <span class="ml-auto text-amber-500">🔒</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Premium Modal -->
    <div id="premiumModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md w-full shadow-2xl">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aktifkan Premium</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Daftarkan email untuk mendapatkan notifikasi dan akses awal eksklusif saat Premium diluncurkan!</p>
                <div class="flex gap-3">
                    <input type="email" placeholder="email@anda.com" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 rounded-xl text-sm dark:text-white focus:ring-2 focus:ring-amber-400 outline-none">
                    <button class="px-5 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all text-sm">Daftar</button>
                </div>
                <button onclick="document.getElementById('premiumModal').classList.add('hidden')" class="mt-4 text-sm text-gray-400 hover:text-gray-600 transition-colors">Tutup</button>
            </div>
        </div>
    </div>

    <script>
    // ─── Full Gesture Database ───────────────────────────────────────────────────
    const GESTURES = [
        // SAPAAN
        { id:'halo',      emoji:'👋', name:'Halo',           cat:'sapaan',    diff:'Mudah',   std:'BISINDO',
          desc:'Gestur sapaan universal yang dilakukan dengan mengangkat tangan dan mengibas-ibaskannya ke arah lawan bicara.',
          steps:['Angkat tangan kanan setinggi bahu.','Buka telapak tangan dengan seluruh jari terbuka.','Hadapkan telapak tangan ke arah lawan bicara.','Gerakkan tangan perlahan ke kiri dan kanan sebanyak 2–3 kali.'],
          tips:['Pastikan seluruh telapak dan jari terlihat kamera.','Gerakan harus luwes dan tidak kaku.','Senyum saat melakukan gestur ini untuk kesan ramah.'],
          mistakes:['Tangan terlalu rendah sehingga tidak terlihat jelas.','Gerakan terlalu cepat sehingga tidak terdeteksi.','Jari tidak terbuka sempurna.'] },
        { id:'terima',    emoji:'🙏', name:'Terima Kasih',   cat:'sapaan',    diff:'Mudah',   std:'BISINDO',
          desc:'Gestur rasa syukur dan terima kasih dengan mengatupkan kedua telapak tangan.',
          steps:['Satukan kedua telapak tangan seperti posisi berdoa.','Posisikan tangan di depan dada.','Anggukkan kepala sedikit sambil melakukan gestur ini.'],
          tips:['Kedua telapak harus benar-benar menempel satu sama lain.','Posisi tangan di depan dada, bukan di depan wajah.'],
          mistakes:['Hanya satu tangan yang digunakan.','Tangan terlalu jauh dari dada.'] },
        { id:'ya',        emoji:'👍', name:'Ya / Baik',      cat:'sapaan',    diff:'Mudah',   std:'BISINDO',
          desc:'Jempol ke atas berarti persetujuan, konfirmasi, atau sesuatu yang baik.',
          steps:['Kepalkan tangan kanan.','Acungkan ibu jari ke atas.','Pastikan ibu jari menunjuk vertikal ke atas.'],
          tips:['Jaga semua jari lain tetap terkepal rapat.','Tahan posisi selama 1–2 detik.'],
          mistakes:['Ibu jari tidak cukup tegak ke atas.','Jari lain tidak terkepal sempurna.'] },
        { id:'tidak',     emoji:'👎', name:'Tidak',          cat:'sapaan',    diff:'Mudah',   std:'BISINDO',
          desc:'Jempol ke bawah berarti penolakan atau ketidaksetujuan.',
          steps:['Kepalkan tangan.','Arahkan ibu jari ke bawah.','Tahan posisi ini dengan tegas.'],
          tips:['Pastikan ibu jari mengarah jelas ke bawah.','Ekspresikan dengan ekspresi wajah yang sesuai.'],
          mistakes:['Posisi ibu jari tidak cukup ke bawah.'] },
        { id:'stop',      emoji:'✋', name:'Stop / Tunggu',  cat:'sapaan',    diff:'Mudah',   std:'BISINDO',
          desc:'Telapak tangan terbuka menghadap ke depan berarti berhenti atau tunggu.',
          steps:['Angkat tangan kanan setinggi bahu.','Buka semua jari selebar mungkin.','Hadapkan telapak tangan ke depan (ke arah lawan bicara).','Tahan posisi ini.'],
          tips:['Semua jari harus terbuka dan lurus.','Ibu jari juga harus terbuka ke samping.'],
          mistakes:['Jari tidak sepenuhnya terbuka.','Telapak tidak menghadap ke depan.'] },
        { id:'ok',        emoji:'👌', name:'OK / Setuju',    cat:'sapaan',    diff:'Sedang',  std:'BISINDO',
          desc:'Ibu jari dan telunjuk membentuk lingkaran, ketiga jari lainnya tegak.',
          steps:['Satukan ujung ibu jari dengan ujung telunjuk membentuk lingkaran.','Tegakkan jari tengah, jari manis, dan kelingking ke atas.','Posisikan tangan setinggi dada.'],
          tips:['Lingkaran ibu jari-telunjuk harus sempurna, bukan oval.','Ketiga jari tegak harus benar-benar lurus.'],
          mistakes:['Lingkaran tidak sempurna.','Jari tengah, manis, kelingking tidak cukup tegak.'] },
        { id:'maaf',      emoji:'🤲', name:'Maaf / Mohon',   cat:'sapaan',    diff:'Mudah',   std:'BISINDO',
          desc:'Kedua telapak tangan terbuka menghadap ke atas sebagai tanda permohonan atau permintaan maaf.',
          steps:['Buka kedua tangan dengan telapak menghadap ke atas.','Posisikan keduanya berdampingan di depan tubuh.','Anggukkan kepala sebagai pelengkap gestur.'],
          tips:['Ekspresi wajah yang tulus sangat penting.','Kedua telapak harus sejajar dan terbuka rata.'],
          mistakes:['Hanya satu tangan yang digunakan.','Telapak menghadap ke bawah bukan ke atas.'] },
        // ANGKA
        { id:'n0',  emoji:'✊', name:'Nol (0)',     cat:'angka', diff:'Mudah',  std:'SIBI',
          desc:'Kepalan tangan penuh melambangkan angka nol.',
          steps:['Kepalkan semua jari ke dalam telapak.','Ibu jari menutup di depan jari-jari.','Posisikan tangan setinggi dada.'],
          tips:['Kepalan harus rapat, bukan longgar.'], mistakes:['Ibu jari tidak menutup di depan.'] },
        { id:'n1',  emoji:'☝️', name:'Satu (1)',    cat:'angka', diff:'Mudah',  std:'SIBI',
          desc:'Hanya telunjuk yang berdiri, jari lain terkepal.',
          steps:['Kepalkan semua jari kecuali telunjuk.','Tegakkan telunjuk lurus ke atas.','Ibu jari menempel di samping jari tengah.'],
          tips:['Telunjuk harus benar-benar lurus.'], mistakes:['Jari lain tidak terkepal sempurna.'] },
        { id:'n2',  emoji:'✌️', name:'Dua (2)',     cat:'angka', diff:'Mudah',  std:'SIBI',
          desc:'Telunjuk dan jari tengah tegak berdampingan.',
          steps:['Kepalkan jari manis dan kelingking.','Tegakkan telunjuk dan jari tengah.','Buka sedikit antara telunjuk dan jari tengah.'],
          tips:['Pisahkan sedikit antara dua jari untuk kejelasan.'], mistakes:['Kedua jari terlalu rapat sehingga mirip gestur lain.'] },
        { id:'n3',  emoji:'🤟', name:'Tiga (3)',    cat:'angka', diff:'Sedang', std:'SIBI',
          desc:'Telunjuk, jari tengah, dan jari manis tegak.',
          steps:['Kepalkan kelingking.','Tegakkan telunjuk, jari tengah, dan jari manis.','Ibu jari menempel di telapak.'],
          tips:['Pisahkan tiga jari agar terlihat jelas.'], mistakes:['Ibu jari ikut terangkat sehingga mirip tanda lain.'] },
        { id:'n4',  emoji:'🖖', name:'Empat (4)',   cat:'angka', diff:'Sedang', std:'SIBI',
          desc:'Empat jari tegak tanpa ibu jari.',
          steps:['Kepalkan ibu jari ke telapak.','Tegakkan telunjuk, jari tengah, jari manis, dan kelingking.','Sedikit pisahkan jari-jari.'],
          tips:['Ibu jari harus benar-benar tertutup di telapak.'], mistakes:['Ibu jari ikut naik.'] },
        { id:'n5',  emoji:'✋', name:'Lima (5)',    cat:'angka', diff:'Mudah',  std:'SIBI',
          desc:'Semua jari terbuka lebar termasuk ibu jari.',
          steps:['Buka semua lima jari selebar mungkin.','Ibu jari ikut terbuka ke samping.','Hadapkan telapak ke depan atau ke atas.'],
          tips:['Pastikan semua jari benar-benar terbuka.'], mistakes:['Salah satu jari tidak terbuka penuh.'] },
        // EMOSI
        { id:'senang',    emoji:'😊', name:'Senang',         cat:'emosi',     diff:'Sedang',  std:'BISINDO',
          desc:'Gestur yang menggambarkan kegembiraan dan kebahagiaan.',
          steps:['Angkat kedua sudut mulut (senyum).','Letakkan tangan di pipi atau di dada.','Gerakan tangan ke atas sedikit sebagai ekspresi gembira.'],
          tips:['Ekspresi wajah adalah bagian penting dari gestur emosi.'], mistakes:['Ekspresi wajah datar sehingga gestur tidak tersampaikan.'] },
        { id:'sedih',     emoji:'😢', name:'Sedih',          cat:'emosi',     diff:'Sedang',  std:'BISINDO',
          desc:'Gestur yang menggambarkan kesedihan, biasanya dengan gerakan menurun.',
          steps:['Turunkan sudut mulut.','Gerakkan jari dari sudut mata ke bawah seperti menyeka air mata.','Kepala sedikit menunduk.'],
          tips:['Kombinasikan dengan ekspresi wajah yang sesuai.'], mistakes:['Gestur tanpa ekspresi wajah terkesan ambigu.'] },
        { id:'marah',     emoji:'😡', name:'Marah',          cat:'emosi',     diff:'Sedang',  std:'BISINDO',
          desc:'Gestur yang menggambarkan kemarahan atau kejengkelan.',
          steps:['Kepalkan tangan dengan tegas.','Posisikan kepalan di depan dada atau sedikit ke depan.','Ekspresikan dengan wajah tegang dan alis berkerut.'],
          tips:['Gerakan harus tegas dan kuat.'], mistakes:['Kepalan terlalu longgar.'] },
        { id:'takut',     emoji:'😨', name:'Takut',          cat:'emosi',     diff:'Sedang',  std:'BISINDO',
          desc:'Gestur ketakutan biasanya melibatkan tangan gemetar di depan dada.',
          steps:['Angkat kedua tangan setinggi dada.','Buka telapak menghadap ke depan.','Gerakkan tangan sedikit gemetar.'],
          tips:['Ekspresi mata melebar membantu memperjelas gestur.'], mistakes:['Gerakan terlalu kaku tanpa ekspresi.'] },
        // AKTIVITAS
        { id:'makan',     emoji:'🍽️', name:'Makan',          cat:'aktivitas', diff:'Mudah',   std:'BISINDO',
          desc:'Gestur menggambarkan tindakan memasukkan makanan ke mulut.',
          steps:['Satukan ujung jari-jari tangan kanan.','Bawa tangan ke arah mulut berulang kali.','Gerakan seperti memasukkan sesuatu ke mulut.'],
          tips:['Lakukan gerakan 2–3 kali berulang untuk kejelasan.'], mistakes:['Tangan tidak mencapai area mulut.'] },
        { id:'minum',     emoji:'💧', name:'Minum',          cat:'aktivitas', diff:'Mudah',   std:'BISINDO',
          desc:'Gestur seperti memegang gelas dan menuangkan ke mulut.',
          steps:['Kepalkan tangan seperti memegang gelas.','Angkat tangan ke arah mulut.','Miringkan sedikit seperti menuangkan minuman.'],
          tips:['Ikuti gerakan pergelangan tangan saat menuang.'], mistakes:['Gerakan terlalu kaku dan tidak alami.'] },
        { id:'tidur',     emoji:'😴', name:'Tidur',          cat:'aktivitas', diff:'Mudah',   std:'BISINDO',
          desc:'Gestur menggambarkan posisi tidur dengan tangan di pipi.',
          steps:['Tempelkan telapak tangan kanan di pipi.','Miringkan kepala ke arah tangan.','Tutup mata sebentar sebagai pelengkap.'],
          tips:['Ekspresi mengantuk melengkapi gestur ini.'], mistakes:['Tangan tidak benar-benar menempel di pipi.'] },
        { id:'belajar',   emoji:'📚', name:'Belajar',        cat:'aktivitas', diff:'Sedang',  std:'BISINDO',
          desc:'Gestur menggambarkan tindakan membuka buku dan membaca.',
          steps:['Posisikan kedua tangan di depan seperti memegang buku.','Buka kedua telapak ke samping seperti membuka halaman buku.','Gerakkan mata seolah membaca.'],
          tips:['Gerakan membuka buku harus jelas dan terkontrol.'], mistakes:['Gerakan terlalu cepat sehingga tidak terlihat.'] },
        { id:'pergi',     emoji:'🚶', name:'Pergi',          cat:'aktivitas', diff:'Mudah',   std:'BISINDO',
          desc:'Gestur menunjukkan tindakan berangkat atau berpindah tempat.',
          steps:['Angkat tangan dan arahkan telunjuk ke depan.','Gerakkan tangan sedikit ke depan.','Dapat dilengkapi dengan gerakan kaki.'],
          tips:['Arah telunjuk harus jelas menunjuk ke depan.'], mistakes:['Arah telunjuk tidak jelas.'] },
        // KATA DASAR
        { id:'saya',      emoji:'👤', name:'Saya',           cat:'kata',      diff:'Mudah',   std:'BISINDO',
          desc:'Menunjuk ke diri sendiri dengan telunjuk.',
          steps:['Angkat tangan kanan.','Arahkan telunjuk ke dada sendiri.','Sentuh atau hampiri dada dengan telunjuk.'],
          tips:['Pastikan arah telunjuk jelas menunjuk ke diri sendiri.'], mistakes:['Jari tidak cukup jelas menunjuk ke diri sendiri.'] },
        { id:'kamu',      emoji:'👥', name:'Kamu',           cat:'kata',      diff:'Mudah',   std:'BISINDO',
          desc:'Menunjuk ke lawan bicara dengan telunjuk.',
          steps:['Angkat tangan kanan.','Arahkan telunjuk ke arah lawan bicara.','Gerakkan telunjuk sedikit ke arah orang tersebut.'],
          tips:['Kontak mata dengan lawan bicara memperjelas maksud.'], mistakes:['Arah tidak jelas mengarah ke lawan bicara.'] },
        { id:'rumah',     emoji:'🏠', name:'Rumah',          cat:'kata',      diff:'Sedang',  std:'BISINDO',
          desc:'Kedua tangan membentuk siluet atap rumah di atas kepala.',
          steps:['Angkat kedua tangan di atas kepala.','Satukan ujung jari kedua tangan membentuk segitiga (atap).','Kemudian turunkan kedua tangan lurus ke bawah (dinding).'],
          tips:['Bentuk segitiga atap harus jelas sebelum menurunkan tangan.'], mistakes:['Segitiga tidak terbentuk dengan baik.'] },
        { id:'air',       emoji:'💧', name:'Air',            cat:'kata',      diff:'Mudah',   std:'BISINDO',
          desc:'Gestur tangan seperti menuangkan cairan.',
          steps:['Tegakkan tangan kanan dengan jari-jari terbuka.','Gerakkan tangan seolah menuangkan cairan dari atas.','Ulangi gerakan 2–3 kali.'],
          tips:['Gerakan harus mengalir dan tidak terputus.'], mistakes:['Gerakan terlalu kaku.'] },
    ];

    // ─── Module Content ──────────────────────────────────────────────────────────
    const MODULE_CONTENT = {
        huruf: {
            title: '🔤 Alfabet A–Z (SIBI)',
            items: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('').map(l => ({
                emoji: l, name: `Huruf ${l}`, desc: `Posisi jari tangan untuk huruf ${l} dalam Sistem Isyarat Bahasa Indonesia (SIBI).`
            }))
        },
        angka: {
            title: '🔢 Angka 0–9',
            items: ['✊0','☝️1','✌️2','🤟3','🖖4','✋5','🤙6','🤞7','🤘8','👌9'].map(s => ({
                emoji: s[0], name: `Angka ${s.slice(-1)}`, desc: `Cara membentuk angka ${s.slice(-1)} dalam bahasa isyarat.`
            }))
        },
        sapaan: { title: '👋 Sapaan & Ekspresi', items: GESTURES.filter(g => g.cat === 'sapaan') },
        emosi:  { title: '😊 Emosi & Perasaan',   items: GESTURES.filter(g => g.cat === 'emosi') },
        aktivitas: { title: '🏃 Kata Kerja Dasar', items: GESTURES.filter(g => g.cat === 'aktivitas') },
        tanya:  {
            title: '💬 Kata Tanya',
            items: [
                { emoji:'❓', name:'Apa',       desc:'Jari membentuk tanda tanya, digerakkan ke atas.' },
                { emoji:'👆', name:'Siapa',     desc:'Telunjuk ke atas diputar perlahan.' },
                { emoji:'⏰', name:'Kapan',     desc:'Jari menunjuk ke pergelangan tangan (jam).' },
                { emoji:'📍', name:'Dimana',    desc:'Telunjuk ke bawah digerakkan ke beberapa arah.' },
                { emoji:'🔄', name:'Mengapa',   desc:'Jari di pelipis diputar ke luar.' },
                { emoji:'🤷', name:'Bagaimana', desc:'Kedua tangan terbuka ke atas diangkat.' },
            ]
        }
    };

    // ─── Render Gesture Cards ────────────────────────────────────────────────────
    function renderGestures(list) {
        const grid = document.getElementById('gestureGrid');
        grid.innerHTML = '';
        if (list.length === 0) {
            grid.innerHTML = '<p class="col-span-full text-center text-gray-400 py-8">Gestur tidak ditemukan.</p>';
            return;
        }
        list.forEach(g => {
            const diffColor = g.diff === 'Mudah' ? 'bg-green-100 text-green-700' :
                              g.diff === 'Sedang' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700';
            const card = document.createElement('button');
            card.className = 'text-left p-3 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:shadow-md transition-all gesture-item';
            card.dataset.cat = g.cat;
            card.dataset.name = g.name.toLowerCase();
            card.innerHTML = `
                <div class="text-3xl mb-2 text-center">${g.emoji}</div>
                <p class="text-xs font-bold text-gray-800 dark:text-gray-200 text-center">${g.name}</p>
                <div class="flex justify-center mt-1">
                    <span class="text-xs px-1.5 py-0.5 rounded-full ${diffColor} font-medium">${g.diff}</span>
                </div>
            `;
            card.addEventListener('click', () => openGestureModal(g));
            grid.appendChild(card);
        });
    }

    renderGestures(GESTURES);

    // ─── Filter ──────────────────────────────────────────────────────────────────
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.className = 'filter-btn px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300';
            });
            this.className = 'filter-btn active-filter px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-500 text-white';
            const cat = this.dataset.cat;
            const query = document.getElementById('searchInput').value.toLowerCase();
            const filtered = GESTURES.filter(g =>
                (cat === 'all' || g.cat === cat) &&
                (g.name.toLowerCase().includes(query) || g.desc.toLowerCase().includes(query))
            );
            renderGestures(filtered);
        });
    });

    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const activeCat = document.querySelector('.active-filter')?.dataset.cat || 'all';
        const filtered = GESTURES.filter(g =>
            (activeCat === 'all' || g.cat === activeCat) &&
            (g.name.toLowerCase().includes(query) || g.desc.toLowerCase().includes(query))
        );
        renderGestures(filtered);
    });

    // ─── Gesture Modal ───────────────────────────────────────────────────────────
    function openGestureModal(g) {
        document.getElementById('modalEmoji').textContent    = g.emoji;
        document.getElementById('modalTitle').textContent    = g.name;
        const catLabel = {sapaan:'Sapaan',angka:'Angka',emosi:'Emosi',aktivitas:'Aktivitas',kata:'Kata Dasar'};
        document.getElementById('modalCategory').textContent = catLabel[g.cat] || g.cat;
        document.getElementById('modalDifficulty').textContent = g.diff;
        document.getElementById('modalStandard').textContent   = g.std;
        document.getElementById('modalDesc').textContent       = g.desc;

        const stepsEl = document.getElementById('modalSteps');
        stepsEl.innerHTML = g.steps.map((s, i) =>
            `<li class="flex items-start gap-3 text-sm text-gray-600 dark:text-gray-400">
                <span class="w-5 h-5 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">${i+1}</span>
                <span>${s}</span>
            </li>`
        ).join('');

        const tipsEl = document.getElementById('modalTips');
        tipsEl.innerHTML = g.tips.map(t =>
            `<li class="flex items-start gap-2 text-xs text-green-700 dark:text-green-400"><span>✓</span><span>${t}</span></li>`
        ).join('');

        const mistakesEl = document.getElementById('modalMistakes');
        mistakesEl.innerHTML = g.mistakes.map(m =>
            `<li class="flex items-start gap-2 text-xs text-red-700 dark:text-red-400"><span>✗</span><span>${m}</span></li>`
        ).join('');

        document.getElementById('gestureModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('gestureModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // ─── Module Modal ────────────────────────────────────────────────────────────
    function openModule(key) {
        const mod = MODULE_CONTENT[key];
        if (!mod) return;
        document.getElementById('moduleTitle').textContent = mod.title;
        const contentEl = document.getElementById('moduleContent');
        contentEl.innerHTML = `
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                ${mod.items.map(item => `
                    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all">
                        <div class="text-2xl mb-1">${item.emoji || ''}</div>
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200">${item.name}</p>
                        ${item.desc ? `<p class="text-xs text-gray-400 mt-1 leading-tight hidden sm:block">${item.desc.substring(0,40)}...</p>` : ''}
                    </div>
                `).join('')}
            </div>
            <div class="mt-6">
                <a href="{{ route('sign-language.index') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                    📸 Latihan dengan Kamera
                </a>
            </div>
        `;
        document.getElementById('moduleModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModuleModal() {
        document.getElementById('moduleModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close modal on backdrop click
    document.getElementById('gestureModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    document.getElementById('moduleModal').addEventListener('click', function(e) {
        if (e.target === this) closeModuleModal();
    });
    </script>
</x-app-layout>
