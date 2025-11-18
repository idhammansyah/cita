<?php

namespace App\Mail;

// Pastikan namespace model ReimbursementEmployee Anda benar
use App\Models\Reimbursement\ReimbursementEmployee;
// Anda tidak perlu secara eksplisit mengimpor User dan Category di sini
// karena mereka diakses melalui relasi pada ReimbursementEmployee.

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewReimbursementNotification extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  public $reimbursement; // Property untuk menyimpan data reimbursement

  /**
    * Create a new message instance.
  */
  public function __construct(ReimbursementEmployee$reimbursement) // Terima objek ReimbursementEmployee
  {
    // PENTING: Lakukan eager loading relasi 'user' dan 'category' di sini
    // agar data relasi ikut diserialisasi dan tersedia saat job diproses
    $this->reimbursement = $reimbursement->load(['user', 'category']);
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope
  {
    // Pastikan relasi 'user' sudah dimuat sebelum mengaksesnya
    $userName = $this->reimbursement->user->full_name ?? 'Pengguna Tidak Dikenal';

    return new Envelope(
      subject: 'Pengajuan Reimbursement Baru: ' . $this->reimbursement->title . ' oleh ' . $userName,
    );
  }

  /**
  * Get the message content definition.
  */
  public function content(): Content
  {
    return new Content(
      markdown: 'emails.reimbursements.new_submission', // Path ke Blade Markdown template
      with: [
        'reimbursement' => $this->reimbursement,
        'user' => $this->reimbursement->user,
        'category' => $this->reimbursement->category,
      ],
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
    return []; // Jika tidak ada lampiran
  }
}
