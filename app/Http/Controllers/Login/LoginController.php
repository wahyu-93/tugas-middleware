<?php

namespace App\Http\Controllers\Login;

use App\Event\EventRegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Otp;

class LoginController extends Controller
{
    public function register(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email']
        ]);

        $data = [];

        $users = User::create([
            'name'  => request('name'),
            'email' => request('email'),
            'password'=> bcrypt('secret') 
        ]);
            
        $now = Carbon::now();

        $otps = Otp::create([
            'otp_code'  => mt_rand(1000000, 9999999),
            'valid_date'=> $now->addMinutes(5),
            'user_id'   => $users->id
        ]);

        $users->setAttribute('otp', $otps->otp_code);
        $data['user'] = $users;

        event(new EventRegisterUser($users));
        
        return response()->json([
                'response_code' => '00',
                'response_message' => 'Silahkan Cek Email',
                'data'  => $data
            ]);
    } 

    public function verification(Request $request)
    {
        $request->validate([
            'otp'   => ['required'],
        ]);

        $otps = Otp::where('otp_code', request('otp'))->first();

        if(!$otps){
            return response()->json([
                'response_code' => '01',
                'response_message' => 'OTP Tidak Ditemukan'
            ]);
        }

        $now = Carbon::now();
        if($now > $otps->valid_date){
            return response()->json([
                'response_code' => '01',
                'response_message' => 'OTP Sudah Tidak Bisa Dipakai, Silahkan Untuk Generate Ulang OTP'
            ]);
        }

        $User = User::findOrFail($otps->user_id);
        $User->email_verified_at = $now;
        $User->save();

        return response()->json([
            'response_code' => '00',
            'response_message'  => 'Sukses Verifikasi Email',
            'data' => $User
        ]);
    }

    public function generateOtp(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required']
        ]);
    
        $user = User::where('email', request('email'))->first();

        if(!$user){
            return response()->json([
                'response_code' => '01',
                'response_message'  => 'Email Tidak Ditemukan'
            ]);
        };

        $otps = Otp::where('user_id', $user->id)->first();
        $otps->otp_code = mt_rand(1000000, 9999999);
        $otps->valid_date = Carbon::now()->addMinutes(5);
        $otps->save();     
        
        $user->setAttribute('otp', $otps->otp_code);
        event(new EventRegisterUser($user));

        return response()->json([
            'response_code' => '00',
            'response_message'  => 'Berhasil Generate Ulang OTP',
            'data'  => $otps
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password'  => ['required'],
            'password_confirm' => ['required']
        ]);

        if (request('password') != request('password_confirm')){
            return response()->json([
                'response_code'     => '01',
                'response_message'  => 'Password Harus Sama',
            ]);
        }

        if (!User::where('email', request('email'))->first()){
            return response()->json([
                'response_code'     => '01',
                'response_message'  => 'Email Tidak Ditemukan',
            ]); 
        }

        $user = User::where('email', request('email'))->first();
        $user->password = bcrypt(request('password'));
        $user->save();

        return response()->json([
            'response_code'     => '01',
            'response_message'  => 'Berhasil Ubah Password'
        ],200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required'],
        ]);

        if (!$token = auth()->attempt($request->only('email', 'password'))){
            return response(null, 401);
        }

        $user = User::where('email', request('email'))->first();

        return response()->json([
            'response_code'     => '01',
            'response_message'  => 'User Berhasil Login',
            'data'  => [
                'token' => $token,
                'user'  => $user
            ]
            
        ]);
    }
}
