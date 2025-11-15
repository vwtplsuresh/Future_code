<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OverLimitMail extends Mailable
{

    public $overLimitData;

    public function __construct($overLimitData)
    {
        $this->overLimitData = $overLimitData;

    }

    public function build()
    {


        $file = $this->generateExcel();

        return $this->subject("Over Limit Flow Report - All Units")
            ->view('emails.over-limit-report')
            ->attach($file, [
                'as' => 'overlimit_report.xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }

    private function generateExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Unit ID');
        $sheet->setCellValue('B1', 'Unit Name');
        $sheet->setCellValue('C1', 'Today Limit');
        $sheet->setCellValue('D1', 'Total Flow');
        $sheet->setCellValue('E1', 'Over Limit Flow');

        // Values
        // $overFlow = $this->todayData->totalizer - $this->unit->today_limit;
        $row = 2;
    foreach($this->overLimitData as $overLimitDatas){
        
        $sheet->setCellValue('A' . $row, $overLimitDatas['unit_id']);
        $sheet->setCellValue('B' . $row, $overLimitDatas['unit_name']);
        $sheet->setCellValue('C' . $row, $overLimitDatas['today_limit']);
        $sheet->setCellValue('D' . $row, $overLimitDatas['total_flow']);
        $sheet->setCellValue('E' . $row, $overLimitDatas['over_flow']);

$row++;

    }
    $now = now()->format('Y-m-d_H-i-s');
    $filePath = storage_path('app/overlimit_report_' . $now . '.xlsx');

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);


        return $filePath;
    }
}
