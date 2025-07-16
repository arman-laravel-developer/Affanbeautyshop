<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Fetch orders and calculate the total
        $orders = Order::select('order_code', 'total_qty', 'grand_total', 'created_at', 'order_status', 'payment_status')
            ->get()
            ->map(function ($order) {
                return [
                    'order_code' => $order->order_code,
                    'num_of_qty' => $order->total_qty,
                    'order_total' => $order->grand_total,
                    'order_date' => $order->created_at->format('d/m/Y'),
                    'order_status' => Str::ucfirst($order->order_status),
                    'payment_status' => Str::ucfirst($order->payment_status)
                ];
            });

        // Calculate the total order amount
        $totalOrderAmount = $orders->sum('order_total');

        // Append the total as the last row
        $orders->push([
            'order_code' => 'Total',
            'num_of_qty' => '',
            'order_total' => $totalOrderAmount,
            'order_date' => '',
            'order_status' => '',
            'payment_status' => ''
        ]);

        return $orders;
    }

    // Add headings to the export file
    public function headings(): array
    {
        return [
            'Order Code',
            'Num of Qty',
            'Order Total',
            'Order Date',
            'Order Status',
            'Payment Status'
        ];
    }
}
