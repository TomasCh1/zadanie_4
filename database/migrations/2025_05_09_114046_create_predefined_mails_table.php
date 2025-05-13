<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('predefined_mails', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('contact_ids');          // uložené kontakty
            $table->foreignId('template_id')
                ->constrained('email_templates')
                ->cascadeOnDelete();
            $table->json('attachments')->nullable(); // paths alebo data
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('predefined_mails');
    }
};
