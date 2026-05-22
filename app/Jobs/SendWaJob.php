<?php

namespace App\Jobs;

use App\Models\Undangan\list_tamu\list_undangan as Tamu;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendWaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ids;

    /**
     * Create a new job instance.
     * @param array $ids
     */
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        foreach ($this->ids as $id) {
            // Ambil data tamu beserta data wedding-nya
            $tamu = Tamu::with('wedding')->find($id);

            if (!$tamu || !$tamu->wedding) {
                continue;
            }

            // --- 1. PREPARE DATA DINAMIS ---
            $guestName = $tamu->nama_tamu;
            $weddingName = "{$tamu->wedding->m_pria_panggilan} & {$tamu->wedding->m_wanita_panggilan}";
            $baseUrl = config('app.url'); // Mengambil dari APP_URL di env

            // Generate link dinamis sesuai data slug wedding dan nama tamu
            $weddingLink = "{$baseUrl}/wedding/{$tamu->wedding->slug}/invitation/to/" . urlencode($guestName);

            // --- 2. SUSUN TEMPLATE PESAN (Sesuai Format di Blade/jQuery) ---
            $message = "Kepada Yth.\n";
            $message .= "Bapak/Ibu/Saudara/i\n";
            $message .= "*{$guestName}*\n";
            $message .= "_______\n\n";
            $message .= "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami.\n\n";
            $message .= "Berikut link undangan kami, untuk info lengkap dari acara, bisa kunjungi :\n\n";
            $message .= "{$weddingLink}\n\n";
            $message .= "Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n";
            $message .= "Terima Kasih\n\n";
            $message .= "Hormat kami,\n";
            $message .= "{$weddingName}\n";
            $message .= "________";

            // --- 3. FORMAT TELEPON STANDAR OPENWA ---
            // Ubah awalan 08 / 0 menjadi 62
            $phone = preg_replace('/^0/', '62', trim($tamu->phone));

            // Tambahkan suffix @c.us jika belum ada (wajib untuk OpenWA)
            if (!str_contains($phone, '@c.us')) {
                $phone = $phone . '@c.us';
            }

            // --- 4. EXECUTE KONEKSI KE API OPENWA ---
            $apiUrl = config('services.openwa.base_url') . '/sendText';
            $apiKey = config('services.openwa.api_key');

            $httpClient = Http::asJson();
            if (!empty($apiKey)) {
                $httpClient->withToken($apiKey);
            }

            try {
                // Sesuai dokumentasi payload arguments OpenWA
                $response = $httpClient->post($apiUrl, [
                    'args' => [
                        'to'      => $phone,
                        'content' => $message,
                    ]
                ]);

                // --- 5. UPDATE STATUS JIKA BERHASIL ---
                if ($response->successful()) {
                    \Log::info("OpenWA Berhasil mengirim ke: " . $phone);

                    // Update field flag status kirim di database tamu
                    $tamu->update(['is_sent' => 1]);
                } else {
                    \Log::error("OpenWA Gagal mengirim ke: " . $phone . " | Response: " . $response->body());
                }

            } catch (\Exception $e) {
                \Log::error("Error OpenWA API Connection: " . $e->getMessage());
            }

            // --- 6. JEDA AMAN INTERNAL LOOP (ANTI-BAN) ---
            // Mengambil angka random detik antara 3 menit sampai 5 menit
            sleep(rand(180, 300));
        }
    }
}
