<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

use Barryvdh\DomPDF\Facade\Pdf;

class OrderManageController extends Controller
{
    public function index()
    {  
        
       
        $orders = Order::with(['items'])
                      ->latest()
                      ->get();
                      
        return view('back-end.order.index', compact('orders'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($request->id);
        $order->order_status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully'
        ]);
    }

    public function orderDetails($id)
    {
        $order = Order::with(['items.product', 'items.variant'])
                     ->findOrFail($id);

                     
                     
        return view('back-end.order.order_details', compact('order'));
    }


    public function downloadPDF($id)
{
    try {
        $order = Order::with(['items.product', 'items.variant.color', 'items.variant.size'])
                     ->findOrFail($id);

        $pdf = PDF::loadView('back-end.order.pdf', [
            'order' => $order
        ]);

        $pdf->setPaper('A4', 'portrait');
        
        // Enable image loading
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'bangla'
        ]);

        $filename = 'Order-' . $order->order_number . '.pdf';

        return $pdf->stream($filename);

    } catch (\Exception $e) {
        return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
    }
}


    
}
