<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, ShouldAutoSize, WithColumnWidths, WithHeadings, WithMapping
{
    public function __construct(
        public $status
    ) {

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $transactions = Transaction::query()->orderBy('created_at', 'desc');

        if ($this->status != null && $this->status != '') {
            $transactions = $transactions->where('status', $this->status);
        }

        return $transactions->get();
    }

    public function headings(): array
    {
        return [
            'Customer',
            'Transaction ID',
            'Payment Method',
            'Status',
            'Created at',
            'Amount',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            'C' => 10,
            'D' => 10,
            'E' => 20,
            'F' => 20,
        ];
    }

    public function map($row): array
    {
        return [
            $row->user?->name,
            $row->transaction_id,
            $row->payment_method == 1 ? Transaction::COD : Transaction::ONLINE,
            getTransactionStatus($row->status),
            $row->created_at,
            $row->amount,
        ];
    }
}
