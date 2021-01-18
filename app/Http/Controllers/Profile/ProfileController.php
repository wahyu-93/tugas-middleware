<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

use function PHPSTORM_META\map;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $data =  auth()->user();

        return response()->json([
            'response_code'     => '01',
            'response_message'  => 'Profile Berhasil Ditampilkan',
            'data'  => [
                'profile'   => $data
            ]
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'email'     => ['required', 'email']
        ]);

        $extensions = $request->file('foto')->extension();
        $imageName  = auth()->user()->id.'.'.$extensions;
        Storage::delete($imageName);
        Storage::putFileAs('public/images', $request->file('foto'), $imageName);

        $user = User::where('id', auth()->user()->id)->first();
        $user->foto = $imageName;
        $user->save();

        return response()->json([
            'response_code'     => '01',
            'response_message'  => 'Berhasil Update Profile',
            'data'  => auth()->user()
        ]);
    }
}
