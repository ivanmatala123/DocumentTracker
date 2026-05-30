<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $totalUsers   = User::count();
            $totalDocs    = Document::count();
            $approvedDocs = Document::where('status', 'approved')->count();
            $pendingDocs  = Document::where('status', 'pending')->count();
            $rejectedDocs = Document::where('status', 'rejected')->count();
        } catch (\Exception $e) {
            $totalUsers = $totalDocs = $approvedDocs = $pendingDocs = $rejectedDocs = 0;
        }

        return view('admin.dashboard', compact('totalUsers', 'totalDocs', 'approvedDocs', 'pendingDocs', 'rejectedDocs'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,user',
            'status'   => 'required|in:active,inactive',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.users')->with('toast_success', 'User added successfully!');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'role'   => 'required|in:admin,user',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($request->only('name', 'email', 'role', 'status'));

        return redirect()->route('admin.users')->with('toast_success', 'User updated successfully!');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('toast_success', 'User deleted successfully!');
    }

    public function documents()
    {
        $documents = Document::with('user')->latest()->get();
        return view('admin.documents', compact('documents'));
    }

    public function updateDocumentStatus(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:pending,in-review,approved,rejected',
        ]);

        $document->update(['status' => $request->status]);

        return redirect()->route('admin.documents')->with('toast_success', 'Document status updated!');
    }

    public function deleteDocument(Document $document)
    {
        $document->delete();
        return redirect()->route('admin.documents')->with('toast_success', 'Document deleted successfully!');
    }
}
