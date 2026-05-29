<?php

namespace App\Http\Controllers\DigitalCardController\ListUndangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsappController extends Controller
{
    public function kirimPesan()
    {
        $nomorTujuan = '6282280173854';
        $isiPesan    = 'Test API WA Gateway';

        // Kita kirim 'secret' di dalam body JSON
        $payload = [
            'secret' => 'ci3dgRbI',
            'data'   => [
                [
                    'phone'   => $nomorTujuan,
                    'message' => $isiPesan,
                ]
            ]
        ];

        try {
            // Menggunakan opsi cURL: CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
            // Ini buat maksa koneksi internet lu dibaca sebagai IPv4 oleh Wablas, bukan IPv6 yang keblokir tadi.
            $response = Http::withOptions([
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
                ]
            ])->withHeaders([
                'Authorization' => 'mHWXlh109XTaPG257o8Ytum8BxsOUGg5c9DwcDsoBHLBXJhuPeOUQQl.ci3dgRbI',
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json'
            ])->post('https://tegal.wablas.com/api/v2/send-message', $payload);

            if ($response->successful()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Tembus! Pesan berhasil dikirim.',
                    'detail'  => $response->json()
                ], 200);
            }

            return response()->json([
                'status'     => 'failed',
                'message'    => 'Wablas masih nolak, ini responnya:',
                'error_code' => $response->status(),
                'detail'     => $response->json()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal koneksi.',
                'detail'  => $e->getMessage()
            ], 500);
        }
    }
}
