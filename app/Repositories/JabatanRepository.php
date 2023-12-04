<?php

namespace App\Repositories;

use App\Models\Jabatan;

class JabatanRepository {
    public function index() {
        $jabatan = Jabatan::with([]);
        $jabatan = $jabatan->orderBy('id', 'desc')->get();
        return $jabatan;
    }

    public function store($data) {
        try {
            if ($data['id']) {
                $jabatan = Jabatan::find($data['id']);
                if (!$jabatan) return resultFunction('Err code JR-S: jabatan tidak ditemukan');
            } else {
                $jabatan = new Jabatan();
            }
            $jabatan->nama = $data['nama'];
            $jabatan->save();
            return resultFunction("", true);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-S: catch " . $e->getMessage());
        }
    }
}