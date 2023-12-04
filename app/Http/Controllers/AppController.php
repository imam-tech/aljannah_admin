<?php

namespace App\Http\Controllers;

use App\Repositories\PpdbRepository;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AppController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function indexParent()
    {
        return view('app');
    }

    public function receivedStudent(Request $request) {
        $ppdbRegistrations = (new PpdbRepository())->index($request, true);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $fileName = 'export-received-student-'.date('Y-m-d H:i:s');
        $headerStyle = [
            'font' => [
                'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 11,
            ],
            'alignment' => [
                'wrapText'  => true,
                'vertical'      => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];

        $fillStyle = [
            'font' => [
                'name'  => 'Times New Roman',
                'size'  => 11,
            ],
            'alignment' => [
                'wrapText'  => true,
                'vertical'      => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $sheet->setCellValue('A1', 'ID')->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->setCellValue('B1', 'nama')->getStyle('B1')->applyFromArray($headerStyle);
        $sheet->setCellValue('C1', 'jenjang')->getStyle('C1')->applyFromArray($headerStyle);
        $sheet->setCellValue('D1', 'nomor induk siswa')->getStyle('D1')->applyFromArray($headerStyle);
        $sheet->setCellValue('E1', 'kelas')->getStyle('E1')->applyFromArray($headerStyle);


        $num = 2;
        foreach ($ppdbRegistrations as $key => $item){
            $sheet->setCellValue('A'.$num, $item->id)
                ->getStyle('A'.$num)->applyFromArray($fillStyle);
            $sheet->setCellValue('B'.$num, $item->nama_lengkap)
                ->getStyle('B'.$num)->applyFromArray($fillStyle);
            $sheet->setCellValue('C'.$num, $item->jenjang)
                ->getStyle('C'.$num)->applyFromArray($fillStyle);
            $sheet->setCellValue('D'.$num, '')
                ->getStyle('D'.$num)->applyFromArray($fillStyle);
            $sheet->setCellValue('D'.$num, '')
                ->getStyle('D'.$num)->applyFromArray($fillStyle);
            $sheet->setCellValue('E'.$num, ($item->jenjang === 'SMA' ? 'X' : ($item->jenjang === 'SMP' ? 'VII' : 'I')) . '-')
                ->getStyle('E'.$num)->applyFromArray($fillStyle);
            $num++;
        }


        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'".xlsx"');
        $writer->save("php://output");
        exit;
    }
}
