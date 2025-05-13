<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StandardEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $body;
    public ?string $attachmentPath;

    public function __construct(
        public string $subjectLine,
        string $body,
        ?string $attachmentPath = null
    ) {
        $this->body = $body;
        $this->attachmentPath = $attachmentPath;
        $this->subject($subjectLine);
    }

    public function build()
    {
        $mail = $this->view('emails.standard')
                     ->with(['body' => $this->body]);

        if ($this->attachmentPath && file_exists($this->attachmentPath)) {
            $mail->attach($this->attachmentPath);
        }

        return $mail;
    }
}
