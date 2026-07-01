<x-app-layout>
    <x-slot name="header">
        Rekaman & Transkripsi Baru
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="p-6">
                <form id="recordingForm" action="{{ route('recordings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                        <input type="text" id="title" name="title" required
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white transition-all"
                            placeholder="Masukkan judul rekaman">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white transition-all resize-none"
                            placeholder="Tambahkan deskripsi (opsional)"></textarea>
                    </div>

                    <!-- Language -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bahasa</label>
                        <select id="language" name="language"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white transition-all">
                            <option value="id">Indonesia</option>
                            <option value="en">Inggris</option>
                            <option value="ja">Jepang</option>
                            <option value="ko">Korea</option>
                            <option value="ar">Arab</option>
                        </select>
                    </div>

                    <!-- Recording Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pilih Metode</h3>

                        <!-- Tabs -->
                        <div class="flex gap-2 mb-6">
                            <button type="button" id="tabRecord" class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl transition-all">
                                Rekam Langsung
                            </button>
                            <button type="button" id="tabUpload" class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                Upload File
                            </button>
                            <button type="button" id="tabTranscript" class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                Transkripsi Teks
                            </button>
                        </div>

                        <!-- Direct Recording -->
                        <div id="recordSection" class="space-y-6">
                            <!-- Recording Controls -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl p-6">
                                <div class="flex items-center justify-center gap-4 mb-6">
                                    <!-- Record Button -->
                                    <button type="button" id="recordBtn"
                                        class="w-20 h-20 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                                        <svg id="recordIcon" class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="6"></circle>
                                        </svg>
                                        <svg id="stopIcon" class="w-10 h-10 text-white hidden" fill="currentColor" viewBox="0 0 24 24">
                                            <rect x="6" y="6" width="12" height="12" rx="2"></rect>
                                        </svg>
                                    </button>

                                    <!-- Pause Button -->
                                    <button type="button" id="pauseBtn" disabled
                                        class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center disabled:opacity-50 transition-all hover:bg-gray-300 dark:hover:bg-gray-500">
                                        <svg id="pauseIcon" class="w-8 h-8 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <rect x="7" y="6" width="4" height="12" rx="1"></rect>
                                            <rect x="13" y="6" width="4" height="12" rx="1"></rect>
                                        </svg>
                                        <svg id="resumeIcon" class="w-8 h-8 text-gray-500 dark:text-gray-400 hidden" fill="currentColor" viewBox="0 0 24 24">
                                            <polygon points="8,5 19,12 8,19"></polygon>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Timer -->
                                <div class="text-center mb-4">
                                    <p id="timer" class="text-4xl font-mono font-bold text-gray-900 dark:text-white">00:00</p>
                                </div>

                                <!-- Status -->
                                <p id="status" class="text-center text-sm text-gray-500 dark:text-gray-400">Tekan tombol untuk memulai</p>
                            </div>

                            <!-- Real-time Transcript -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transkripsi Langsung</label>
                                <div id="transcript" class="w-full min-h-[200px] px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl dark:text-white whitespace-pre-wrap">
                                    Transkripsi akan muncul di sini...
                                </div>
                                <input type="hidden" name="transcript_text" id="transcriptInput">
                            </div>

                            <!-- Audio Preview -->
                            <div id="audioPreview" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hasil Rekaman</label>
                                <audio id="audioElement" controls class="w-full"></audio>
                                <input type="hidden" name="audio_blob" id="audioBlobInput">
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div id="uploadSection" class="hidden space-y-6">
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-12 text-center hover:border-blue-500 dark:hover:border-blue-400 transition-all cursor-pointer" id="dropzone">
                                <input type="file" id="fileInput" name="file" accept=".mp3,.wav,.m4a,.mp4,.mkv" class="hidden">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-gray-700 dark:text-gray-300 font-medium mb-1">Klik atau tarik file ke sini</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">MP3, WAV, M4A, MP4, MKV (max 100MB)</p>
                            </div>
                            <div id="fileInfo" class="hidden bg-gray-50 dark:bg-gray-700 rounded-xl p-4 flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p id="fileName" class="font-medium text-gray-900 dark:text-white"></p>
                                    <p id="fileSize" class="text-sm text-gray-500 dark:text-gray-400"></p>
                                </div>
                                <button type="button" id="removeFile" class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Transkripsi Teks (manual entry) -->
                        <div id="transcriptSection" class="hidden space-y-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 flex gap-3">
                                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-blue-700 dark:text-blue-300">Masukkan atau tempel teks transkripsi secara langsung. Teks ini akan disimpan bersama rekaman sebagai transkripsi.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teks Transkripsi</label>
                                <textarea id="manualTranscript" rows="10" placeholder="Ketik atau tempel teks transkripsi di sini..."
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white transition-all resize-none text-sm leading-relaxed"></textarea>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-400">
                                <span id="transcriptCharCount">0 karakter</span>
                                <button type="button" id="clearTranscriptBtn" class="text-red-400 hover:text-red-600 transition-colors">Hapus teks</button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('recordings.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all">
                            Simpan Rekaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tabs
            const tabRecord = document.getElementById('tabRecord');
            const tabUpload = document.getElementById('tabUpload');
            const tabTranscript = document.getElementById('tabTranscript');
            const recordSection = document.getElementById('recordSection');
            const uploadSection = document.getElementById('uploadSection');
            const transcriptSection = document.getElementById('transcriptSection');

            const activeTabClass = 'flex-1 px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl transition-all';
            const inactiveTabClass = 'flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all';

            function setActiveTab(active) {
                [tabRecord, tabUpload, tabTranscript].forEach(t => t.className = inactiveTabClass);
                [recordSection, uploadSection, transcriptSection].forEach(s => s.classList.add('hidden'));
                active.tab.className = activeTabClass;
                active.section.classList.remove('hidden');
            }

            tabRecord.addEventListener('click', () => setActiveTab({ tab: tabRecord, section: recordSection }));
            tabUpload.addEventListener('click', () => setActiveTab({ tab: tabUpload, section: uploadSection }));
            tabTranscript.addEventListener('click', () => setActiveTab({ tab: tabTranscript, section: transcriptSection }));

            // Upload functionality
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.getElementById('fileInput');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const removeFile = document.getElementById('removeFile');

            dropzone.addEventListener('click', () => fileInput.click());

            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('border-blue-500', 'dark:border-blue-400');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-blue-500', 'dark:border-blue-400');
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-blue-500', 'dark:border-blue-400');
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    handleFile(e.dataTransfer.files[0]);
                }
            });

            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length) {
                    handleFile(e.target.files[0]);
                }
            });

            function handleFile(file) {
                fileName.textContent = file.name;
                fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                fileInfo.classList.remove('hidden');
                dropzone.classList.add('hidden');
            }

            removeFile.addEventListener('click', () => {
                fileInput.value = '';
                fileInfo.classList.add('hidden');
                dropzone.classList.remove('hidden');
            });

            // Recording functionality
            let mediaRecorder;
            let audioChunks = [];
            let isRecording = false;
            let isPaused = false;
            let timerInterval;
            let seconds = 0;
            let recognition;

            const recordBtn = document.getElementById('recordBtn');
            const pauseBtn = document.getElementById('pauseBtn');
            const recordIcon = document.getElementById('recordIcon');
            const stopIcon = document.getElementById('stopIcon');
            const pauseIcon = document.getElementById('pauseIcon');
            const resumeIcon = document.getElementById('resumeIcon');
            const timer = document.getElementById('timer');
            const status = document.getElementById('status');
            const transcript = document.getElementById('transcript');
            const transcriptInput = document.getElementById('transcriptInput');
            const audioPreview = document.getElementById('audioPreview');
            const audioElement = document.getElementById('audioElement');
            const audioBlobInput = document.getElementById('audioBlobInput');

            // Speech Recognition setup
            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                recognition = new SpeechRecognition();
                recognition.continuous = true;
                recognition.interimResults = true;
                recognition.lang = 'id-ID';

                document.getElementById('language').addEventListener('change', function() {
                    const langMap = {
                        'id': 'id-ID',
                        'en': 'en-US',
                        'ja': 'ja-JP',
                        'ko': 'ko-KR',
                        'ar': 'ar-SA'
                    };
                    recognition.lang = langMap[this.value] || 'id-ID';
                });

                let finalTranscript = '';

                recognition.onresult = function(event) {
                    let interimTranscript = '';
                    for (let i = event.resultIndex; i < event.results.length; i++) {
                        if (event.results[i].isFinal) {
                            finalTranscript += event.results[i][0].transcript + ' ';
                        } else {
                            interimTranscript += event.results[i][0].transcript;
                        }
                    }
                    transcript.textContent = finalTranscript + interimTranscript;
                    transcriptInput.value = finalTranscript;
                };

                recognition.onerror = function(event) {
                    status.textContent = 'Error: ' + event.error;
                };
            } else {
                status.textContent = 'Browser tidak mendukung speech recognition';
            }

            recordBtn.addEventListener('click', async function() {
                if (!isRecording) {
                    // Start recording
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        mediaRecorder = new MediaRecorder(stream);
                        audioChunks = [];

                        mediaRecorder.ondataavailable = (e) => {
                            audioChunks.push(e.data);
                        };

                        mediaRecorder.onstop = () => {
                            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                            const audioUrl = URL.createObjectURL(audioBlob);
                            audioElement.src = audioUrl;
                            audioPreview.classList.remove('hidden');

                            // Convert blob to base64 for form submission
                            const reader = new FileReader();
                            reader.readAsDataURL(audioBlob);
                            reader.onloadend = function() {
                                audioBlobInput.value = reader.result;
                            };
                        };

                        mediaRecorder.start();
                        isRecording = true;
                        isPaused = false;

                        // UI update
                        recordBtn.className = 'w-20 h-20 bg-gradient-to-r from-gray-500 to-gray-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-105 transition-all';
                        recordIcon.classList.add('hidden');
                        stopIcon.classList.remove('hidden');
                        pauseBtn.disabled = false;
                        pauseBtn.className = 'w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center transition-all hover:bg-gray-300 dark:hover:bg-gray-500';
                        status.textContent = 'Merekam...';

                        // Start speech recognition
                        if (recognition) {
                            recognition.start();
                        }

                        // Start timer
                        seconds = 0;
                        timerInterval = setInterval(() => {
                            seconds++;
                            const mins = Math.floor(seconds / 60).toString().padStart(2, '0');
                            const secs = (seconds % 60).toString().padStart(2, '0');
                            timer.textContent = `${mins}:${secs}`;
                        }, 1000);

                    } catch (err) {
                        status.textContent = 'Tidak dapat mengakses mikrofon';
                        console.error(err);
                    }
                } else {
                    // Stop recording
                    mediaRecorder.stop();
                    isRecording = false;

                    // UI update
                    recordBtn.className = 'w-20 h-20 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-105 transition-all';
                    stopIcon.classList.add('hidden');
                    recordIcon.classList.remove('hidden');
                    pauseBtn.disabled = true;
                    pauseIcon.classList.remove('hidden');
                    resumeIcon.classList.add('hidden');
                    status.textContent = 'Rekaman selesai';

                    // Stop speech recognition
                    if (recognition) {
                        recognition.stop();
                    }

                    // Stop timer
                    clearInterval(timerInterval);
                }
            });

            pauseBtn.addEventListener('click', function() {
                if (!isPaused) {
                    // Pause
                    mediaRecorder.pause();
                    if (recognition) recognition.stop();
                    isPaused = true;
                    pauseIcon.classList.add('hidden');
                    resumeIcon.classList.remove('hidden');
                    status.textContent = 'Dijeda';
                    clearInterval(timerInterval);
                } else {
                    // Resume
                    mediaRecorder.resume();
                    if (recognition) recognition.start();
                    isPaused = false;
                    resumeIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                    status.textContent = 'Merekam...';
                    timerInterval = setInterval(() => {
                        seconds++;
                        const mins = Math.floor(seconds / 60).toString().padStart(2, '0');
                        const secs = (seconds % 60).toString().padStart(2, '0');
                        timer.textContent = `${mins}:${secs}`;
                    }, 1000);
                }
            });

            // Manual transcript section
            const manualTranscript = document.getElementById('manualTranscript');
            const transcriptCharCount = document.getElementById('transcriptCharCount');
            const clearTranscriptBtn = document.getElementById('clearTranscriptBtn');

            if (manualTranscript) {
                manualTranscript.addEventListener('input', function() {
                    const count = this.value.length;
                    transcriptCharCount.textContent = count + ' karakter';
                    // Sync to hidden transcript input
                    const transcriptInput = document.getElementById('transcriptInput');
                    if (transcriptInput) transcriptInput.value = this.value;
                });
            }

            if (clearTranscriptBtn) {
                clearTranscriptBtn.addEventListener('click', function() {
                    if (manualTranscript) {
                        manualTranscript.value = '';
                        transcriptCharCount.textContent = '0 karakter';
                    }
                });
            }
        });
    </script>
</x-app-layout>
