<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subdistrict;
use Illuminate\Http\Request;

class AddressController extends Controller {
    public function searchSubdistrict(Request $request) {
        $subdistricts = Subdistrict::with(['city.province'])
            ->where(function ($query) use ($request) {
                $query->where('subdistrict_name', 'LIKE', '%' . $request->get('keyword') . '%')
                    ->orWhere(function ($q) use ($request) {
                        $q->whereHas('city', function ($qu) use ($request) {
                            $qu->where('city_name', 'LIKE', '%' . $request->get('keyword') . '%');
                        });
                    });
            })
            ->get();
        $resp = [];
        foreach ($subdistricts as $sub) {
            $resp[] = $sub->subdistrict_name . ", " . $sub->city->type . " " . $sub->city->city_name . ', ' . $sub->city->province->province_name;
        }
        return response()->json($resp);
    }
}