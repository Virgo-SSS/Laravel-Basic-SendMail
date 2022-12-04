<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $students = User::orderBy('created_at')->get()->groupBy(function($data) {
        //     return $data->created_at->format('Y-m-d');
        // });
        // $students = User::where('email', 'like', '%@example.net')
        // ->orderBy('name')
        // ->latest()
        // ->get();

        // $quotations = DB::table('User')
        // ->select('*', DB::raw('MAX(created_at) as created_at'))
        // ->where('email', 'like', '%@example.net')
        // ->orderBy('name')
        // ->get();

        // $students = DB::table ('User')
        // ->where ('id' , $quotations->id)
        // ->where ('created_at' , $quotations->created_at);
        // $students = User::whereIn('id', function ($query) {
        //     $query
        //         ->from('Users')
        //         ->select(DB::raw('MAX(id) as id'))
        //         ->groupBy('id');
        // })->get();
        // $students = User::where('email', 'like', '%@example.com')->orderBy('id', 'DESC')->first();
        // $students->name = 'di ganti aja';
        
        
        // return view('home', compact('students'));
        return view('home');
    }
}
