<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignLanguageController extends Controller
{
    public function index()
    {
        return view('sign-language.index');
    }

    public function learn()
    {
        $lessons = [
            ['id' => 1, 'title' => 'Halo', 'description' => 'Belajar bahasa isyarat untuk kata Halo', 'progress' => 100],
            ['id' => 2, 'title' => 'Terima Kasih', 'description' => 'Belajar bahasa isyarat untuk kata Terima Kasih', 'progress' => 60],
            ['id' => 3, 'title' => 'Selamat Pagi', 'description' => 'Belajar bahasa isyarat untuk kata Selamat Pagi', 'progress' => 0],
            ['id' => 4, 'title' => 'Nama Saya', 'description' => 'Belajar bahasa isyarat untuk kata Nama Saya', 'progress' => 0],
        ];

        return view('sign-language.learn', compact('lessons'));
    }
}
