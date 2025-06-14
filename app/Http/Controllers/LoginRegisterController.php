<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginRegisterController extends Controller
{
    //register page
    public function register()
    {
        return view('register');
    }

    //user details
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

    //login page
    public function login()
    {
        return view('login');
    }

    //login authentication
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required|min:6'
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

            
    //home page
    public function home()
    {
        if(Auth::check())
        {
            $posts = Post::where(function ($query) {
                $query->where('visibility', 'public')
                      ->orWhere('user_id', auth()->id());
            })
            ->with('user:id,username')
            ->get();

            return view('home',['posts'=>$posts]);
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    
    //view changepassword page
    public function changepassword()
    {
        return view('reset');
    }

    //update password 
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

        //update password in table
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        $user->passwordHistories()->create(['password' => Hash::make($request->new_password)]);

        // //delete password (more than 3 password for user)
        // $passwordDelete=$user->passwordHistories()->latest()->skip(3)->take(PHP_INT_MAX)->get();
        // foreach( $passwordDelete as $pdelete){
        //     $pdelete->delete();
        // }
        
        return redirect()->route('home')->with('success', 'password changed successfully!');
                
   
    }

    //logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->with('success','You have logged out successfully!');
    }

    
}
