<x-app-layout>
    <x-slot name="header">
        Komunikasi Dua Arah
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">
        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Left Side - Speech to Text (for non-deaf users) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                        Suara ke Teks
                    </h3>
                </div>
                <div class="p-6">
                    <!-- Controls -->
                    <div class="flex items-center justify-center gap-4 mb-6">
                        <button id="speechStartBtn" class="p-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full hover:shadow-lg hover:shadow-blue-500/30 transition-all">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                            </svg>
                        </button>
                        <button id="speechStopBtn" class="hidden p-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-full hover:shadow-lg transition-all">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H9a1 1 0 01-1-1v-4z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Status -->
                    <p id="speechStatus" class="text-center text-sm text-gray-500 dark:text-gray-400 mb-4">Klik untuk mulai merekam</p>

                    <!-- Live Transcript -->
                    <div id="speechTranscript" class="min-h-[150px] p-4 bg-gray-50 dark:bg-gray-700 rounded-xl text-lg dark:text-white whitespace-pre-wrap">
                        Transkripsi akan muncul di sini...
                    </div>

                    <!-- Send Button -->
                    <button id="sendSpeechBtn" class="w-full mt-4 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Kirim ke Chat
                    </button>
                </div>
            </div>

            <!-- Right Side - Sign Language to Text (for deaf users) -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"></path>
                        </svg>
                        Bahasa Isyarat ke Teks
                    </h3>
                </div>
                <div class="p-6">
                    <!-- Camera Preview -->
                    <div class="relative bg-gray-900 rounded-xl overflow-hidden aspect-video mb-4">
                        <video id="signVideo" autoplay playsinline class="w-full h-full object-cover"></video>
                        <canvas id="signCanvas" class="absolute inset-0 w-full h-full"></canvas>
                    </div>

                    <!-- Controls -->
                    <div class="flex items-center justify-center gap-4 mb-4">
                        <button id="signStartBtn" class="p-4 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-full hover:shadow-lg hover:shadow-purple-500/30 transition-all">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        <button id="signStopBtn" class="hidden p-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-full hover:shadow-lg transition-all">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H9a1 1 0 01-1-1v-4z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Detection Result -->
                    <div id="signResult" class="min-h-[100px] p-4 bg-gray-50 dark:bg-gray-700 rounded-xl text-2xl font-bold text-center text-purple-600 dark:text-purple-400">
                        -
                    </div>

                    <!-- Send Button -->
                    <button id="sendSignBtn" class="w-full mt-4 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-purple-500/30 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Kirim ke Chat
                    </button>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Chat
                </h3>
            </div>
            <div id="chatArea" class="p-6 h-[400px] overflow-y-auto space-y-4">
                <div class="flex justify-center">
                    <span class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full text-sm">
                        Mulai percakapan!
                    </span>
                </div>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <input id="messageInput" type="text" placeholder="Ketik pesan..." class="flex-1 px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white transition-all">
                    <button id="sendMessageBtn" class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-green-500/30 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Speech to Text
            const speechStartBtn = document.getElementById('speechStartBtn');
            const speechStopBtn = document.getElementById('speechStopBtn');
            const speechStatus = document.getElementById('speechStatus');
            const speechTranscript = document.getElementById('speechTranscript');
            const sendSpeechBtn = document.getElementById('sendSpeechBtn');

            let speechRecognition;
            let currentSpeechText = '';

            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                speechRecognition = new SpeechRecognition();
                speechRecognition.continuous = true;
                speechRecognition.interimResults = true;
                speechRecognition.lang = 'id-ID';

                speechRecognition.onresult = function(event) {
                    let interim = '';
                    for (let i = event.resultIndex; i < event.results.length; i++) {
                        if (event.results[i].isFinal) {
                            currentSpeechText += event.results[i][0].transcript;
                        } else {
                            interim += event.results[i][0].transcript;
                        }
                    }
                    speechTranscript.textContent = currentSpeechText + interim;
                    sendSpeechBtn.disabled = !currentSpeechText.trim();
                };

                speechRecognition.onerror = function(event) {
                    speechStatus.textContent = 'Error: ' + event.error;
                };

                speechRecognition.onend = function() {
                    speechStatus.textContent = 'Klik untuk mulai merekam';
                    speechStartBtn.classList.remove('hidden');
                    speechStopBtn.classList.add('hidden');
                };
            }

            speechStartBtn.addEventListener('click', function() {
                if (speechRecognition) {
                    speechRecognition.start();
                    speechStatus.textContent = 'Mendengarkan...';
                    speechStartBtn.classList.add('hidden');
                    speechStopBtn.classList.remove('hidden');
                }
            });

            speechStopBtn.addEventListener('click', function() {
                if (speechRecognition) {
                    speechRecognition.stop();
                }
            });

            sendSpeechBtn.addEventListener('click', function() {
                if (currentSpeechText.trim()) {
                    addMessage(currentSpeechText, 'user');
                    speakText(currentSpeechText);
                    currentSpeechText = '';
                    speechTranscript.textContent = 'Transkripsi akan muncul di sini...';
                    sendSpeechBtn.disabled = true;
                }
            });

            // Sign Language
            const signVideo = document.getElementById('signVideo');
            const signCanvas = document.getElementById('signCanvas');
            const signCtx = signCanvas.getContext('2d');
            const signStartBtn = document.getElementById('signStartBtn');
            const signStopBtn = document.getElementById('signStopBtn');
            const signResult = document.getElementById('signResult');
            const sendSignBtn = document.getElementById('sendSignBtn');

            let signHands;
            let signCamera;
            let signStream;
            let currentSignText = '';
            let lastSign = '';
            let signCount = 0;

            async function initializeSignHands() {
                signHands = new Hands({
                    locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`
                });

                signHands.setOptions({
                    maxNumHands: 2,
                    modelComplexity: 1,
                    minDetectionConfidence: 0.7,
                    minTrackingConfidence: 0.7
                });

                signHands.onResults(onSignResults);
            }

            function onSignResults(results) {
                signCtx.save();
                signCtx.clearRect(0, 0, signCanvas.width, signCanvas.height);
                signCtx.drawImage(results.image, 0, 0, signCanvas.width, signCanvas.height);

                if (results.multiHandLandmarks) {
                    for (const landmarks of results.multiHandLandmarks) {
                        drawConnectors(signCtx, landmarks, HAND_CONNECTIONS, { color: '#00FF00', lineWidth: 2 });
                        drawLandmarks(signCtx, landmarks, { color: '#FF0000', lineWidth: 1, radius: 3 });
                    }

                    if (results.multiHandLandmarks.length > 0) {
                        const gesture = detectSignGesture(results.multiHandLandmarks[0]);
                        updateSignDetection(gesture);
                    }
                } else {
                    signResult.textContent = '-';
                    signCount = 0;
                }

                signCtx.restore();
            }

            function detectSignGesture(landmarks) {
                const thumbTip = landmarks[4];
                const indexTip = landmarks[8];
                const middleTip = landmarks[12];
                const ringTip = landmarks[16];
                const pinkyTip = landmarks[20];

                const indexPIP = landmarks[6];
                const middlePIP = landmarks[10];
                const ringPIP = landmarks[14];
                const pinkyPIP = landmarks[18];

                const isIndexExtended = indexTip.y < indexPIP.y;
                const isMiddleExtended = middleTip.y < middlePIP.y;
                const isRingExtended = ringTip.y < ringPIP.y;
                const isPinkyExtended = pinkyTip.y < pinkyPIP.y;
                const isThumbExtended = thumbTip.x > landmarks[3].x;

                if (!isIndexExtended && !isMiddleExtended && !isRingExtended && !isPinkyExtended && isThumbExtended) {
                    return '👍';
                }

                if (isIndexExtended && isMiddleExtended && !isRingExtended && !isPinkyExtended && isThumbExtended) {
                    return '✌️';
                }

                if (isIndexExtended && isMiddleExtended && isRingExtended && isPinkyExtended && isThumbExtended) {
                    return '✋';
                }

                return '-';
            }

            function updateSignDetection(gesture) {
                if (gesture !== '-') {
                    if (gesture === lastSign) {
                        signCount++;
                    } else {
                        lastSign = gesture;
                        signCount = 1;
                    }

                    signResult.textContent = gesture;

                    if (signCount === 5) {
                        const gestureMap = {
                            '👋': 'Halo',
                            '👍': 'Ya',
                            '👎': 'Tidak',
                            '✋': 'Berhenti',
                            '👌': 'OK',
                            '✌️': 'Damai'
                        };

                        if (gestureMap[gesture]) {
                            currentSignText = gestureMap[gesture];
                            sendSignBtn.disabled = false;
                        }

                        signCount = 0;
                    }
                }
            }

            signStartBtn.addEventListener('click', async function() {
                try {
                    signStream = await navigator.mediaDevices.getUserMedia({
                        video: { width: 1280, height: 720, facingMode: 'user' }
                    });

                    signVideo.srcObject = signStream;
                    await signVideo.play();

                    signCanvas.width = signVideo.videoWidth;
                    signCanvas.height = signVideo.videoHeight;

                    await initializeSignHands();

                    signCamera = new Camera(signVideo, {
                        onFrame: async () => await signHands.send({ image: signVideo }),
                        width: 1280,
                        height: 720
                    });

                    signCamera.start();

                    signStartBtn.classList.add('hidden');
                    signStopBtn.classList.remove('hidden');
                } catch (err) {
                    console.error('Error accessing camera:', err);
                }
            });

            signStopBtn.addEventListener('click', function() {
                if (signCamera) signCamera.stop();
                if (signStream) signStream.getTracks().forEach(t => t.stop());
                signVideo.srcObject = null;
                signStartBtn.classList.remove('hidden');
                signStopBtn.classList.add('hidden');
                signResult.textContent = '-';
            });

            sendSignBtn.addEventListener('click', function() {
                if (currentSignText.trim()) {
                    addMessage(currentSignText, 'user');
                    speakText(currentSignText);
                    currentSignText = '';
                    signResult.textContent = '-';
                    sendSignBtn.disabled = true;
                }
            });

            // Chat
            const chatArea = document.getElementById('chatArea');
            const messageInput = document.getElementById('messageInput');
            const sendMessageBtn = document.getElementById('sendMessageBtn');

            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `flex ${sender === 'user' ? 'justify-end' : 'justify-start'}`;

                const bubble = document.createElement('div');
                bubble.className = sender === 'user'
                    ? 'px-4 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl rounded-br-md max-w-[70%]'
                    : 'px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-2xl rounded-bl-md max-w-[70%]';

                bubble.textContent = text;
                messageDiv.appendChild(bubble);
                chatArea.appendChild(messageDiv);
                chatArea.scrollTop = chatArea.scrollHeight;
            }

            function speakText(text) {
                if ('speechSynthesis' in window) {
                    const utterance = new SpeechSynthesisUtterance(text);
                    utterance.lang = 'id-ID';
                    speechSynthesis.speak(utterance);
                }
            }

            sendMessageBtn.addEventListener('click', function() {
                const text = messageInput.value.trim();
                if (text) {
                    addMessage(text, 'user');
                    speakText(text);
                    messageInput.value = '';
                }
            });

            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessageBtn.click();
                }
            });
        });
    </script>
</x-app-layout>
