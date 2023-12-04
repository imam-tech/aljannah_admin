<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TeacherRepository;
use Illuminate\Http\Request;

class TeacherController extends Controller {
    protected $teacherRepo;

    public function __construct()
    {
        $this->teacherRepo = new TeacherRepository();
    }

    public function index() {
        $result = $this->teacherRepo->index();
        return response()->json($result);
    }

    public function store(Request $request) {
        $result = $this->teacherRepo->store($request->all());
        return response()->json($result);
    }

    public function indexWaliKelas() {
        $result = $this->teacherRepo->indexWaliKelas();
        return response()->json($result);
    }

    public function storeWaliKelas(Request $request) {
        $result = $this->teacherRepo->storeWaliKelas($request->all());
        return response()->json($result);
    }
}