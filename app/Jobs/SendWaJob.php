<?php

namespace App\Jobs;

use App\Models\Undangan\list_tamu\list_undangan as Tamu;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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

            // --- 1. LOGIC SPINTAX (VARIASI TEKS AGAR TIDAK DI-BAN) ---
            $pembukaVariasi = [
                "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami.",
                "Dengan penuh rasa syukur, kami bermaksud mengundang Bapak/Ibu/Saudara/i, teman serta kerabat, untuk memberikan doa restu di acara pernikahan kami.",
                "Kabar bahagia dari kami! Kami berharap Bapak/Ibu/Saudara/i, teman sekaligus sahabat, berkenan hadir di hari istimewa pernikahan kami."
            ];

            $penutupVariasi = [
                "Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.",
                "Kehadiran serta doa restu Bapak/Ibu/Saudara/i akan menjadi kado terindah dan kebahagiaan tersendiri bagi kami.",
                "Sangat besar harapan kami agar Bapak/Ibu/Saudara/i dapat hadir untuk turut merayakan hari bahagia ini bersama kami."
            ];

            $txtPembuka = $pembukaVariasi[array_rand($pembukaVariasi)];
            $txtPenutup = $penutupVariasi[array_rand($penutupVariasi)];
            $refId = Str::random(5); // Identifier unik tiap pesan

            // --- 2. PREPARE DATA ---
            $guestName = $tamu->nama_tamu;
            $weddingName = "{$tamu->wedding->m_pria_panggilan} & {$tamu->wedding->m_wanita_panggilan}";
            $baseUrl = config('app.url'); // Pastikan APP_URL di .env sudah benar (e.g., https://weddingku.com)
            $weddingLink = "{$baseUrl}/wedding/{$tamu->wedding->slug}/invitation/to/" . urlencode($guestName);

            // --- 3. SUSUN PESAN (Template Sesuai Request Lu) ---
            $message = "Kepada Yth.\n";
            $message .= "Bapak/Ibu/Saudara/i\n";
            $message .= "*{$guestName}*\n";
            $message .= "_______\n\n";
            $message .= "{$txtPembuka}\n\n";
            $message .= "Berikut link undangan kami, untuk info lengkap dari acara, bisa kunjungi :\n\n";
            $message .= "{$weddingLink}\n\n";
            $message .= "{$txtPenutup}\n\n";
            $message .= "Terima Kasih\n\n";
            $message .= "Hormat kami,\n";
            $message .= "{$weddingName}\n";
            $message .= "________\n";
            $message .= "_(Ref: {$refId})_";

            // --- 4. KIRIM KE API WABLAS ---
            // Pastikan nomor HP diawali 62. Jika 08, kita replace.
            $phone = preg_replace('/^0/', '62', $tamu->phone);

            /* $response = Http::withHeaders([
                'Authorization' => config('services.wablas.token'),
            ])->post(config('services.wablas.domain') . '/api/send-message', [
                'phone' => $phone,
                'message' => $message,
            ]);
            */
            \Log::info("Testing kirim WA ke: " . $tamu->phone . " dengan pesan: " . $message);

            // --- 5. UPDATE STATUS JIKA BERHASIL ---
            /* if ($response->successful()) {
            //     $tamu->update(['is_sent' => 1]);
            }*/
            $tamu->update(['is_sent' => 1]);

            // --- 6. JEDA AMAN (3-5 MENIT) ---
            // rand(180, 300) = 180 detik (3 min) sampai 300 detik (5 min)
            sleep(rand(180, 300));
        }
    }
}
