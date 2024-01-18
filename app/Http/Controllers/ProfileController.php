<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth()->user();
        return view('profile.index', compact('user'));
    }
    public function security()
    {
        return view('profile.security');
    }

    public function update(Request $request)
    {
        $auth_id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')->ignore($auth_id)],
        ]);
        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()]);
        }

        $photo = $request->file('photo');
        $photo_path = "";
        if ($photo) {
            $photo_path = $photo->store('files', 'images');
        }

        $updated_data = [
            'name' => $request->name,
            'email' => $request->email,
            'licence_number' => $request->licence_number,
            'licence_class' => $request->licence_class,
            'expiry_date' => $request->expiry_date,
        ];

        if ($photo_path) {
            $updated_data['photo'] = $photo_path;
        }
        $user = User::find($auth_id);
        $user->update($updated_data);
        return back()->with(['success' => 'Your profile has been successfully updated!']);
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()]);
        }

        $user = User::find(auth()->user()->id);
        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->with(['error' => "Please check the current password"]);
        }

        $user->update([
            'password' => Hash::make($request->newPassword)
        ]);
        return back()->with(['success' => "The password has been successfully updated!"]);
    }
}
