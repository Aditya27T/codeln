<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::all();
    }
    public function find($id)
    {
        return User::findOrFail($id);
    }
    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }
    public function delete(User $user)
    {
        $user->delete();
    }
    public function countStudents()
    {
        return User::where('role', 'student')->count();
    }
}
