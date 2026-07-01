<x-app-layout>
    <x-slot name="header">
        {{ $recording->title }}
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header Actions -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $recording->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $recording->created_at->translatedFormat('d F Y H:i') }}
                    @if($recording->duration)
                        · {{ gmdate('i:s', $recording->duration) }}
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('recordings.edit', $recording) }}" class="p-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </a>
                <form action="{{ route('recordings.destroy', $recording) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rekaman ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Left Column - Audio/Video Player & Transcript -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Player -->
                @if($recording->file_path)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                        <div class="p-6">
                            @if($recording->file_type === 'video')
                                <video controls class="w-full rounded-xl bg-gray-900">
                                    <source src="{{ Storage::url($recording->file_path) }}">
                                </video>
                            @else
                                <audio controls class="w-full">
                                    <source src="{{ Storage::url($recording->file_path) }}">
                                </audio>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Transcript Editor -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transkripsi</h3>
                        <div class="flex items-center gap-2">
                            <button type="button" class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                            </button>
                            <button type="button" class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <textarea id="transcriptEditor" class="w-full min-h-[300px] bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:text-white transition-all resize-none p-4"
                            placeholder="Transkripsi akan muncul di sini...">{{ $transcript ? $transcript->content : 'Belum ada transkripsi' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column - Summary, Keywords, Sentiment -->
            <div class="space-y-6">
                <!-- Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Ringkasan
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($summary)
                            <p class="text-gray-700 dark:text-gray-300">{{ $summary->summary }}</p>

                            @if($summary->key_points)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Poin Penting</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $summary->key_points }}</p>
                                </div>
                            @endif

                            @if($summary->action_items)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Tindakan</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $summary->action_items }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Belum ada ringkasan</p>
                            <button class="w-full py-2 px-4 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-medium rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all">
                                Generate Ringkasan
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Keywords -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Kata Kunci
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($transcript && $transcript->keywords)
                            <div class="flex flex-wrap gap-2">
                                @foreach(json_decode($transcript->keywords) as $keyword)
                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Belum ada kata kunci</p>
                        @endif
                    </div>
                </div>

                <!-- Sentiment -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Sentimen
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($transcript && $transcript->sentiment)
                            @php
                                $sentimentConfig = [
                                    'positive' => ['bg-green-100', 'text-green-700', 'dark:bg-green-900/30', 'dark:text-green-300', 'Positif'],
                                    'negative' => ['bg-red-100', 'text-red-700', 'dark:bg-red-900/30', 'dark:text-red-300', 'Negatif'],
                                    'neutral' => ['bg-gray-100', 'text-gray-700', 'dark:bg-gray-700', 'dark:text-gray-300', 'Netral'],
                                ];
                                $config = $sentimentConfig[$transcript->sentiment] ?? $sentimentConfig['neutral'];
                            @endphp
                            <span class="px-4 py-2 {{ $config[0] }} {{ $config[1] }} {{ $config[2] }} {{ $config[3] }} rounded-xl text-sm font-medium">
                                {{ $config[4] }}
                            </span>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Belum ada analisis sentimen</p>
                        @endif
                    </div>
                </div>

                <!-- Export -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export
                        </h3>
                    </div>
                    <div class="p-6 space-y-2">
                        <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-xl transition-all">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">PDF</span>
                        </button>
                        <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-xl transition-all">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">DOCX</span>
                        </button>
                        <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-xl transition-all">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">TXT</span>
                        </button>
                        <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-xl transition-all">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-700 dark:text-gray-300">SRT (Subtitle)</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
