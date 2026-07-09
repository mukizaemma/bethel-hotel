<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove accountant module tables (expenses, payments, invoices).
     */
    public function up(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_categories');
    }

    /**
     * @deprecated Accounting tables are no longer part of the application.
     */
    public function down(): void
    {
        //
    }
};
