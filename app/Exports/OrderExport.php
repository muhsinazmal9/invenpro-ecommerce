<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, ShouldAutoSize, WithColumnWidths, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::where('order_status', Order::ORDER_STATUS['delivered'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Invoice ID',
            'Customer',
            'Subtotal',
            'Shipping Charge',
            'Tax',
            'Total Amount',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 10,
            'D' => 10,
            'E' => 10,
            'F' => 20,
        ];
    }

    public function map($row): array
    {
        return [
            $row->invoice_id,
            $row->user?->name,
            $row->subtotal,
            $row->shipping_charge,
            $row->tax,
            $row->grand_total,
        ];
    }
}
