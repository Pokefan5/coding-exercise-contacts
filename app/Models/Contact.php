<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Initially generated using
 *      >sail artisan make:model Contact
 * 
 * The $casts property was implemented following the example project provided by Laravel
 */

class Contact extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email_address',
        'phone_number',
        'company',
        'street',
        'date_of_birth',
    ];

    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // Parse a HTTP request for contact data, any missing data defaults to null
    public static function parseRequest (Request $request) {
        $first_name     = $request->input('first_name', null);
        $last_name      = $request->input('last_name', null);
        $email_address  = $request->input('email_address', null);
        $phone_number   = $request->input('phone_number', null);
        $company        = $request->input('company', null);
        $street         = $request->input('street', null);
        $date_of_birth  = $request->input('date_of_birth', null);

        return [
            'first_name'    =>  $first_name,
            'last_name'     =>  $last_name,
            'email_address' =>  $email_address,
            'phone_number'  =>  $phone_number,
            'company'       =>  $company,
            'street'        =>  $street,
            'date_of_birth' =>  $date_of_birth
        ];
    }

    // Find all Contacts that contain a given string in any assignable property or their ID
    // If the string is null all contacts are returned
    public static function findContacts (string $keyword = "") {
        return Contact::query()
            ->where('id', 'LIKE', $keyword)
            ->orwhere('first_name',     'LIKE', "%{$keyword}%")
            ->orWhere('last_name',      'LIKE', "%{$keyword}%")
            ->orWhere('email_address',  'LIKE', "%{$keyword}%")
            ->orWhere('phone_number',   'LIKE', "%{$keyword}%")
            ->orWhere('company',        'LIKE', "%{$keyword}%")
            ->orWhere('street',         'LIKE', "%{$keyword}%")
            ->orWhere('date_of_birth',  'LIKE', "%{$keyword}%")
            ->get();
    }

    // Return true if an email address follows PHPs definition of being valid, otherwise return false
    // Unlike filter_var() this will only return a boolean
    public static function isEmailValid (string $email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL) != false);
    }
}