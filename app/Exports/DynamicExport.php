<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DynamicExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;
    protected $headings;
    public function __construct($data, $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
    }
    public function collection()
    {
        return collect($this->data);
    }
    public function headings(): array
    {
        return $this->headings;
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFF00'],
                ],
            ],
        ];
    }
}