<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;

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

    public function incomePpdb() {
        $result = $this->dashboardRepo->incomePpdb();
        return response()->json($result);
    }
}