<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\Kelas;
use App\Models\Level;

class GeneralController extends Controller {
    public function jenjang() {
        $jenjangs = Jenjang::all();
        return response()->json($jenjangs);
    }

    public function level() {
        $levels = Level::with(['jenjang'])->get();
        return response()->json($levels);
    }

    public function kelas() {
        $kelas = Kelas::with(['level', 'jenjang', 'wali_kelas.teacher'])->get();
        return response()->json($kelas);
    }
}