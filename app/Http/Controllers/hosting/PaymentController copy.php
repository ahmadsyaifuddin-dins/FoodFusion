<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $pendingPayments = Orders::where('payment_method', 'transfer')
            ->where('status', 'awaiting payment')
            ->with(['user', 'orderItems.produk'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.payments.index', compact('pendingPayments'));
    }

    public function verifyPayment(Orders $order)
    {
        if (Auth::user()->role !== 'Administrator') {
            abort(403);
        }

        try {
            $order->update([
                'status' => 'processing',
                'payment_status' => 'paid'
            ]);

            // Update transaction
            $transaction =  Transaction::where('order_id', $order->id)->first();
            if ($transaction) {
                $transaction->status = 'completed';
                $transaction->payment_status = 'paid';
                $transaction->payment_date = now(); // Set payment date saat pelanggan konfirmasi terima
                $transaction->save();
            }

            return back()->with('success', 'Pembayaran berhasil diverifikasi');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rejectPayment(Orders $order)
    {
        if (Auth::user()->role !== 'Administrator') {
            abort(403);
        }

        try {
            $order->update([
                'status' => 'payment_rejected',
                'payment_status' => 'unpaid'
            ]);

            return back()->with('success', 'Pembayaran ditolak');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
