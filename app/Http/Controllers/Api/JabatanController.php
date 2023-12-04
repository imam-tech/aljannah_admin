<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\JabatanRepository;
use Illuminate\Http\Request;

class JabatanController extends Controller {
    protected $jabatanRepo;

    public function __construct()
    {
        $this->jabatanRepo = new JabatanRepository();
    }

    public function index() {
        $result = $this->jabatanRepo->index();
        return response()->json($result);
    }

    public function store(Request $request) {
        $result = $this->jabatanRepo->store($request->all());
        return response()->json($result);
    }
}