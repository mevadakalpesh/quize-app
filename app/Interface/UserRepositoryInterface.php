<?php
namespace App\Interface;
use App\Models\User;
use Illuminate\Http\Request;
interface UserRepositoryInterface {
  public function getUser(array $where = [],array $with = []);
  public function getUsers(array $where = [],array $with = [],string $selectRaw = '');
  public function createUser(array $data = []);
  //public function updateUser(array $where = [], array $data = []);
  //public function getSearchUsers(Request $request);
  //public function deleteUser(array $where);
  
   
}