<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class SendWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $message;
    protected $notificationId;

    public $tries = 3;

    public function __construct($phone, $message, $notificationId)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->notificationId = $notificationId;
    }

    public function handle(): void
    {
        $token = env('FONNTE_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $this->phone,
            'message' => $this->message,
        ]);

        // Cari notifikasi
        $notifikasi = Notification::find($this->notificationId);

        if ($response->successful()) {
            Log::info("Pesan WhatsApp terkirim ke {$this->phone}");
            if ($notifikasi) {
                $notifikasi->update([
                    'status' => 'terkirim',
                    'waktu_kirim' => now(),
                ]);
            }
        } else {
            Log::error("Gagal kirim ke {$this->phone}: " . $response->body());
            if ($notifikasi) {
                $notifikasi->update([
                    'status' => 'gagal',
                    'retry_count' => $notifikasi->retry_count + 1,
                ]);
            }
            throw new \Exception('Gagal kirim pesan');
        }
    }
}
