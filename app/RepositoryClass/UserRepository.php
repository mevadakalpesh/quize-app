<?php
namespace App\RepositoryClass;
use App\Interface\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository implements UserRepositoryInterface {

  public function __construct(
    public User $user,
  ) {}

  public function getUsers(array $where = [], array $with = [], string $selectRaw = '') {
    return $this->user->when(!blank($selectRaw), function($query) use ($selectRaw) {
      return $query->selectRaw();
    })
    ->where($where)->get();
  }
}