<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

Use App\Models\Account;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

# Question 1: Creating new member
Route::post('/v1/user/create', function(Request $request) {
    // Check for unique account name and length limit of 50.
    $validate = Validator::make($request->all(), [
        'Account' => 'required|unique:accounts,account|max:50',
        'Password' => 'required|max:50'
    ]);

    if($validate->passes()) {
        // Creating new account with password.
        $acc = new Account;
        $acc->account = $request->Account;
        // Hash the password.
        $acc->password = Hash::make($request->Password);
        $acc->save();
        
        return response()->json([
            'Code' => 0,
            'Message' => '',
            'Result' => ['isOK' => True,],
        ], 200);
    }
    return response()->json([
        'Code' => 0,
        'Message' => '',
        'Result' => ['isOK' => False,],
    ], 200);
});

# Question 2: Deleting member
Route::post('/v1/user/delete', function(Request $request) {
    // Find and delete account. If successful return True.
    if (Account::where('account', $request->Account)->delete()) {
        return response()->json([
            'Code' => 0,
            'Message' => '',
            'Result' => ['isOK' => True,],
        ], 200);
    }
    return response()->json([
        'Code' => 0,
        'Message' => '',
        'Result' => ['isOK' => False,],
    ], 200);
});

# Question 3: Changing password
Route::post('/v1/user/pwd/change', function(Request $request) {
    // Check length limit for password.
    $validate = Validator::make($request->all(), [
        'Password' => 'required|max:50'
    ]);

    if ($validate->passes()) {
        // Find acount.
        $acc = Account::where('account', $request->Account);
        if ($acc->exists()) {
            // Hash password.
            $acc->update(array('password' => Hash::make($request->Password)));
            return response()->json([
                'Code' => 0,
                'Message' => '',
                'Result' => ['isOK' => True,],
            ], 200);
        }
    }
    return response()->json([
        'Code' => 0,
        'Message' => '',
        'Result' => ['isOK' => False,],
    ], 200);
});

# Question 4: Login
Route::get('/v1/user/login', function(Request $request) {
    // Find password of account.
    $acc = Account::where('account', $request->Account)->first();
    // Compare the hash of password.
    if ($acc and Hash::check($request->Password, $acc->password)) {
        return response()->json([
            'Code' => 0,
            'Message' => '',
            'Result' => null,
        ], 200);
    }
    return response()->json([
        'Code' => 2,
        'Message' => 'Login Failed',
        'Result' => null,
    ], 400);
});
