<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Question;
use App\Models\User;
use App\Services\UserService;
use App\Services\MaterialService;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $userService;
    protected $materialService;
    protected $questionService;
    public function __construct(UserService $userService, MaterialService $materialService, QuestionService $questionService)
    {
        $this->userService = $userService;
        $this->materialService = $materialService;
        $this->questionService = $questionService;
    }
    public function dashboard()
    {
        $totalStudents = $this->userService->countStudents();
        $totalQuestions = $this->questionService->all()->count();
        $totalMaterials = $this->materialService->all()->count();
        return view('admin.dashboard', compact('totalStudents', 'totalQuestions', 'totalMaterials'));
    }
    
    public function materials()
    {
        $materials = $this->materialService->all();
        return view('admin.materials.index', compact('materials'));
    }
    
    public function questions()
    {
        $questions = $this->questionService->all();
        return view('admin.questions.index', compact('questions'));
    }
    
    public function users()
    {
        $users = $this->userService->all();
        return view('admin.users.index', compact('users'));
    }

    public function usersEdit($id)
    {
        $user = $this->userService->find($id);
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = $this->userService->find($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:admin,student',
        ]);
        $this->userService->update($user, $validated);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function usersDestroy($id)
    {
        $user = $this->userService->find($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}