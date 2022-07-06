<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Contact;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    // Create a contact with all the given information and returns the newly created contact
    // If any of the information is missing or considered invalid (email), discard the request as invalid (400)
Route::post('/v1/contact/create', function (Request $request) {
    
    $contact_info = Contact::parseRequest($request);

    if(!in_array(null, $contact_info, true) && Contact::isEmailValid($contact_info['email_address'])) {
        $contact = Contact::create($contact_info);

        return $contact->toJson();
    } else {
        return response(
            [
                'Response'  =>  'Bad Request',
                'Code'      =>  '400'
            ],
            400
        );
    }

    // If this part is executed something went VERY wrong as both parts of the if/else statement return a value
    abort(500);
});

    // Find the first parameter passed and search all contacts for it
    // This searches every property that can be assigned at creation as well as the ID
Route::get('/v1/contact/read', function (Request $request) {

    $input = strVal($request->collect()->first());

    $contacts = Contact::findContacts($input);

    return $contacts->toJson();
});

    // First find the contact by the ID provided
    // If the contact exists, check if there is an email provided and if so, if it is valid, if so update all the values provided and return both the original and updated contact, null values are ignored
    // If the contact doesn't exist, or the provided email is invalid, discard the request as invalid (400)
Route::post('/v1/contact/update', function (Request $request) {

    $contact = Contact::find($request->input('id', null));
    
    $input = Contact::parseRequest($request);

    if (!is_null($contact) && !(!is_null($input['email_address']) && !Contact::isEmailValid($input['email_address']))) {
        $old_contact = $contact->getOriginal();
        $input = array_filter($input);
        $contact->update($input);

        return collect([
            'old'   =>  $old_contact,
            'new'   =>  $contact
        ])->toJson();
    } else {
        return response(
            [
                'Response'  =>  'Bad Request',
                'Code'      =>  '400'
            ],
            400
        );
    }

    // If this part is executed something went VERY wrong as both parts of the if/else statement return a value
    abort(500);    
});

    // First find the contact by the ID provided
    // If the contact exists delete it and return it
    // If the contact doesn't exist discard the request as invalid (400)
Route::post('/v1/contact/delete', function (Request $request) {

    $contact = Contact::find($request->input('id', null));

    if (!is_null($contact)) {
        $contact->delete();

        // This works because, even though the contact has been removed from the database, it still remains in memory/the variable
        return $contact->toJson();
    } else {
        return response(
            [
                'Response'  =>  'Bad Request',
                'Code'      =>  '400'
            ],
            400
        );
    }

    // If this part is executed something went VERY wrong as both parts of the if/else statement return a value
    abort(500);
});