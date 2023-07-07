<?php
namespace App\RepositoryClass;
use App\Interface\DashboardRepositoryInterface;
use App\Interface\QuizeRepositoryInterface;
use App\Models\UserQuizeHistory;
use App\Models\Quize;
use Illuminate\Http\Request;

class DashboardRepository implements DashboardRepositoryInterface {

  public function __construct(
    public UserQuizeHistory $userQuizeHistory,
    public QuizeRepositoryInterface $quizeRepository,
  ) {}

  public function getUserByQestion($request) {
    $quize_id = $request->value;
    $rightAnswer = UserQuizeHistory::$rightStatus;
    $with = [
      'attemptuser' => function ($query) use ($rightAnswer) {
        $query->selectRaw('user_quize_histories.*,count(*) as result')
        ->where('status', $rightAnswer)
        ->with('user:id,name')
        ->has('user')
        ->orderByRaw('count(*) asc')
        ->groupBy('user_quize_histories.user_id');
      }];
    $quizes = $this->quizeRepository->getQuizeQuery([
      ['status', Quize::$activeStatus],
      ['id',$quize_id]
    ], $with)
    ->withCount('questions')
    ->has('attemptuser')->get();

    $reportData = [];
    if (!blank($quizes)) {
      foreach ($quizes as $quize) {
        $users = [];
        $result = [];
        if (!blank($quize->attemptuser)) {
          foreach ($quize->attemptuser as $userResult) {
            $users[] = $userResult->user->name;
            $result[] = $userResult->result;
          }
        }
        $reportData['quize_'.$quize->id] = [
          'users' => $users,
          'result' => $result,
          'questions_count' => $quize->questions_count
          ];
      }
    }
    return $reportData;
  }
}