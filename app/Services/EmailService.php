<?php
namespace App\Services;

use App\Mail\StandardEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    //EXEMPLO DE USO
    //use App\Services\EmailService;
    
    //$emailService = new EmailService();

    //$emailService->sendStandardEmail(
    //    'usuario@empresa.com',
    //    'Boas-vindas ao sistema',
    //    '<p>Olá, seja bem-vindo ao nosso sistema!</p>',
    //    storage_path('app/public/manual.pdf') // ou null
    //);

    public function sendStandardEmail(string $to, string $subject, string $body, string $attachmentPath = null): bool
    {
        try {
            Mail::to($to)->queue(new StandardEmail($subject, $body, $attachmentPath));
            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao enfileirar e-mail: ' . $e->getMessage());
            return false;
        }
    }
}
