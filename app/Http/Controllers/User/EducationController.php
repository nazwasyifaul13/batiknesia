<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $articles = Education::where('is_published', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        return view('user.education', compact('articles'));
    }
    
    public function detail($id)
    {
        $article = Education::findOrFail($id);
        return view('user.education-detail', compact('article'));
    }
}