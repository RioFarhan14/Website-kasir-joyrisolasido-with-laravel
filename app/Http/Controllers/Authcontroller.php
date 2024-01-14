<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;

class Authcontroller extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
        ]);
    
        // Attempt to retrieve the user by email
        $user = User::where('email', $request->email)->first();
    
        // Check if the user exists and if the password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication passed
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
    
        // Authentication failed
        return redirect()->back()->with('error', 'Email atau password salah');
    }
    
    
    public function edit(){
        $activeSidebar = '';
        return view('auth.resetpassword', compact('activeSidebar'));
    }

    public function update(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required'
        ], [
            'old_password' => 'Password tidak boleh kosong.',
            'new_password' => 'Password tidak boleh kosong.'
        ]);
        
        $user = User::find(1);
    
        if($user && Hash::check($request->old_password, $user->password)){
            $password = Hash::make($request->new_password);
            $user->update([
                'password' => $password
            ]);
    
            session()->flash('success', 'Password berhasil diupdate');
        } else {
            session()->flash('error', 'Password salah');
        }
        return redirect()->back();
    }
    
    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    

}
