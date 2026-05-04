<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatikPattern;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BatikPatternController extends Controller
{
    public function index()
    {
        $patterns = BatikPattern::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.batik-patterns.index', compact('patterns'));
    }

    public function create()
    {
        return view('admin.batik-patterns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'philosophy' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_url' => 'nullable|url',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/batik-patterns'), $filename);
            $imagePath = 'images/batik-patterns/' . $filename;
        }

        BatikPattern::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'origin' => $request->origin,
            'philosophy' => $request->philosophy,
            'description' => $request->description,
            'image' => $imagePath,
            'video_url' => $request->video_url,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.batik-patterns.index')->with('success', 'Motif batik berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pattern = BatikPattern::findOrFail($id);
        return view('admin.batik-patterns.edit', compact('pattern'));
    }

    public function update(Request $request, $id)
    {
        $pattern = BatikPattern::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'philosophy' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_url' => 'nullable|url',
        ]);

        $imagePath = $pattern->image;
        if ($request->hasFile('image')) {
            if ($pattern->image && file_exists(public_path($pattern->image))) {
                unlink(public_path($pattern->image));
            }
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/batik-patterns'), $filename);
            $imagePath = 'images/batik-patterns/' . $filename;
        }

        $pattern->update([
            'name' => $request->name,
            'origin' => $request->origin,
            'philosophy' => $request->philosophy,
            'description' => $request->description,
            'image' => $imagePath,
            'video_url' => $request->video_url,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.batik-patterns.index')->with('success', 'Motif batik berhasil diupdate');
    }

    public function destroy($id)
    {
        $pattern = BatikPattern::findOrFail($id);
        if ($pattern->image && file_exists(public_path($pattern->image))) {
            unlink(public_path($pattern->image));
        }
        $pattern->delete();
        
        return redirect()->route('admin.batik-patterns.index')->with('success', 'Motif batik berhasil dihapus');
    }
}