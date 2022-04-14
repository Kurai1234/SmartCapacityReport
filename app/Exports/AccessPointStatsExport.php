<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use ReportQuery;
use Carbon\Carbon;

class AccessPointStatsExport implements FromView, Responsable
{
    use Exportable;

    private $fileName;

    private $writerType;

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    protected $params;

    public function __construct($array, $format)
    {
        $this->params = $array;
        $this->verifyFormat($format);
    }

    public function view(): View
    {
        $data = ReportQuery::perform($this->params);
        return view('auth.pages.Export.ApStatisticExport', [
            'peakData' => $data
        ]);
    }

    public function verifyFormat($format)
    {
        switch ($format) {
                //calls the filter function
            case 'csv':
                $this->fileName = Carbon::now() . '.csv';
                $this->writerType = Excel::CSV;
                break;
                //sends download of file
            case 'xlsx':
                $this->fileName = Carbon::now() . '.xlsx';
                $this->writerType = Excel::XLSX;
                break;
                //sends download of file
            case 'html':
                $this->fileName = Carbon::now() . '.html';
                $this->writerType = Excel::HTML;
                break;
                //sends download of file
            default:
                $this->fileName = Carbon::now() . '.csv';
                $this->writerType = Excel::CSV;
                return;
        }
    }

}
