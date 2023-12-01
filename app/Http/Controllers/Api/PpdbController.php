<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PpdbRepository;
use Illuminate\Http\Request;

class PpdbController extends Controller {
    protected $ppdbRepo;

    public function __construct()
    {
        $this->ppdbRepo = new PpdbRepository();
    }

    public function store(Request $request) {
        $result = $this->ppdbRepo->store($request->all());
        return response()->json($result);
    }

    public function jenjangDataFunction() {
        return [
            "jenjang" => jenjangData(),
            "gelombang" => gelombangData()
        ];
    }
}