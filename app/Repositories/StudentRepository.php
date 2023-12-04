<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository {
    public function index() {
        $students = Student::with([]);

        $students = $students->paginate(25);
        return $students;
    }

    public function detail($id) {
        try {
            $student = Student::with(['student_details', 'student_ppdb_registration.ppdb_registration', 'user_parent'])
                ->find($id);
            if (!$student) return resultFunction("Err code SR-D: data tidak ditemukan " . $id);
            return resultFunction("", true, $student);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-D: catch " . $e->getMessage());
        }
    }
}