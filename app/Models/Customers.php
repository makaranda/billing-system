<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Customers extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'customers';
    protected $fillable = [
        'parent_customer_id',
        'group_id',
        'branch_id',
        'code',
        'category_id',
        'old_code',
        'company',
        'address',
        'postal_code',
        'city',
        'country_id',
        'telephone',
        'mobile',
        'fax',
        'email',
        'web_site',
        'currency_id',
        'default_price_type',
        'territory_id',
        'contact_position',
        'contact_name',
        'contact_telephone',
        'contact_mobile',
        'contact_email',
        'contact_position2',
        'contact_name2',
        'contact_telephone2',
        'contact_mobile2',
        'contact_email2',
        'contact_person_details_last_updated_by',
        'contact_person_details_last_updated_at',
        'vat_reg_no',
        'wht_reg_no',
        'collection_bureau_id',
        'credit_limit',
        'credit_amount',
        'account_balance',
        'settlement_due',
        'discount_period',
        'interest',
        'settlement_discount',
        'last_credit_review',
        'next_credit_review',
        't_n_c',
        'notes',
        'active',
        'status',
        'sales_user_id',
        'created_by',
    ];

}
