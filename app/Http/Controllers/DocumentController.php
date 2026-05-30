<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::where('user_id', Auth::id())->latest()->get();
        return view('user.dashboard', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:PDF,Word,Excel,Image,Other',
            'due_date'    => 'nullable|date',
        ]);

        Document::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'type'        => $request->type,
            'status'      => 'pending',
            'due_date'    => $request->due_date,
        ]);

        return redirect()->route('user.dashboard')
            ->with('toast_success', 'Document submitted successfully!');
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:PDF,Word,Excel,Image,Other',
            'due_date'    => 'nullable|date',
        ]);

        $document->update($request->only('title', 'description', 'type', 'due_date'));

        return redirect()->route('user.dashboard')
            ->with('toast_success', 'Document updated successfully!');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('user.dashboard')
            ->with('toast_success', 'Document deleted successfully!');
    }
}
