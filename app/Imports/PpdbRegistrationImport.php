<?php

namespace App\Imports;

use App\Models\PpdbRegistration;
use Maatwebsite\Excel\Concerns\ToModel;

class PpdbRegistrationImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PpdbRegistration([
            'id' => $row[0],
            'nama lengkap' => $row[1],
            'jenjang' => $row[2],
            'nomor induk siswa' => $row[3],
            'kelas' => $row[3]
        ]);
    }
}
