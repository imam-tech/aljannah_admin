<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\StudentRepository;

class StudentController extends Controller {
    protected $studentRepo;

    public function __construct()
    {
        $this->studentRepo = new StudentRepository();
    }

    public function index() {
        $result = $this->studentRepo->index();
        return response()->json($result);
    }

    public function detail($id) {
        $result = $this->studentRepo->detail($id);
        return response()->json($result);
    }
}