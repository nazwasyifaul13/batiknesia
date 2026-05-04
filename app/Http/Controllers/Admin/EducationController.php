<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::latest()->paginate(10);
        return view('admin.education.index', compact('educations'));
    }
    
    public function create()
    {
        return view('admin.education.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:article,video',
            'content' => 'required_if:type,article|nullable|string',
            'youtube_url' => 'required_if:type,video|nullable|url',
            'thumbnail' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|string',
            'is_published' => 'boolean'
        ]);
        
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('education', 'public');
        }
        
        Education::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'type' => $request->type,
            'content' => $request->content,
            'youtube_url' => $request->youtube_url,
            'thumbnail' => $thumbnailPath,
            'excerpt' => $request->excerpt,
            'is_published' => $request->is_published ?? false,
            'author' => auth()->user()->name,
        ]);
        
        return redirect()->route('admin.education.index')->with('success', 'Konten edukasi berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $education = Education::findOrFail($id);
        return view('admin.education.edit', compact('education'));
    }
    
    public function update(Request $request, $id)
    {
        $education = Education::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:article,video',
            'content' => 'required_if:type,article|nullable|string',
            'youtube_url' => 'required_if:type,video|nullable|url',
            'thumbnail' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|string',
            'is_published' => 'boolean'
        ]);
        
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('education', 'public');
            $education->thumbnail = $thumbnailPath;
        }
        
        $education->update([
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'youtube_url' => $request->youtube_url,
            'excerpt' => $request->excerpt,
            'is_published' => $request->is_published ?? false,
        ]);
        
        return redirect()->route('admin.education.index')->with('success', 'Konten edukasi berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->delete();
        
        return redirect()->route('admin.education.index')->with('success', 'Konten edukasi berhasil dihapus');
    }
}