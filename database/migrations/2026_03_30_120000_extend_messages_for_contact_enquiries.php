<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->string('enquiry_type', 32)->default('general');
                $table->string('names');
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('subject')->nullable();
                $table->text('message')->nullable();
                $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
                $table->date('checkin_date')->nullable();
                $table->date('checkout_date')->nullable();
                $table->unsignedSmallInteger('adults')->nullable();
                $table->unsignedSmallInteger('children')->nullable();
                $table->text('admin_reply')->nullable();
                $table->timestamp('replied_at')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('messages', function (Blueprint $table) {
            if (! Schema::hasColumn('messages', 'enquiry_type')) {
                $table->string('enquiry_type', 32)->default('general')->after('id');
            }
            if (! Schema::hasColumn('messages', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (! Schema::hasColumn('messages', 'room_id')) {
                $table->foreignId('room_id')->nullable()->after('message')->constrained('rooms')->nullOnDelete();
            }
            if (! Schema::hasColumn('messages', 'checkin_date')) {
                $table->date('checkin_date')->nullable()->after('room_id');
            }
            if (! Schema::hasColumn('messages', 'checkout_date')) {
                $table->date('checkout_date')->nullable()->after('checkin_date');
            }
            if (! Schema::hasColumn('messages', 'adults')) {
                $table->unsignedSmallInteger('adults')->nullable()->after('checkout_date');
            }
            if (! Schema::hasColumn('messages', 'children')) {
                $table->unsignedSmallInteger('children')->nullable()->after('adults');
            }
            if (! Schema::hasColumn('messages', 'admin_reply')) {
                $table->text('admin_reply')->nullable()->after('children');
            }
            if (! Schema::hasColumn('messages', 'replied_at')) {
                $table->timestamp('replied_at')->nullable()->after('admin_reply');
            }
        });

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            if (Schema::hasColumn('messages', 'email')) {
                DB::statement('ALTER TABLE messages MODIFY email VARCHAR(255) NULL');
            }
            if (Schema::hasColumn('messages', 'subject')) {
                DB::statement('ALTER TABLE messages MODIFY subject VARCHAR(255) NULL');
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('messages')) {
            return;
        }

        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'replied_at')) {
                $table->dropColumn('replied_at');
            }
            if (Schema::hasColumn('messages', 'admin_reply')) {
                $table->dropColumn('admin_reply');
            }
            if (Schema::hasColumn('messages', 'children')) {
                $table->dropColumn('children');
            }
            if (Schema::hasColumn('messages', 'adults')) {
                $table->dropColumn('adults');
            }
            if (Schema::hasColumn('messages', 'checkout_date')) {
                $table->dropColumn('checkout_date');
            }
            if (Schema::hasColumn('messages', 'checkin_date')) {
                $table->dropColumn('checkin_date');
            }
            if (Schema::hasColumn('messages', 'room_id')) {
                $table->dropForeign(['room_id']);
                $table->dropColumn('room_id');
            }
            if (Schema::hasColumn('messages', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('messages', 'enquiry_type')) {
                $table->dropColumn('enquiry_type');
            }
        });
    }
};
