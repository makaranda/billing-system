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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_customer_id');
            $table->integer('group_id');
            $table->integer('branch_id');
            $table->string('code', 25)->nullable();
            $table->integer('category_id');
            $table->string('old_code', 25);
            $table->string('company', 100)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('postal_code', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->integer('country_id');
            $table->string('telephone', 25)->nullable();
            $table->string('mobile', 25)->nullable();
            $table->string('fax', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('web_site', 255)->nullable();
            $table->integer('currency_id')->nullable();
            $table->integer('default_price_type');
            $table->integer('territory_id');
            $table->string('contact_position', 50)->nullable();
            $table->string('contact_name', 255)->nullable();
            $table->string('contact_telephone', 25)->nullable();
            $table->string('contact_mobile', 25)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('contact_position2', 50)->nullable();
            $table->string('contact_name2', 255)->nullable();
            $table->string('contact_telephone2', 25)->nullable();
            $table->string('contact_mobile2', 25)->nullable();
            $table->string('contact_email2', 255)->nullable();
            $table->integer('contact_person_details_last_updated_by')->nullable();
            $table->dateTime('contact_person_details_last_updated_at')->nullable();
            $table->string('vat_reg_no', 25);
            $table->string('wht_reg_no', 50);
            $table->integer('collection_bureau_id');
            $table->decimal('credit_limit', 16, 2)->default(0.00);
            $table->decimal('credit_amount', 16, 2)->default(0.00);
            $table->decimal('account_balance', 16, 2)->default(0.00);
            $table->integer('settlement_due')->comment('in_days');
            $table->integer('discount_period')->comment('in days');
            $table->double('interest')->comment('percentage');
            $table->double('settlement_discount')->comment('percentage');
            $table->date('last_credit_review')->nullable();
            $table->date('next_credit_review')->nullable();
            $table->text('t_n_c')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('status')->default(1);
            $table->integer('sales_user_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
