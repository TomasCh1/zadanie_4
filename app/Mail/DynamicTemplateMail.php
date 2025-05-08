<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Blade;
use App\Models\EmailTemplate;
use App\Models\Contact;
use Illuminate\Http\UploadedFile;

class DynamicTemplateMail extends Mailable
{
    /**
     * Pole uploadnutých súborov (príloh).
     *
     * @var \Illuminate\Http\UploadedFile[]
     */
    protected array $files;

    /**
     * @param  \App\Models\EmailTemplate     $template
     * @param  \App\Models\Contact           $contact
     * @param  \Illuminate\Http\UploadedFile[]  $files
     */
    public function __construct(
        public EmailTemplate $template,
        public Contact       $contact,
        array                  $files = []
    ) {
        // Naplníme naše nové pole
        $this->files = $files;
    }

    public function build()
    {
        // 1) Vyrenderujeme raw Blade uložený v DB
        $html = Blade::render(
            $this->template->body,
            ['contact' => $this->contact]
        );

        // 2) Zostavíme základ mailu
        $mail = $this
            ->subject($this->template->subject)
            ->html($html);

        // 3) Priložíme každý súbor z $this->files
        foreach ($this->files as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $mail->attach(
                    $file->getRealPath(),
                    [
                        'as'   => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                    ]
                );
            }
        }

        return $mail;
    }
}
