<?php

namespace App\Http\Controllers;

use App\Models\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecordingController extends Controller
{
    public function index()
    {
        $recordings = auth()->user()->recordings()->latest()->paginate(10);
        return view('recordings.index', compact('recordings'));
    }

    public function create()
    {
        return view('recordings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:mp3,wav,m4a,mp4,mkv|max:102400', // 100MB max
            'language' => 'required|string|in:id,en,ja,ko,ar',
        ]);

        $recording = new Recording();
        $recording->user_id = auth()->id();
        $recording->title = $request->title;
        $recording->description = $request->description;
        $recording->language = $request->language;
        $recording->status = 'pending';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('recordings', 'public');
            $recording->file_path = $path;
            $recording->file_type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'audio';
        } else {
            // Handle real-time recorded audio (would be sent as blob)
            // For now, we'll set a placeholder
        }

        $recording->save();

        // In a real app, we would dispatch a job to process the recording
        // ProcessRecording::dispatch($recording);

        return redirect()->route('recordings.show', $recording)->with('success', 'Rekaman berhasil diunggah!');
    }

    public function show(Recording $recording)
    {
        // Check if user owns the recording
        if ($recording->user_id !== auth()->id()) {
            abort(403);
        }

        $transcript = $recording->transcript;
        $summary = $recording->summary;

        return view('recordings.show', compact('recording', 'transcript', 'summary'));
    }

    public function edit(Recording $recording)
    {
        if ($recording->user_id !== auth()->id()) {
            abort(403);
        }

        return view('recordings.edit', compact('recording'));
    }

    public function update(Request $request, Recording $recording)
    {
        if ($recording->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $recording->update($request->only(['title', 'description']));

        return redirect()->route('recordings.show', $recording)->with('success', 'Rekaman berhasil diperbarui!');
    }

    public function destroy(Recording $recording)
    {
        if ($recording->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete file from storage
        if ($recording->file_path && Storage::disk('public')->exists($recording->file_path)) {
            Storage::disk('public')->delete($recording->file_path);
        }

        $recording->delete();

        return redirect()->route('recordings.index')->with('success', 'Rekaman berhasil dihapus!');
    }
}
