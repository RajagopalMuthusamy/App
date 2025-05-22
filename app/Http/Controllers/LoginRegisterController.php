<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginRegisterController extends Controller
{
    public function __construct()
    {
        
    }

    public function register()
    {
        return view('register');
    }

    
    public function store(Request $request)
    {
        $request->validate([
        'username' => 'required|string|min:3|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);


        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login');
       
    }

    
    public function login()
    {
        return view('login');
    }

    
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
        return back()->withErrors(['email' => 'Email not found'])->withInput();
         }

        if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Incorrect password'])->withInput();
         }

         Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('home')
                ->with('success','You have successfully logged in!');
        
    }

            
    
    public function home()
    {
        if(Auth::check())
        {
            $posts=Post::all();
            return view('home',['posts'=>$posts]);
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    
    public function changepassword()
    {
        return view('reset');
    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'new_password' => 'required|confirmed',
            
        ]);

        if (!Hash::check($request->oldpassword, auth()->user()->password)) {
            return back()->with('error', 'Incorrect old password');
           
             }
        User::whereId(auth()->user()->id) ->update([
            'password' => Hash::make($request->new_password)
        ]);
        return redirect()->route('home')->with('success', 'password changed successfully');
                
   
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->with('success','You have logged out successfully!');
    }

    
}
