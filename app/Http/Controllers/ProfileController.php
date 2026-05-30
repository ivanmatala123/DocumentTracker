<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user           = Auth::user();
        $docCount       = Document::where('user_id', $user->id)->count();
        $approvedCount  = Document::where('user_id', $user->id)->where('status', 'approved')->count();

        if ($user->role === 'admin') {
            return view('admin.profile', compact('user', 'docCount', 'approvedCount'));
        }

        return view('user.profile', compact('user', 'docCount', 'approvedCount'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $route = $user->role === 'admin' ? 'admin.profile' : 'profile';

        return redirect()->route($route)->with('toast_success', 'Profile updated successfully!');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($user->profile_photo) {
            $old = public_path('uploads/profiles/' . $user->profile_photo);
            if (file_exists($old)) {
                unlink($old);
            }
        }

        $filename = time() . '_' . $user->id . '.' . $request->photo->extension();
        $request->photo->move(public_path('uploads/profiles'), $filename);

        $user->profile_photo = $filename;
        $user->save();

        $route = $user->role === 'admin' ? 'admin.profile' : 'profile';

        return redirect()->route($route)->with('toast_success', 'Profile photo updated successfully!');
    }
}
