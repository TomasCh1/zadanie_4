<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\EmailTemplate;

class SentEmail extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * (Optional if you follow Laravel's naming convention—
     * Eloquent will assume "sent_emails" automatically.)
     *
     * @var string
     */
    protected $table = 'sent_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'contact_id',
        'template_id',
        'recipients', // comma-separated list of recipient emails
        'subject',
        'body',
    ];

    /**
     * If you prefer to cast the recipients column to an array,
     * you can store it as JSON and uncomment the casts below:
     *
     * protected $casts = [
     *     'recipients' => 'array',
     * ];
     */

    /**
     * Get the contact this sent-email record belongs to.
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the template that was used for this sent-email.
     */
    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}
