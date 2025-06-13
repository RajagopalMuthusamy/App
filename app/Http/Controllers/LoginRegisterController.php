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


        $user=User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
       
       $user->passwordHistories()->create(['password' => Hash::make($request->password)]);  

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
            $posts = Post::where('user_id', Auth::id())->get();

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
            'oldpassword' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
            
        ]);

        $user=auth()->user();

        if (!Hash::check($request->oldpassword, $user->password)) {
            return back()->with('error', 'Incorrect old password');
           
             }

        //check last three password
        $recentPasswords=$user->passwordHistories()->latest()->take(3)->get();
        foreach($recentPasswords as $past){
            if (Hash::check($request->new_password, $past->password)) {
                return back()->with('error', 'You can not use your last three passwords');
               
                 }
    
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        $user->passwordHistories()->create(['password' => Hash::make($request->new_password)]);

        $passwordDelete=$user->passwordHistories()->latest()->skip(3)->take(PHP_INT_MAX)->get();
        foreach( $passwordDelete as $ph){
            $ph->delete();
        }
        
        return redirect()->route('home')->with('success', 'password changed successfully!');
                
   
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
