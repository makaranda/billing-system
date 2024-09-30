<?php


define('CONST_ROOM_STATUS',[
	1 => 'Blocked', // for maintainance
	2 => 'Reserved',
	3 => 'Available',
	4 => 'Occupied',
	5 => 'Checkout',
	6 => 'Hold', // for unconfirmed web reservations
	7 => 'Deleted',
]);

define('CONST_GUEST_CATEGORIES',[
	'' => '- SELECT -',
	'fit' => 'FIT - Fully Independent Traveler',
	'corporate' => 'Corporate',
	'travel-agent' => 'OTA - Travel Agent'
]);

define('CONST_TRAVEL_AGENTS',[
	'' => '- SELECT -',
	1 => 'booking.com',
	2 => 'hotels.com',
	3 => 'trip-advisor',
]);

define('CONST_PAYMENT_METHODS',[
	'cash' => 'Cash',
	'card' => 'Card (Credit/Debit)',
	'cheque' => 'Cheque',
	'bank' => 'Bank Transfer',
	'mobilemoney' => 'Mobilemoney',
	'wht' => 'WHT',
	'vwc' => 'VAT DEDUCTION (WITHHOLDING)',
]);

define('CONST_PAYMENT_METHODS_ALL',[
	'cash' => 'Cash',
	'card' => 'Card (Credit/Debit)',
	'cheque' => 'Cheque',
	'bank' => 'Bank Transfer',
	'mobilemoney' => 'Mobilemoney',
	'wht' => 'WHT',
	'vwc' => 'VAT DEDUCTION (WITHHOLDING)',
]);

define('CONST_TITLES',[
	'' => '- SELECT -',
	'Mr' => 'Mr',
	'Ms' => 'Ms',
	'Mrs' => 'Mrs',
	'Dr' => 'Dr',
	'Prof' => 'Prof',
	'Ven' => 'Ven',
	'Rev' => 'Rev',
	'Hon' => 'Hon',
	'Pastor' => 'Pastor',
	'Amb' => 'Amb',
	'Jud' => 'Jud',
]);

define('CONST_TAX_TYPES',[
	'' => '- Select Tax Type -',
	'Taxable' => 'Taxable',
	'TaxExcempted' => 'Tax Excempted',
	'ZeroRated' => 'Zero Rated',
]);

define('CONST_PRICE_TYPES',[
	'' => '- Select Price Type -',
	'TaxInclusive' => 'Tax Inclusive',
	'TaxExclusive' => 'Tax Exclusive',
]);

define('CONST_ID_TYPES',[
	'' => '- SELECT -',
	'ID' => 'National_ID',
	'Passport' => 'Passport',
	'DL' => 'Driving_Licence',
]);

define('CONST_ADMIN_PRIVILEGES',[
	'' => '- SELECT -',
	'administrator' => 'administrator',
	'manager' => 'manager',
	'user' => 'user',
]);

define('CONST_MANAGER_PRIVILEGES',[
	'' => '- SELECT -',
	'manager' => 'manager',
	'user' => 'user',
]);


define('CONST_LEAVE_TYPE',[
	'1' => 'Absent',
	'2' => 'Imposed Leave',
	'3' => 'Sick',
	'4' => 'Off Day',
	'5' => 'Annual Leave'
]);

define('CONST_OT_TYPES',[
	'normal' => 'Normal',
	'holiday' => 'Holiday'
]);

define('CONST_OT_RATES',[
	'normal' => '1.5',
	'holiday' => '2'
]);

define('CONST_BANK_DEPOSIT_CAT',[
	'daily' => 'Daily Sales',
	'debit' => 'Debtors Collections',
	'fc' => 'Foriegn Currency',
]);

define('CONST_COMMUNICATION_TYPES',[
	'print' => 'Print',
	'email' => 'Email',
	'dispatch' => 'Dispatch',
	'reminder1' => 'Reminder 1',
	'reminder2' => 'Reminder 2',
	'letter' => 'Letters',
]);

define('CONST_SUSPEND_REASONS',[
	'1' => 'Non Payment',
	'2' => 'Customer Request',
	'3' => 'Breach of Contract',
	'4' => 'Winding Up',
	'5' => 'System issue',
	'99' => 'Other',
]);

define('CONST_DELIVERY_SOURCES',[
	'Dispatch_rider'=>'Dishpatch Rider',
	'Account_holder'=>'Account Holder',
	'Post'=>'Post',
	'Other'=>'Other'
]);


define('WORKING_DATE',''.date("Y-m-d").'');

define('CURRENCY_ID',1);
