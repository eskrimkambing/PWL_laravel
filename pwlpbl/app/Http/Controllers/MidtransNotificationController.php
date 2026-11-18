<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        try {
            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey =
                config('services.midtrans.server_key')
                ?: env('MIDTRANS_SERVER_KEY');

            \Midtrans\Config::$isProduction = filter_var(
                env('MIDTRANS_IS_PRODUCTION', false),
                FILTER_VALIDATE_BOOLEAN
            );

            if (empty(\Midtrans\Config::$serverKey)) {
                throw new \Exception('Midtrans Server Key belum diatur.');
            }

            // Membaca dan memverifikasi notifikasi Midtrans
            $notification = new \Midtrans\Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;

            // Format Order ID harus PZM-123
            if (!preg_match('/^PZM-(\d+)$/', $orderId, $matches)) {
                return response()->json([
                    'message' => 'Order ID tidak valid.'
                ], 400);
            }

            $idPesanan = (int) $matches[1];

            DB::transaction(function () use (
                $idPesanan,
                $transactionStatus,
                $fraudStatus
            ) {
                $pesanan = Pesanan::where(
                    'id_pesanan',
                    $idPesanan
                )->lockForUpdate()->first();

                if (!$pesanan) {
                    Log::warning(
                        'Pesanan Midtrans tidak ditemukan: ' . $idPesanan
                    );

                    return;
                }

                // Jangan menurunkan status pembayaran yang sudah berhasil.
                if ($pesanan->status_pembayaran === 'Dibayar') {
                    return;
                }

                // Pembayaran berhasil
                if (
                    $transactionStatus === 'settlement' ||
                    (
                        $transactionStatus === 'capture' &&
                        $fraudStatus === 'accept'
                    )
                ) {
                    $pesanan->update([
                        'status_pembayaran' => 'Dibayar',
                        'dibayar_pada' => now(),
                    ]);
                }

                // Pembayaran masih menunggu
                elseif ($transactionStatus === 'pending') {
                    $pesanan->update([
                        'status_pembayaran' => 'Menunggu Pembayaran',
                    ]);
                }

                // Pembayaran gagal atau kedaluwarsa
                elseif (in_array($transactionStatus, [
                    'deny',
                    'expire',
                    'cancel',
                    'failure',
                ], true)) {
                    $pesanan->update([
                        'status_pembayaran' => 'Gagal',
                        'dibayar_pada' => null,
                    ]);
                }
            });

            return response()->json([
                'message' => 'Notifikasi berhasil diproses.'
            ], 200);

        } catch (\Throwable $e) {

            Log::error(
                'Midtrans notification error: ' . $e->getMessage()
            );

            return response()->json([
                'message' => 'Gagal memproses notifikasi.'
            ], 500);
        }
    }
}

