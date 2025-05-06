<?php

namespace App\Helpers;

class MailHelper
{
    /**
     * Odoslanie HTML mailu s viacerými prílohami cez PHP mail().
     */
    public static function send(string $to, string $subject, string $html, array $attachments = [], string $from = 'no-reply@example.com'): bool
    {
        $boundary = uniqid('np');

        // hlavičky
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "From: {$from}\r\n";
        $headers .= "Reply-To: {$from}\r\n";
        $headers .= "Content-Type: multipart/mixed;boundary=" . $boundary . "\r\n";

        // telo začína HTML časťou
        $message  = "--{$boundary}\r\n";
        $message .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message .= $html . "\r\n";

        // každá príloha
        foreach ($attachments as $filePath) {
            if (!is_readable($filePath)) {
                continue; // skip ak sa nedá prečítať
            }
            $fileName = basename($filePath);
            $data     = chunk_split(base64_encode(file_get_contents($filePath)));

            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: application/octet-stream; name=\"{$fileName}\"\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n";
            $message .= "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n\r\n";
            $message .= $data . "\r\n";
        }

        $message .= "--{$boundary}--";
        $result = mail($to, $subject, $message, $headers);

        if (!$result) {
            // uloží poslednú chybu PHP (často "Could not execute mail(): ...")
            \Log::error('mail() error', error_get_last() ?: []);
        }

        return $result;
        //return mail($to, $subject, $message, $headers);
    }
}
