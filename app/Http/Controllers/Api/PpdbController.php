<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
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

    public function index(Request $request) {
        $ppdbRegistrations = $this->ppdbRepo->index($request);
        return response()->json($ppdbRegistrations);
    }

    public function jenjangDataFunction() {
        return [
            "jenjang" => jenjangData(),
            "gelombang" => gelombangData()
        ];
    }

    public function detail($nomorPendaftaran) {
        $result = $this->ppdbRepo->detail($nomorPendaftaran);
        return response()->json($result);
    }

    public function searchRegistration(Request $request) {
        $result = $this->ppdbRepo->searchRegistration($request->all());
        return response()->json($result);
    }

    public function verify(Request $request) {
        $result = $this->ppdbRepo->verify($request->all());
        return response()->json($result);
    }

    public function uploadProven($type, Request $request) {
        $result = $this->ppdbRepo->uploadProven($type, $request->all());
        return response()->json($result);
    }

    public function reuploadProven($regisId, $id, $type) {
        $result = $this->ppdbRepo->reuploadProven($regisId, $id, $type);
        return response()->json($result);
    }

    public function verifyProven($type, Request $request) {
        $result = $this->ppdbRepo->verifyProven($type, $request->all());
        return response()->json($result);
    }

    public function verifyInterview(Request $request) {
        $result = $this->ppdbRepo->verifyInterview($request->all());
        return response()->json($result);
    }

    public function importReceivedStudent(Request $request) {
        return response()->json($this->ppdbRepo->importReceivedStudent($request));
    }

    public function importData(Request $request) {
        return response()->json($this->ppdbRepo->importData($request->all()));
    }
}