<?php

namespace App\Repositories;

use App\Models\Kelas;
use App\Models\Teacher;
use App\Models\WaliKelas;

class TeacherRepository {
    public function index() {
        $students = Teacher::with(['jabatan']);

        $students = $students->paginate(50);
        return $students;
    }

    public function store($data) {
        try {

            if ($data['id']) {
                $teacher = Teacher::find($data['id']);
                if (!$teacher) return resultFunction("Err code SR-D: data tidak ditemukan " . $data['id']);

                unset($data['created_at']);
                unset($data['updated_at']);
                unset($data['deleted_at']);
                unset($data['id']);
                Teacher::where('id', $teacher->id)->update($data);
            } else {
                $teacher = new Teacher();
                Teacher::create($data);
            }

            return resultFunction("", true, $teacher);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }

    public function indexWaliKelas() {
        $students = WaliKelas::with(['teacher', 'kelas']);

        $students = $students->paginate(50);
        return $students;
    }

    public function storeWaliKelas($data) {
        try {

            $kelas = Kelas::find($data['kelas_id']);
            if (!$kelas) return resultFunction("Err code SR-D: data tidak ditemukan " . $data['kelas_id']);

            if ($data['id']) {
                $waliKelas = WaliKelas::find($data['id']);
                if (!$waliKelas) return resultFunction("Err code SR-D: data tidak ditemukan " . $data['id']);

                unset($data['created_at']);
                unset($data['updated_at']);
                unset($data['teacher']);
                unset($data['kelas']);
                unset($data['id']);
                WaliKelas::where('id', $waliKelas->id)->update($data);
            } else {
                $waliKelas = WaliKelas::create($data);
                $kelas->wali_kelas_id = $waliKelas->id;
                $kelas->save();
            }

            return resultFunction("", true, $waliKelas);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }
}