<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hosting_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('registrar')->default('afriregister.com');
            $table->string('hosting_provider')->default('digitalocean.com');
            $table->string('domain')->default('www.bethelhotel.rw');
            $table->decimal('annual_hosting_usd', 10, 2)->default(80);
            $table->unsignedBigInteger('annual_support_rwf')->default(500000);
            $table->decimal('usd_to_rwf_rate', 12, 2)->nullable();
            $table->string('notify_email')->nullable();
            $table->unsignedTinyInteger('renewal_month')->default(8);
            $table->unsignedTinyInteger('renewal_day')->default(1);
            $table->timestamps();
        });

        Schema::create('hosting_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('period_start');
            $table->date('period_end');
            $table->string('hosting_label');
            $table->decimal('hosting_usd', 10, 2)->nullable();
            $table->unsignedBigInteger('hosting_amount_rwf')->nullable();
            $table->unsignedBigInteger('support_amount_rwf')->default(0);
            $table->decimal('usd_to_rwf_rate', 12, 2)->nullable();
            $table->unsignedBigInteger('total_rwf')->nullable();
            $table->string('status', 20)->default('active')->index();
            $table->date('issued_on');
            $table->timestamp('paid_at')->nullable();
            $table->string('prepared_by');
            $table->timestamps();
        });

        Schema::create('hosting_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hosting_invoice_id')->constrained('hosting_invoices')->cascadeOnDelete();
            $table->string('milestone', 8);
            $table->timestamp('sent_at');
            $table->unique(['hosting_invoice_id', 'milestone']);
        });

        $now = now();

        DB::table('hosting_profiles')->insert([
            'registrar' => 'afriregister.com',
            'hosting_provider' => 'digitalocean.com',
            'domain' => 'www.bethelhotel.rw',
            'annual_hosting_usd' => 80,
            'annual_support_rwf' => 500000,
            'usd_to_rwf_rate' => null,
            'notify_email' => null,
            'renewal_month' => 8,
            'renewal_day' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('hosting_invoices')->insert([
            [
                'invoice_number' => 'IREME/BH005/WH-002/2026',
                'period_start' => '2026-07-01',
                'period_end' => '2027-07-01',
                'hosting_label' => 'Domain renewal, hosting & SSL services renewal',
                'hosting_usd' => null,
                'hosting_amount_rwf' => 130000,
                'support_amount_rwf' => 0,
                'usd_to_rwf_rate' => null,
                'total_rwf' => 130000,
                'status' => 'paid',
                'issued_on' => '2026-07-08',
                'paid_at' => '2026-07-08 00:00:00',
                'prepared_by' => 'Emma TWAGIRUMUKIZA',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'invoice_number' => 'IREME/BH005/WH-003/2026',
                'period_start' => '2026-08-01',
                'period_end' => '2027-08-01',
                'hosting_label' => 'Domain renewal, hosting & SSL services renewal',
                'hosting_usd' => 80,
                'hosting_amount_rwf' => null,
                'support_amount_rwf' => 500000,
                'usd_to_rwf_rate' => null,
                'total_rwf' => null,
                'status' => 'active',
                'issued_on' => '2026-08-01',
                'paid_at' => null,
                'prepared_by' => 'Emma TWAGIRUMUKIZA',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hosting_reminders');
        Schema::dropIfExists('hosting_invoices');
        Schema::dropIfExists('hosting_profiles');
    }
};
