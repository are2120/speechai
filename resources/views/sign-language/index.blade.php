<x-app-layout>
    <x-slot name="header">
        Deteksi Bahasa Isyarat
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Camera Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="p-6">

                <!-- Status Bar -->
                <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                    <div class="flex items-center gap-2">
                        <div id="statusDot" class="w-3 h-3 rounded-full bg-gray-400"></div>
                        <span id="statusText" class="text-sm text-gray-500 dark:text-gray-400">Kamera belum aktif</span>
                    </div>
                    <div class="flex items-center gap-4 flex-wrap">
                        <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                            <span>🎯</span>
                            <span id="confidenceText">Akurasi: --</span>
                        </div>
                        <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                            <span>⚡</span>
                            <span id="fpsText">FPS: --</span>
                        </div>
                        <div id="modeIndicator" class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-medium rounded-full">
                            Mode: Isyarat
                        </div>
                    </div>
                </div>

                <!-- Camera Preview -->
                <div class="relative bg-gray-900 rounded-xl overflow-hidden" style="aspect-ratio:16/9;" class="mb-4">
                    <video id="videoElement" autoplay playsinline muted class="w-full h-full object-cover" style="transform:scaleX(-1);"></video>
                    <canvas id="canvasElement" class="absolute inset-0 w-full h-full" style="transform:scaleX(-1);"></canvas>

                    <!-- Loading Overlay -->
                    <div id="loadingOverlay" class="absolute inset-0 bg-gray-900/95 flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <span class="text-4xl">🤟</span>
                            </div>
                            <p class="text-white font-semibold text-lg">Deteksi Bahasa Isyarat</p>
                            <p class="text-gray-400 text-sm mt-2">Tekan "Mulai Kamera" untuk memulai</p>
                            <p class="text-gray-500 text-xs mt-1">Izinkan akses kamera saat diminta</p>
                        </div>
                    </div>

                    <!-- Active Gesture Overlay (top-right) -->
                    <div id="detectionOverlay" class="hidden absolute top-3 right-3 bg-black/70 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/10">
                        <div class="flex items-center gap-2">
                            <div class="text-2xl" id="gestureEmoji">-</div>
                            <div>
                                <div class="text-white text-sm font-semibold" id="gestureName">Mendeteksi...</div>
                                <div class="text-green-400 text-xs" id="gestureConf"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Hand count badge -->
                    <div id="handCountBadge" class="hidden absolute top-3 left-3 bg-blue-500/80 backdrop-blur-sm rounded-lg px-3 py-1 text-white text-xs font-medium">
                        <span id="handCount">0</span> tangan
                    </div>

                    <!-- Gesture buffer progress bar -->
                    <div id="bufferBar" class="hidden absolute bottom-0 left-0 right-0 h-1 bg-black/30">
                        <div id="bufferProgress" class="h-full bg-gradient-to-r from-blue-400 to-green-400 transition-all duration-100" style="width:0%"></div>
                    </div>
                </div>

                <!-- Controls -->
                <div class="flex items-center justify-center gap-3 mt-4 mb-6 flex-wrap">
                    <button id="startCameraBtn" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Mulai Kamera
                    </button>
                    <button id="stopCameraBtn" class="hidden px-6 py-3 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-semibold rounded-xl hover:bg-red-200 dark:hover:bg-red-900/50 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path></svg>
                        Hentikan
                    </button>
                    <button id="mirrorBtn" class="hidden px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all" title="Balik Kamera">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </button>
                    <button id="addSpaceBtn" class="hidden px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all text-sm" title="Tambah Spasi">
                        ⎵ Spasi
                    </button>
                </div>

                <!-- Detection Mode Selector -->
                <div id="modeSelector" class="hidden mb-5">
                    <div class="flex gap-2 justify-center flex-wrap">
                        <button class="mode-btn active-mode px-4 py-1.5 text-xs font-semibold rounded-full bg-blue-500 text-white" data-mode="gesture">🤟 Gestur Umum</button>
                        <button class="mode-btn px-4 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300" data-mode="alphabet">🔤 Alfabet (A-Z)</button>
                        <button class="mode-btn px-4 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300" data-mode="number">🔢 Angka (0-9)</button>
                    </div>
                </div>

                <!-- Detection Result Big Display -->
                <div class="bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-700/50 dark:to-blue-900/20 rounded-xl p-5 mb-5 border border-gray-100 dark:border-gray-600">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Deteksi Real-time</h3>
                        <div id="detectionIndicator" class="flex items-center gap-1">
                            <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                            <span class="text-xs text-gray-400">Standby</span>
                        </div>
                    </div>
                    <div id="detectionResult" class="text-5xl font-bold text-center text-blue-600 dark:text-blue-400 min-h-[70px] flex items-center justify-center tracking-wide">
                        -
                    </div>
                    <p id="detectionLabel" class="text-center text-gray-500 dark:text-gray-400 text-sm mt-2 font-medium"></p>
                    <!-- Confidence Bar -->
                    <div class="mt-3 h-1.5 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                        <div id="confidenceBar" class="h-full bg-gradient-to-r from-green-400 to-blue-500 rounded-full transition-all duration-300" style="width:0%"></div>
                    </div>
                </div>

                <!-- Text Output Section -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hasil Terjemahan</h3>
                        <span id="wordCount" class="text-xs text-gray-400">0 kata</span>
                    </div>
                    <div id="textOutput" class="w-full min-h-[100px] px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl dark:text-white whitespace-pre-wrap text-gray-800 leading-relaxed text-base">
                        Teks akan muncul di sini setelah gestur terdeteksi...
                    </div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <button id="clearTextBtn" class="px-4 py-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-500 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
                        <button id="speechBtn" class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-semibold rounded-xl hover:shadow-lg transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            Baca Teks
                        </button>
                        <button id="copyBtn" class="px-4 py-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-500 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            Salin
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vocabulary Reference Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-5 flex-wrap gap-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">📚 Kosakata Bahasa Isyarat</h3>
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold rounded-full">80+ gestur</span>
                </div>

                <!-- Category Tabs -->
                <div class="flex gap-2 flex-wrap mb-5">
                    <button class="vocab-tab active-tab px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-500 text-white transition-all" data-tab="sapaan">👋 Sapaan</button>
                    <button class="vocab-tab px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-all" data-tab="angka">🔢 Angka</button>
                    <button class="vocab-tab px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-all" data-tab="emosi">😊 Emosi</button>
                    <button class="vocab-tab px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-all" data-tab="aktivitas">🏃 Aktivitas</button>
                    <button class="vocab-tab px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-all" data-tab="kata">💬 Kata Dasar</button>
                    <button class="vocab-tab px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-all" data-tab="huruf">🔤 Alfabet</button>
                </div>

                <!-- Sapaan Tab -->
                <div id="tab-sapaan" class="vocab-content">
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                        @foreach([
                            ['👋','Halo','Kibas tangan terbuka'],['🙏','Terima Kasih','Kedua telapak merapat'],['👍','Ya / Baik','Jempol ke atas'],
                            ['👎','Tidak','Jempol ke bawah'],['✋','Stop / Tunggu','Telapak terbuka ke depan'],['👌','OK / Setuju','Ibu jari + telunjuk melingkar'],
                            ['✌️','Dua / Damai','Telunjuk + tengah naik'],['🤝','Selamat Datang','Kedua tangan terbuka'],['🤙','Hubungi Saya','Jempol + kelingking naik'],
                            ['👐','Terbuka / Bebas','Kedua tangan terbuka lebar'],['🫱','Silakan','Tangan ke arah objek'],['🤲','Mohon / Minta','Dua telapak menengadah'],
                        ] as $item)
                        <div class="sign-card px-2 py-3 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all cursor-default group relative">
                            <span class="text-2xl">{{ $item[0] }}</span>
                            <p class="text-xs text-gray-700 dark:text-gray-300 mt-1 font-semibold">{{ $item[1] }}</p>
                            <div class="hidden group-hover:block absolute z-10 bottom-full left-1/2 -translate-x-1/2 mb-1 w-36 bg-gray-900 text-white text-xs rounded-lg p-2 text-center shadow-lg">{{ $item[2] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Angka Tab -->
                <div id="tab-angka" class="vocab-content hidden">
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                        @foreach([
                            ['✊','Nol (0)','Kepalan tangan'],['☝️','Satu (1)','Hanya telunjuk naik'],['✌️','Dua (2)','Telunjuk + tengah naik'],
                            ['🤟','Tiga (3)','Telunjuk + tengah + jempol'],['🖖','Empat (4)','4 jari naik tanpa jempol'],['✋','Lima (5)','Semua jari terbuka'],
                            ['🤙','Enam (6)','Jempol + kelingking naik'],['🤞','Tujuh (7)','Telunjuk + tengah silang'],['🤘','Delapan (8)','Telunjuk + kelingking naik'],
                            ['👌','Sembilan (9)','Jempol + telunjuk melingkar'],['🔟','Sepuluh (10)','Dua tangan naik'],
                        ] as $item)
                        <div class="sign-card px-2 py-3 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-green-50 dark:hover:bg-green-900/20 transition-all cursor-default group relative">
                            <span class="text-2xl">{{ $item[0] }}</span>
                            <p class="text-xs text-gray-700 dark:text-gray-300 mt-1 font-semibold">{{ $item[1] }}</p>
                            <div class="hidden group-hover:block absolute z-10 bottom-full left-1/2 -translate-x-1/2 mb-1 w-36 bg-gray-900 text-white text-xs rounded-lg p-2 text-center shadow-lg">{{ $item[2] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Emosi Tab -->
                <div id="tab-emosi" class="vocab-content hidden">
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                        @foreach([
                            ['❤️','Cinta / Sayang','Tangan di dada'],['😊','Senang','Tangan gestur senyum'],['😢','Sedih','Jari menyeka pipi'],
                            ['😡','Marah','Kepalan di depan wajah'],['😨','Takut','Tangan gemetar di dada'],['😴','Capek / Ngantuk','Tangan menutup mata'],
                            ['😮','Terkejut','Tangan terbuka di pipi'],['🤔','Bingung','Jari di pelipis'],['😌','Tenang','Tangan merata ke bawah'],
                            ['💪','Semangat','Kepalan tangan ke atas'],['👏','Bagus Sekali','Bertepuk tangan'],['🙌','Luar Biasa','Dua tangan ke atas'],
                        ] as $item)
                        <div class="sign-card px-2 py-3 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-all cursor-default group relative">
                            <span class="text-2xl">{{ $item[0] }}</span>
                            <p class="text-xs text-gray-700 dark:text-gray-300 mt-1 font-semibold">{{ $item[1] }}</p>
                            <div class="hidden group-hover:block absolute z-10 bottom-full left-1/2 -translate-x-1/2 mb-1 w-36 bg-gray-900 text-white text-xs rounded-lg p-2 text-center shadow-lg">{{ $item[2] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Aktivitas Tab -->
                <div id="tab-aktivitas" class="vocab-content hidden">
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                        @foreach([
                            ['🍽️','Makan','Tangan ke arah mulut'],['💧','Minum','Tangan seperti memegang gelas'],['😴','Tidur','Telapak di pipi miring'],
                            ['📚','Belajar','Tangan membuka buku'],['💼','Bekerja','Kepalan tangan bergantian'],['🚶','Pergi','Tangan menunjuk ke depan'],
                            ['🏠','Pulang','Tangan menunjuk ke belakang'],['🏃','Berlari','Tangan mengayun cepat'],['🤸','Olahraga','Tangan bergantian naik'],
                            ['✍️','Menulis','Jari seperti memegang pena'],['📖','Membaca','Tangan membuka buku ke atas'],['🎵','Bernyanyi','Tangan di dekat mulut bergantian'],
                        ] as $item)
                        <div class="sign-card px-2 py-3 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-all cursor-default group relative">
                            <span class="text-2xl">{{ $item[0] }}</span>
                            <p class="text-xs text-gray-700 dark:text-gray-300 mt-1 font-semibold">{{ $item[1] }}</p>
                            <div class="hidden group-hover:block absolute z-10 bottom-full left-1/2 -translate-x-1/2 mb-1 w-36 bg-gray-900 text-white text-xs rounded-lg p-2 text-center shadow-lg">{{ $item[2] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kata Dasar Tab -->
                <div id="tab-kata" class="vocab-content hidden">
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                        @foreach([
                            ['👤','Saya','Telunjuk ke diri sendiri'],['👥','Kamu','Telunjuk ke lawan bicara'],['👨','Dia','Telunjuk ke samping'],
                            ['🏠','Rumah','Dua tangan membentuk atap'],['🏫','Sekolah','Tangan membuka buku'],['🏥','Rumah Sakit','Tanda plus di lengan'],
                            ['💧','Air','Tangan seperti menuang'],['🍚','Nasi','Tangan menggenggam ke atas'],['📖','Buku','Tangan membuka lebar'],
                            ['👫','Teman','Dua jari saling mengait'],['❓','Apa','Jari membentuk tanda tanya'],['👆','Siapa','Telunjuk ke atas berputar'],
                            ['⏰','Kapan','Tangan menunjuk jam'],['📍','Dimana','Telunjuk ke bawah berpindah'],['🔄','Mengapa','Jari di pelipis berputar'],
                            ['🤷','Bagaimana','Kedua tangan terbuka ke atas'],['🙅','Tidak Mau','Tangan silang di depan dada'],['👍','Mau / Ingin','Jempol ke atas tegas'],
                        ] as $item)
                        <div class="sign-card px-2 py-3 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all cursor-default group relative">
                            <span class="text-2xl">{{ $item[0] }}</span>
                            <p class="text-xs text-gray-700 dark:text-gray-300 mt-1 font-semibold">{{ $item[1] }}</p>
                            <div class="hidden group-hover:block absolute z-10 bottom-full left-1/2 -translate-x-1/2 mb-1 w-36 bg-gray-900 text-white text-xs rounded-lg p-2 text-center shadow-lg">{{ $item[2] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Alfabet Tab -->
                <div id="tab-huruf" class="vocab-content hidden">
                    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-9 gap-2">
                        @foreach(['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'] as $letter)
                        <div class="sign-card px-2 py-3 bg-gray-50 dark:bg-gray-700 rounded-xl text-center hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all cursor-default">
                            <span class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $letter }}</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">SIBI</p>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-3">💡 Alfabet SIBI menggunakan posisi jari tangan yang unik untuk setiap huruf.</p>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl border border-blue-100 dark:border-blue-800 p-5">
            <h3 class="font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                <span>💡</span> Tips Penggunaan
            </h3>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-3 text-sm text-gray-600 dark:text-gray-300">
                <div class="flex items-start gap-2"><span class="text-green-500 mt-0.5">✓</span><span>Pastikan pencahayaan cukup terang dan merata</span></div>
                <div class="flex items-start gap-2"><span class="text-green-500 mt-0.5">✓</span><span>Posisikan tangan di tengah frame kamera</span></div>
                <div class="flex items-start gap-2"><span class="text-green-500 mt-0.5">✓</span><span>Tahan gestur selama 1–2 detik agar terdeteksi</span></div>
                <div class="flex items-start gap-2"><span class="text-green-500 mt-0.5">✓</span><span>Gunakan latar belakang polos untuk akurasi lebih baik</span></div>
                <div class="flex items-start gap-2"><span class="text-green-500 mt-0.5">✓</span><span>Jaga jarak 30–60 cm dari kamera</span></div>
                <div class="flex items-start gap-2"><span class="text-green-500 mt-0.5">✓</span><span>Gunakan spasi untuk memisahkan kata-kata</span></div>
            </div>
        </div>

    </div>

    <!-- MediaPipe Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // ─── DOM Refs ───────────────────────────────────────────────────────────
        const videoElement     = document.getElementById('videoElement');
        const canvasElement    = document.getElementById('canvasElement');
        const canvasCtx        = canvasElement.getContext('2d');
        const loadingOverlay   = document.getElementById('loadingOverlay');
        const detectionOverlay = document.getElementById('detectionOverlay');
        const detectionResult  = document.getElementById('detectionResult');
        const detectionLabel   = document.getElementById('detectionLabel');
        const gestureEmoji     = document.getElementById('gestureEmoji');
        const gestureName      = document.getElementById('gestureName');
        const gestureConf      = document.getElementById('gestureConf');
        const textOutput       = document.getElementById('textOutput');
        const clearTextBtn     = document.getElementById('clearTextBtn');
        const speechBtn        = document.getElementById('speechBtn');
        const copyBtn          = document.getElementById('copyBtn');
        const statusDot        = document.getElementById('statusDot');
        const statusText       = document.getElementById('statusText');
        const confidenceText   = document.getElementById('confidenceText');
        const confidenceBar    = document.getElementById('confidenceBar');
        const fpsText          = document.getElementById('fpsText');
        const detectionIndicator = document.getElementById('detectionIndicator');
        const wordCount        = document.getElementById('wordCount');
        const handCountBadge   = document.getElementById('handCountBadge');
        const handCountEl      = document.getElementById('handCount');
        const bufferBar        = document.getElementById('bufferBar');
        const bufferProgress   = document.getElementById('bufferProgress');
        const startCameraBtn   = document.getElementById('startCameraBtn');
        const stopCameraBtn    = document.getElementById('stopCameraBtn');
        const mirrorBtn        = document.getElementById('mirrorBtn');
        const addSpaceBtn      = document.getElementById('addSpaceBtn');
        const modeSelector     = document.getElementById('modeSelector');

        // ─── State ──────────────────────────────────────────────────────────────
        let hands, camera, stream;
        let detectedText = '';
        let lastDetected = '';
        let detectionCount = 0;
        let isMirrored = true;
        let currentMode = 'gesture'; // 'gesture' | 'alphabet' | 'number'
        let lastFrameTime = performance.now();
        let frameCount = 0;

        // Temporal smoothing window
        const SMOOTH_WINDOW = 10;
        const CONFIRM_THRESHOLD = 8;  // frames before accepting gesture
        const COOLDOWN_FRAMES = 15;   // frames to wait after accepting
        let smoothWindow = [];
        let cooldownCount = 0;

        // ─── Full Gesture Vocabulary ────────────────────────────────────────────
        // Maps gesture key → { label, output, emoji }
        const GESTURE_VOCAB = {
            // General gestures
            'thumbs_up':    { label: 'Ya / Baik',         output: 'Ya ',            emoji: '👍' },
            'thumbs_down':  { label: 'Tidak / Buruk',     output: 'Tidak ',         emoji: '👎' },
            'open_hand':    { label: 'Stop / Tunggu',     output: 'Berhenti ',      emoji: '✋' },
            'peace':        { label: 'Dua / Damai',       output: 'Dua ',           emoji: '✌️' },
            'ok_sign':      { label: 'OK / Setuju',       output: 'OK ',            emoji: '👌' },
            'point_up':     { label: 'Satu / Atas',       output: 'Satu ',          emoji: '☝️' },
            'shaka':        { label: 'Hubungi Saya',      output: 'Hubungi saya ',  emoji: '🤙' },
            'rock':         { label: 'Keren / Rock',      output: 'Keren ',         emoji: '🤘' },
            'cross_fingers':{ label: 'Semoga Beruntung',  output: 'Beruntung ',     emoji: '🤞' },
            'ily':          { label: 'Aku Cinta Kamu',    output: 'Aku cinta kamu ', emoji: '🤟' },
            'vulcan':       { label: 'Empat / Salam',     output: 'Empat ',         emoji: '🖖' },
            'fist':         { label: 'Semangat',          output: 'Semangat ',      emoji: '✊' },
            'wave':         { label: 'Halo / Selamat',    output: 'Halo ',          emoji: '👋' },
            'open_both':    { label: 'Terbuka / Bebas',   output: 'Terbuka ',       emoji: '👐' },
            'clap':         { label: 'Bagus Sekali',      output: 'Bagus sekali ',  emoji: '👏' },
            'pray':         { label: 'Terima Kasih',      output: 'Terima kasih ',  emoji: '🙏' },
            'point_forward':{ label: 'Pergi / Sana',      output: 'Pergi ',         emoji: '👉' },
            'three_fingers':{ label: 'Tiga',              output: 'Tiga ',          emoji: '🤟' },
            'four_fingers': { label: 'Empat (4)',         output: 'Empat ',         emoji: '🖖' },
            'pinch':        { label: 'Sedikit / Kecil',   output: 'Sedikit ',       emoji: '🤌' },
            'horns':        { label: 'Delapan',           output: 'Delapan ',       emoji: '🤘' },
            // Numbers
            'num_0':  { label: 'Angka 0',  output: '0 ', emoji: '0️⃣' },
            'num_1':  { label: 'Angka 1',  output: '1 ', emoji: '1️⃣' },
            'num_2':  { label: 'Angka 2',  output: '2 ', emoji: '2️⃣' },
            'num_3':  { label: 'Angka 3',  output: '3 ', emoji: '3️⃣' },
            'num_4':  { label: 'Angka 4',  output: '4 ', emoji: '4️⃣' },
            'num_5':  { label: 'Angka 5',  output: '5 ', emoji: '5️⃣' },
            'num_6':  { label: 'Angka 6',  output: '6 ', emoji: '6️⃣' },
            'num_7':  { label: 'Angka 7',  output: '7 ', emoji: '7️⃣' },
            'num_8':  { label: 'Angka 8',  output: '8 ', emoji: '8️⃣' },
            'num_9':  { label: 'Angka 9',  output: '9 ', emoji: '9️⃣' },
        };

        // ─── Vocabulary Tab Switching ────────────────────────────────────────────
        document.querySelectorAll('.vocab-tab').forEach(tab => {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.vocab-tab').forEach(t => {
                    t.className = 'vocab-tab px-3 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-all';
                });
                this.className = 'vocab-tab active-tab px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-500 text-white transition-all';
                document.querySelectorAll('.vocab-content').forEach(c => c.classList.add('hidden'));
                document.getElementById('tab-' + this.dataset.tab).classList.remove('hidden');
            });
        });

        // ─── Mode Selector ──────────────────────────────────────────────────────
        document.querySelectorAll('.mode-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.mode-btn').forEach(b => {
                    b.className = 'mode-btn px-4 py-1.5 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300';
                });
                this.className = 'mode-btn active-mode px-4 py-1.5 text-xs font-semibold rounded-full bg-blue-500 text-white';
                currentMode = this.dataset.mode;
                smoothWindow = [];
                detectionCount = 0;
                lastDetected = '';
                document.getElementById('modeIndicator').textContent = 'Mode: ' + this.textContent.trim();
            });
        });

        // Mirror toggle
        mirrorBtn.addEventListener('click', function () {
            isMirrored = !isMirrored;
            const tf = isMirrored ? 'scaleX(-1)' : 'scaleX(1)';
            videoElement.style.transform = tf;
            canvasElement.style.transform = tf;
        });

        addSpaceBtn.addEventListener('click', function () {
            if (detectedText && detectedText !== 'Teks akan muncul di sini setelah gestur terdeteksi...') {
                detectedText += ' ';
                updateTextOutput();
            }
        });

        // ─── MediaPipe Init ──────────────────────────────────────────────────────
        async function initializeHands() {
            hands = new Hands({
                locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`
            });
            hands.setOptions({
                maxNumHands: 2,
                modelComplexity: 1,
                minDetectionConfidence: 0.65,
                minTrackingConfidence: 0.6
            });
            hands.onResults(onResults);
        }

        // ─── Main Detection Callback ─────────────────────────────────────────────
        function onResults(results) {
            const w = videoElement.videoWidth  || 640;
            const h = videoElement.videoHeight || 480;
            canvasElement.width  = w;
            canvasElement.height = h;

            canvasCtx.save();
            canvasCtx.clearRect(0, 0, w, h);
            canvasCtx.drawImage(results.image, 0, 0, w, h);

            // FPS counter
            frameCount++;
            const now = performance.now();
            if (now - lastFrameTime >= 1000) {
                fpsText.textContent = `FPS: ${frameCount}`;
                frameCount = 0;
                lastFrameTime = now;
            }

            if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
                handCountEl.textContent = results.multiHandLandmarks.length;
                handCountBadge.classList.remove('hidden');

                for (const lm of results.multiHandLandmarks) {
                    drawConnectors(canvasCtx, lm, HAND_CONNECTIONS, { color: '#4F9EFF', lineWidth: 2.5 });
                    drawLandmarks(canvasCtx, lm, { color: '#FF4F4F', lineWidth: 1, radius: 3.5 });
                }

                const primaryLm   = results.multiHandLandmarks[0];
                const handedness  = results.multiHandedness ? results.multiHandedness[0]?.label : null;
                const gesture     = classifyGesture(primaryLm, results.multiHandLandmarks, handedness);

                processGesture(gesture);
            } else {
                handCountBadge.classList.add('hidden');
                detectionOverlay.classList.add('hidden');
                bufferBar.classList.add('hidden');
                detectionResult.textContent = '-';
                detectionLabel.textContent = '';
                smoothWindow = [];
                detectionCount = 0;
                if (cooldownCount > 0) cooldownCount--;
                setIndicatorState('active');
            }

            canvasCtx.restore();
        }

        // ─── Core Gesture Classifier ─────────────────────────────────────────────
        function classifyGesture(lm, allLm, handedness) {

            // Extract named landmarks
            const wrist  = lm[0];
            const thumb  = { cmc: lm[1], mcp: lm[2], ip: lm[3], tip: lm[4] };
            const index  = { mcp: lm[5], pip: lm[6], dip: lm[7], tip: lm[8] };
            const middle = { mcp: lm[9], pip: lm[10], dip: lm[11], tip: lm[12] };
            const ring   = { mcp: lm[13], pip: lm[14], dip: lm[15], tip: lm[16] };
            const pinky  = { mcp: lm[17], pip: lm[18], dip: lm[19], tip: lm[20] };

            // ── Finger Extension (Y-axis: smaller = higher on screen) ─────────────
            const THRESHOLD = 0.03;
            const isIndexUp  = index.tip.y  < index.pip.y  - THRESHOLD;
            const isMiddleUp = middle.tip.y < middle.pip.y - THRESHOLD;
            const isRingUp   = ring.tip.y   < ring.pip.y   - THRESHOLD;
            const isPinkyUp  = pinky.tip.y  < pinky.pip.y  - THRESHOLD;

            // Thumb: horizontal extension relative to index MCP
            const isThumbUp  = thumb.tip.y < thumb.ip.y - THRESHOLD;
            const isThumbOut = Math.abs(thumb.tip.x - thumb.mcp.x) > 0.06;
            const isThumbDown = thumb.tip.y > wrist.y + 0.02;

            // ── Utility distance ──────────────────────────────────────────────────
            const dist3D = (a, b) => Math.sqrt(
                Math.pow(a.x - b.x, 2) + Math.pow(a.y - b.y, 2) + Math.pow(a.z - b.z, 2)
            );

            const dist2D = (a, b) => Math.sqrt(
                Math.pow(a.x - b.x, 2) + Math.pow(a.y - b.y, 2)
            );

            // Finger curl: how bent is each finger
            const indexCurl  = dist2D(index.tip,  index.mcp)  < 0.12;
            const middleCurl = dist2D(middle.tip, middle.mcp) < 0.12;
            const ringCurl   = dist2D(ring.tip,   ring.mcp)   < 0.12;
            const pinkyCurl  = dist2D(pinky.tip,  pinky.mcp)  < 0.12;

            // Pinch distance
            const thumbIndexDist  = dist2D(thumb.tip, index.tip);
            const isPinching      = thumbIndexDist < 0.06;
            const isLoosePinching = thumbIndexDist < 0.10;

            const allUp     = isIndexUp && isMiddleUp && isRingUp && isPinkyUp;
            const allCurled = indexCurl && middleCurl && ringCurl && pinkyCurl;
            const noThumb   = !isThumbOut;

            // ── NUMBER MODE ──────────────────────────────────────────────────────
            if (currentMode === 'number') {
                // 0: O-shape, all fingers curl around thumb
                if (isPinching && !isIndexUp && !isMiddleUp && !isRingUp && !isPinkyUp)
                    return { key: 'num_0', conf: 0.88 };
                // 1: index only
                if (isIndexUp && !isMiddleUp && !isRingUp && !isPinkyUp && !isThumbOut)
                    return { key: 'num_1', conf: 0.90 };
                // 2: index + middle
                if (isIndexUp && isMiddleUp && !isRingUp && !isPinkyUp && !isThumbOut)
                    return { key: 'num_2', conf: 0.88 };
                // 3: index + middle + ring
                if (isIndexUp && isMiddleUp && isRingUp && !isPinkyUp && !isThumbOut)
                    return { key: 'num_3', conf: 0.85 };
                // 4: four fingers (no thumb)
                if (isIndexUp && isMiddleUp && isRingUp && isPinkyUp && !isThumbOut)
                    return { key: 'num_4', conf: 0.87 };
                // 5: all fingers
                if (allUp && isThumbOut)
                    return { key: 'num_5', conf: 0.90 };
                // 6: thumb + pinky
                if (isThumbOut && !isIndexUp && !isMiddleUp && !isRingUp && isPinkyUp)
                    return { key: 'num_6', conf: 0.84 };
                // 7: index + middle crossed/close
                if (isIndexUp && isMiddleUp && !isRingUp && !isPinkyUp &&
                    Math.abs(index.tip.x - middle.tip.x) < 0.05)
                    return { key: 'num_7', conf: 0.82 };
                // 8: index + pinky (horns)
                if (isIndexUp && !isMiddleUp && !isRingUp && isPinkyUp)
                    return { key: 'num_8', conf: 0.83 };
                // 9: thumb + index circle (OK-like)
                if (isPinching && isMiddleUp && isRingUp && isPinkyUp)
                    return { key: 'num_9', conf: 0.86 };
                return null;
            }

            // ── GESTURE MODE ─────────────────────────────────────────────────────

            // 1. Thumbs UP: thumb up, all fingers curled
            if (isThumbUp && !isIndexUp && !isMiddleUp && !isRingUp && !isPinkyUp && !isThumbDown) {
                if (thumb.tip.y < wrist.y - 0.05)
                    return { key: 'thumbs_up', conf: 0.92 };
            }

            // 2. Thumbs DOWN: thumb pointing down
            if (!isIndexUp && !isMiddleUp && !isRingUp && !isPinkyUp && isThumbDown) {
                return { key: 'thumbs_down', conf: 0.90 };
            }

            // 3. Open hand / STOP (all 5 fingers spread)
            if (allUp && isThumbOut && !isPinching) {
                return { key: 'open_hand', conf: 0.93 };
            }

            // 4. PRAY / Terima Kasih: two hands both have palm up landmarks close together
            if (allLm.length >= 2) {
                const d = dist2D(allLm[0][0], allLm[1][0]);
                if (d < 0.25) return { key: 'pray', conf: 0.87 };
            }

            // 5. WAVE / Halo: two hands, each with fingers open
            if (allLm.length >= 2 && allUp) {
                return { key: 'wave', conf: 0.86 };
            }

            // 6. OK Sign: thumb-index pinch, middle+ring+pinky up
            if (isPinching && isMiddleUp && isRingUp && isPinkyUp) {
                return { key: 'ok_sign', conf: 0.87 };
            }

            // 7. Peace / V: index + middle up, ring + pinky down, fingers spread
            if (isIndexUp && isMiddleUp && !isRingUp && !isPinkyUp && !isPinching) {
                const separation = Math.abs(index.tip.x - middle.tip.x);
                if (separation > 0.025)
                    return { key: 'peace', conf: 0.89 };
                // 7b. Cross fingers (close together)
                return { key: 'cross_fingers', conf: 0.80 };
            }

            // 8. Point UP: only index up
            if (isIndexUp && !isMiddleUp && !isRingUp && !isPinkyUp && !isThumbOut) {
                return { key: 'point_up', conf: 0.88 };
            }

            // 9. Shaka (call me): thumb + pinky, rest curled
            if (isThumbOut && !isIndexUp && !isMiddleUp && !isRingUp && isPinkyUp) {
                return { key: 'shaka', conf: 0.87 };
            }

            // 10. ILY (I Love You): thumb + index + pinky up
            if (isThumbOut && isIndexUp && !isMiddleUp && !isRingUp && isPinkyUp) {
                return { key: 'ily', conf: 0.85 };
            }

            // 11. Rock / Horns: index + pinky up, middle + ring down
            if (isIndexUp && !isMiddleUp && !isRingUp && isPinkyUp && !isThumbOut) {
                return { key: 'rock', conf: 0.84 };
            }

            // 12. Vulcan / Four fingers (index+middle+ring+pinky, no thumb)
            if (isIndexUp && isMiddleUp && isRingUp && isPinkyUp && !isThumbOut) {
                const midGap  = Math.abs(middle.tip.x - ring.tip.x);
                if (midGap > 0.03)
                    return { key: 'vulcan', conf: 0.82 };
                return { key: 'four_fingers', conf: 0.82 };
            }

            // 13. Three fingers: index + middle + ring
            if (isIndexUp && isMiddleUp && isRingUp && !isPinkyUp) {
                return { key: 'three_fingers', conf: 0.83 };
            }

            // 14. Fist / Semangat
            if (allCurled && !isThumbOut) {
                return { key: 'fist', conf: 0.85 };
            }

            // 15. Pinch / Sedikit: thumb+index close, others curled
            if (isLoosePinching && !isMiddleUp && !isRingUp && !isPinkyUp) {
                return { key: 'pinch', conf: 0.80 };
            }

            // 16. Open both (no thumb check — wide open)
            if (allUp && !isThumbOut) {
                return { key: 'open_both', conf: 0.78 };
            }

            return null;
        }

        // ─── Temporal Smoothing & Output ─────────────────────────────────────────
        function processGesture(gestureResult) {
            if (cooldownCount > 0) {
                cooldownCount--;
                return;
            }

            if (!gestureResult) {
                smoothWindow = [];
                detectionCount = 0;
                detectionResult.textContent = '🔍';
                detectionLabel.textContent = 'Menunggu gestur...';
                confidenceBar.style.width = '0%';
                bufferBar.classList.add('hidden');
                setIndicatorState('detecting');
                return;
            }

            const { key, conf } = gestureResult;

            // Sliding window majority vote
            smoothWindow.push(key);
            if (smoothWindow.length > SMOOTH_WINDOW) smoothWindow.shift();

            // Count majority
            const freq = {};
            smoothWindow.forEach(k => { freq[k] = (freq[k] || 0) + 1; });
            const majorityKey = Object.entries(freq).sort((a,b) => b[1] - a[1])[0][0];
            const majority    = freq[majorityKey];
            const majorityConf = conf;

            const vocab = GESTURE_VOCAB[majorityKey];
            if (!vocab) return;

            // Confidence gate: require ≥ 70%
            if (majorityConf < 0.70) {
                detectionResult.textContent = '❓';
                detectionLabel.textContent = 'Gestur tidak dikenali';
                confidenceBar.style.width = '0%';
                return;
            }

            // Update live display
            detectionResult.textContent  = vocab.emoji;
            detectionLabel.textContent   = vocab.label;
            gestureEmoji.textContent     = vocab.emoji;
            gestureName.textContent      = vocab.label;
            gestureConf.textContent      = `${Math.round(majorityConf * 100)}%`;
            detectionOverlay.classList.remove('hidden');
            confidenceText.textContent   = `Akurasi: ${Math.round(majorityConf * 100)}%`;
            confidenceBar.style.width    = `${Math.round(majorityConf * 100)}%`;
            setIndicatorState('detecting');

            // Buffer progress
            if (majorityKey === lastDetected) {
                detectionCount++;
                bufferBar.classList.remove('hidden');
                bufferProgress.style.width = `${Math.min(100, (detectionCount / CONFIRM_THRESHOLD) * 100)}%`;
            } else {
                lastDetected = majorityKey;
                detectionCount = 1;
                bufferProgress.style.width = '0%';
            }

            // Confirm gesture after threshold
            if (detectionCount >= CONFIRM_THRESHOLD) {
                commitGesture(vocab);
                detectionCount = 0;
                smoothWindow = [];
                cooldownCount = COOLDOWN_FRAMES;
                bufferProgress.style.width = '100%';

                // Flash green
                bufferProgress.classList.add('bg-green-500');
                setTimeout(() => bufferProgress.classList.remove('bg-green-500'), 300);
            }
        }

        function commitGesture(vocab) {
            if (detectedText === '' || detectedText === 'Teks akan muncul di sini setelah gestur terdeteksi...') {
                detectedText = '';
            }
            detectedText += vocab.output;
            updateTextOutput();

            // Flash confirmation on text box
            textOutput.classList.add('ring-2', 'ring-green-400');
            setTimeout(() => textOutput.classList.remove('ring-2', 'ring-green-400'), 500);
        }

        function updateTextOutput() {
            textOutput.textContent = detectedText;
            const words = detectedText.trim().split(/\s+/).filter(w => w.length > 0);
            wordCount.textContent  = words.length + ' kata';
        }

        function setIndicatorState(state) {
            const dot   = detectionIndicator.querySelector('div');
            const label = detectionIndicator.querySelector('span');
            if (state === 'active') {
                dot.className   = 'w-2 h-2 rounded-full bg-green-400 animate-pulse';
                label.textContent = 'Aktif';
                label.className = 'text-xs text-green-500';
            } else if (state === 'detecting') {
                dot.className   = 'w-2 h-2 rounded-full bg-blue-400 animate-pulse';
                label.textContent = 'Mendeteksi';
                label.className = 'text-xs text-blue-500';
            } else {
                dot.className   = 'w-2 h-2 rounded-full bg-gray-300';
                label.textContent = 'Standby';
                label.className = 'text-xs text-gray-400';
            }
        }

        // ─── Camera Control ──────────────────────────────────────────────────────
        startCameraBtn.addEventListener('click', async function () {
            try {
                statusDot.className  = 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
                statusText.textContent = 'Menghubungkan kamera...';

                stream = await navigator.mediaDevices.getUserMedia({
                    video: { width: { ideal: 1280 }, height: { ideal: 720 }, facingMode: 'user' }
                });

                videoElement.srcObject = stream;
                await videoElement.play();

                await initializeHands();

                camera = new Camera(videoElement, {
                    onFrame: async () => {
                        if (hands) await hands.send({ image: videoElement });
                    },
                    width: 1280, height: 720
                });
                camera.start();

                loadingOverlay.classList.add('hidden');
                startCameraBtn.classList.add('hidden');
                stopCameraBtn.classList.remove('hidden');
                mirrorBtn.classList.remove('hidden');
                addSpaceBtn.classList.remove('hidden');
                modeSelector.classList.remove('hidden');

                statusDot.className  = 'w-3 h-3 rounded-full bg-green-400 animate-pulse';
                statusText.textContent = 'Kamera aktif — siap mendeteksi';
                setIndicatorState('active');

            } catch (err) {
                console.error('Camera error:', err);
                statusDot.className  = 'w-3 h-3 rounded-full bg-red-400';
                statusText.textContent = 'Gagal mengakses kamera';
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
            }
        });

        stopCameraBtn.addEventListener('click', function () {
            if (camera) camera.stop();
            if (stream) stream.getTracks().forEach(t => t.stop());
            if (hands)  { hands.close(); hands = null; }
            camera = null;
            videoElement.srcObject = null;

            loadingOverlay.classList.remove('hidden');
            stopCameraBtn.classList.add('hidden');
            mirrorBtn.classList.add('hidden');
            addSpaceBtn.classList.add('hidden');
            modeSelector.classList.add('hidden');
            startCameraBtn.classList.remove('hidden');
            detectionOverlay.classList.add('hidden');
            handCountBadge.classList.add('hidden');
            bufferBar.classList.add('hidden');
            detectionResult.textContent = '-';
            detectionLabel.textContent  = '';
            fpsText.textContent = 'FPS: --';

            statusDot.className  = 'w-3 h-3 rounded-full bg-gray-400';
            statusText.textContent = 'Kamera dimatikan';
            confidenceText.textContent = 'Akurasi: --';
            confidenceBar.style.width  = '0%';
            setIndicatorState('standby');
        });

        clearTextBtn.addEventListener('click', function () {
            detectedText = '';
            textOutput.textContent = 'Teks akan muncul di sini setelah gestur terdeteksi...';
            wordCount.textContent  = '0 kata';
        });

        speechBtn.addEventListener('click', function () {
            if ('speechSynthesis' in window && detectedText.trim()) {
                speechSynthesis.cancel();
                const utt  = new SpeechSynthesisUtterance(detectedText);
                utt.lang   = 'id-ID';
                utt.rate   = 0.9;
                speechSynthesis.speak(utt);
                speechBtn.innerHTML = `<svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 24 24"><path d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg> Membaca...`;
                utt.onend = () => {
                    speechBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg> Baca Teks`;
                };
            }
        });

        copyBtn.addEventListener('click', function () {
            if (detectedText.trim()) {
                navigator.clipboard.writeText(detectedText).then(() => {
                    copyBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Tersalin!`;
                    setTimeout(() => {
                        copyBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg> Salin`;
                    }, 2000);
                });
            }
        });

    });
    </script>
</x-app-layout>
