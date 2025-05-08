<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\EmailTemplate;

class EmailTemplatesTableSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name'       => 'motivácia',
                'subject'    => 'Potrebujete nakopnúť?',
                'body'       => File::get(resource_path('views/emails/motivation_template.blade.php')),
                'is_html'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'zábava',
                'subject'    => 'Trochu srandy do života!',
                'body'       => File::get(resource_path('views/emails/funny_template.blade.php')),
                'is_html'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'db šablóna',
                'subject'    => 'Šablóna z DB',
                'body'       => File::get(resource_path('views/emails/db_template.blade.php')),
                'is_html'    => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        EmailTemplate::insert($templates);
    }
}
