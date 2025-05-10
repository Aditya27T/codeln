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

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,student',
        ]);
        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}