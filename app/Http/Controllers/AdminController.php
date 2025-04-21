<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalQuestions = Question::count();
        $totalMaterials = Material::count();
        
        return view('admin.dashboard', compact('totalStudents', 'totalQuestions', 'totalMaterials'));
    }
    
    public function materials()
    {
        $materials = Material::orderBy('order')->get();
        return view('admin.materials.index', compact('materials'));
    }
    
    public function questions()
    {
        $questions = Question::all();
        return view('admin.questions.index', compact('questions'));
    }
    
    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
}