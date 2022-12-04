<?php

namespace App\Http\Controllers;

use App\Models\test;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function index()
    {
        $user['email'] = 'a';
        $user['status'] = 1;
        $user['email_old'] = 'b';
        $user['status_old'] = 0;

        $data = json_encode($user);

        test::create([
            'id' => 1,
            'desc' => $data
        ]);
        
        return back();
    }

    public function upd()
    {
        
        // $user['status_old'] = 1;
        // $user['email'] = 'a';
        // $user['status'] = 1;
        // $user['email_old'] = 'b';
        // $user['status_old'] = 0;

        // $status = 1;
        // $data = json_encode($user);

        $product = test::where('desc->email_old', 'virgo')
        ->first(['id','desc']);
        $ts = json_decode($product->desc, true);
        $ts['status_old'] = '1';
        $product->desc = json_encode($ts);
        $product->update();
        
        return back();
    }
}
