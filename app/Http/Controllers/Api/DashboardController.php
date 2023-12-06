<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    protected $dashboardRepo;

    public function __construct()
    {
        $this->dashboardRepo = new DashboardRepository();
    }

    public function ppdb() {
        $result = $this->dashboardRepo->ppdb();
        return response()->json($result);
    }

    public function incomePpdb(Request $request) {
        $filters = $request->only(['angkatan']);
        $result = $this->dashboardRepo->incomePpdb($filters);
        return response()->json($result);
    }
}