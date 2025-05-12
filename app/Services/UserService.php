<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function all()
    {
        return $this->userRepository->all();
    }
    public function find($id)
    {
        return $this->userRepository->find($id);
    }
    public function update(User $user, array $data)
    {
        return $this->userRepository->update($user, $data);
    }
    public function delete(User $user)
    {
        return $this->userRepository->delete($user);
    }
    public function countStudents()
    {
        return $this->userRepository->countStudents();
    }
}
