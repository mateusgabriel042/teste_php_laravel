<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportOrders implements FromCollection, WithHeadings
{
    protected $orders;

    public function __construct(Collection $orders)
    {
        $this->orders = $orders;
    }

    public function collection(): Collection
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'id',
            'order_number',
            'user_id',
            'sub_total',
            'shipping_id',
            'coupon',
            'total_amount',
            'quantity',
            'payment_method',
            'payment_status',
            'status',
            'first_name',
            'last_name',
            'email',
            'phone',
            'country',
            'post_code',
            'address1',
            'address2',
            'created_at',
            'update_at'
        ];
    }
}
