<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('type', 25); // VARCHAR(25)
            $table->integer('branch_id'); // INT(11)
            $table->integer('product_group_id'); // INT(11)
            $table->integer('collection_bureau_id'); // INT(11)
            $table->dateTime('collection_bureau_assign_date')->nullable(); // DATETIME NULL
            $table->string('invoice_no', 25); // VARCHAR(25)
            $table->string('invoice_serial_no', 50)->nullable(); // VARCHAR(50) NULL
            $table->dateTime('invoice_generated_date')->nullable(); // DATETIME NULL
            $table->integer('booking_no'); // INT(11)
            $table->integer('room_id'); // INT(11)
            $table->integer('guest_id'); // INT(11)
            $table->integer('manual_invoice_id'); // INT(11)
            $table->integer('customer_id'); // INT(11)
            $table->date('date'); // DATE
            $table->date('due_date'); // DATE
            $table->string('description', 255); // VARCHAR(255)
            $table->decimal('amount', 19, 4)->default(0.0000); // DECIMAL(19,4)
            $table->decimal('total_paid', 19, 4)->default(0.0000); // DECIMAL(19,4)
            $table->decimal('payments_due', 19, 4)->default(0.0000); // DECIMAL(19,4)
            $table->text('separate_ids'); // TEXT
            $table->decimal('total_credit_notes', 19, 4)->default(0.0000); // DECIMAL(19,4)
            $table->decimal('total_receipts', 19, 4)->default(0.0000); // DECIMAL(19,4)
            $table->integer('is_paid')->default(0); // INT(11) Default 0
            $table->integer('is_exported')->default(0); // INT(11) Default 0
            $table->integer('exported_by')->nullable(); // INT(11) NULL
            $table->dateTime('exported_at')->nullable(); // DATETIME NULL
            $table->string('transaction_id', 75)->nullable(); // VARCHAR(75) NULL
            $table->integer('recurring_invoice_id'); // INT(11)
            $table->date('start_date'); // DATE
            $table->date('end_date'); // DATE
            $table->string('private_note', 500); // VARCHAR(500)
            $table->text('public_note'); // TEXT
            $table->integer('status')->default(1); // INT(11) Default 1
            $table->string('public_token', 100)->default('uuid()'); // VARCHAR(100) Default UUID
            $table->integer('created_by')->nullable(); // INT(11) NULL
            $table->timestamps(); // created_at and updated_at with default timestamp
            $table->integer('debt_collector_id')->nullable(); // INT(11) NULL
            $table->dateTime('debt_collector_assign_date')->nullable(); // DATETIME NULL
            $table->integer('is_printed')->default(0); // INT(11) Default 0
            $table->integer('is_email')->default(0); // INT(11) Default 0
            $table->integer('is_dispatched')->default(0); // INT(11) Default 0
            $table->dateTime('dispatched_date'); // DATETIME
            $table->integer('is_delivered'); // INT(11)
            $table->dateTime('delivery_date'); // DATETIME
            $table->integer('is_fallowup')->default(0); // INT(11) Default 0
            $table->tinyInteger('is_suspended'); // TINYINT(4)
            $table->dateTime('suspended_date')->nullable(); // DATETIME NULL
            $table->tinyInteger('is_terminated'); // TINYINT(4)
            $table->dateTime('terminated_date')->nullable(); // DATETIME NULL
            $table->tinyInteger('is_voided')->default(0); // TINYINT(4) Default 0
            $table->dateTime('void_date')->nullable(); // DATETIME NULL
            $table->integer('void_by')->nullable(); // INT(11) NULL
            $table->integer('sales_user_id')->nullable(); // INT(11) NULL
            $table->string('sales_tag', 100)->nullable(); // VARCHAR(100) NULL
            $table->tinyInteger('is_converted')->default(0); // TINYINT(4) Default 0
            $table->integer('converted_by')->nullable(); // INT(11) NULL
            $table->dateTime('converted_at')->nullable(); // DATETIME NULL
            $table->text('attributes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
