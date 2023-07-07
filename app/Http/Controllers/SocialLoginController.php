<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//Repository Interfaces
use App\Interface\UserRepositoryInterface;

class SocialLoginController extends Controller
{

  public function __construct(
    public UserRepositoryInterface $userRepository,
  ) {}


  public function socialLogin($provider) {
    return Socialite::driver($provider)->redirect();
  }

  public function socialLoginCallback(Request $request, $provider) {
    DB::beginTransaction();
    try {
      $user = Socialite::driver($provider)->user();
      if (blank($user)) {
        return redirect()->route('login')->with('error', 'something went wrong');
      }
      if (User::where('email', $user->email)->where('provider_type', '!=', $provider)->exists()) {
        return redirect()->route('login')->with('error', 'The email already login with differnt social app.');
      }
      $authUser = $this->userRepository->getUser([
        ['email', $user->email],
        ['provider_type', $provider],
        ['is_admin', User::$user],
      ]);

      if (blank($authUser)) {
        $auth_name = 'unknown';
        if (!blank($user->name)) {
          $auth_name = $user->name;
        } else if (!blank($user->nickname)) {
          $auth_name = $user->nickname;
        }
        $data = [
          'name' => $auth_name,
          'avatar' => $user->avatar ?? null,
          'email' => $user->email,
          'provider_id' => $user->id,
          'provider_type' => $provider
        ];
        $authUser = $this->userRepository->createUser($data);
      }

      Auth::login($authUser);
      
      DB::commit();
      return redirect()->route('UserQuizeList')->with('success', 'Login Successfully..!');

    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('login')->with('error', $e->getMessage());
    }
  }
}