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
            'file'        => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/documents'), $filename);
            $filePath = $filename;
        }

        Document::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'type'        => $request->type,
            'status'      => 'pending',
            'due_date'    => $request->due_date,
            'file_path'   => $filePath,
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
            'file'        => 'nullable|file|max:10240',
        ]);

        $filePath = $document->file_path;
        if ($request->hasFile('file')) {
            if ($filePath && file_exists(public_path('uploads/documents/' . $filePath))) {
                unlink(public_path('uploads/documents/' . $filePath));
            }
            $file = $request->file('file');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/documents'), $filename);
            $filePath = $filename;
        }

        $document->update([
            'title'       => $request->title,
            'description' => $request->description,
            'type'        => $request->type,
            'due_date'    => $request->due_date,
            'file_path'   => $filePath,
        ]);

        return redirect()->route('user.dashboard')
            ->with('toast_success', 'Document updated successfully!');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path && file_exists(public_path('uploads/documents/' . $document->file_path))) {
            unlink(public_path('uploads/documents/' . $document->file_path));
        }
        $document->delete();
        return redirect()->route('user.dashboard')
            ->with('toast_success', 'Document deleted successfully!');
    }
}
