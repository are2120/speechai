<x-app-layout>
    <x-slot name="header">
        Rekaman & Transkripsi
    </x-slot>

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Semua Rekaman</h1>
            <a href="{{ route('recordings.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Rekaman & Transkripsi Baru
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            @if($recordings->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recordings as $recording)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-4 flex-1">
                                    <div class="w-12 h-12 bg-gradient-to-br {{ $recording->file_type === 'video' ? 'from-purple-500 to-pink-600' : 'from-blue-500 to-cyan-600' }} rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($recording->file_type === 'video')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                            @endif
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('recordings.show', $recording) }}" class="text-lg font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                            {{ $recording->title }}
                                        </a>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $recording->description ? Str::limit($recording->description, 100) : 'Tidak ada deskripsi' }}
                                        </p>
                                        <div class="flex items-center gap-4 mt-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $recording->created_at->translatedFormat('d F Y H:i') }}</span>
                                            @if($recording->duration)
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ gmdate('i:s', $recording->duration) }}</span>
                                            @endif
                                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ match($recording->status) {
                                                'completed' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                                'processing' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                                                'failed' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                                                default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                            } }}">
                                                {{ ucfirst($recording->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('recordings.show', $recording) }}" class="p-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-6">
                    {{ $recordings->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Rekaman</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Mulai buat rekaman pertama Anda</p>
                    <a href="{{ route('recordings.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Rekaman Baru
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
