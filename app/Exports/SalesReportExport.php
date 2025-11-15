<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data['transactions'];
    }

    public function headings(): array
    {
        return [
            'No Transaksi',
            'Tanggal & Waktu',
            'Kasir',
            'Metode Pembayaran',
            'Total Amount',
            'Status',
            'Item Details'
        ];
    }

    public function map($transaction): array
    {
        $items = $transaction->items->map(function ($item) {
            return $item->menu->name . ' (x' . $item->quantity . ')';
        })->implode(', ');

        return [
            $transaction->id,
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->user->name ?? 'N/A',
            ucfirst($transaction->payment_method),
            'Rp ' . number_format($transaction->total_amount, 0, ',', '.'),
            ucfirst($transaction->status),
            $items
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            
            // Set alignment for all cells
            'A:G' => [
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ],
            
            // Format currency column
            'E:E' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Penjualan ' . $this->data['startDate']->format('d M Y') . ' - ' . $this->data['endDate']->format('d M Y');
    }
}