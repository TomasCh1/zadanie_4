<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimplePredefinedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    protected $attachmentPaths;
    protected $template;       // ← nová vlastnosť

    public function __construct($contact, array $attachmentPaths = [], string $template = 'db_template')
    {
        $this->contact         = $contact;
        $this->attachmentPaths = $attachmentPaths;
        $this->template        = $template;
    }

    public function build()
    {
        $this->subject('Preddefinovaná správa')
            ->view("emails.{$this->template}", [
                'contact' => $this->contact,
            ]);

        // 2) pripoj prílohy
        foreach ($this->attachmentPaths as $path) {
            $this->attachFromStorageDisk('local', $path, basename($path));
        }

        return $this;
    }
    
}
