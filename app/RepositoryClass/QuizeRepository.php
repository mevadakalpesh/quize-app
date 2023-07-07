<?php
namespace App\RepositoryClass;
use App\Interface\QuizeRepositoryInterface;
use App\Models\Quize;
use App\Models\UserQuizeDetails;
use App\Models\UserQuizeHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizeRepository implements QuizeRepositoryInterface {

  public function __construct(
    public Quize $quize,
    public UserQuizeHistory $quizeUserHistory,
  ) {}

  public function createQuize(array $data = []) {
    return $this->quize->create($data);
  }

  public function getQuize(array $where = [], array $with = []) {
    return $this->quize->where($where)->with($with)->first();
  }

  public function getQuizes(array $where = [], array $with = []) {
    return $this->quize->where($where)->with($with)->get();
  }

  public function getQuizeQuery(array $where = [], array $with = []) {
    return $this->quize->where($where)->with($with);
  }


  public function getQuizesWithCondition(array $where = [], array $with = []) {

    return $this->quize
    ->where($where)
    ->with($with)
    ->where(function ($query) {
      $query->doesntHave('users')
      ->orWhereHas('users', function($subQuery) {
        $subQuery->where('users.id', Auth::user()->id);
      });
    })
    ->where(function ($query) {
      $query->doesntHave('quizeUserDetails')
      ->orWhereHas('quizeUserDetails', function ($subQuery) {
        $subQuery->where('status', '!=', UserQuizeDetails::$Declined);
      });
    })
    ->get();
  }

  public function updateQuize(array $where = [], array $data = []) {
    return $this->quize->where($where)->update($data);
  }

  public function deleteQuize(array $where = []) {
    return $this->quize->where($where)->delete($data);
  }

  public function getSearchQuizes(Request $request) {
    $start = $request->start ?? 0;
    $size = $request->size ?? 10;
    $sorting = is_array($request->sorting) ? $request->sorting : json_decode($request->sorting);
    $filters = is_array($request->filters) ? $request->filters : json_decode($request->filters);
    $globalFilter = isset($request->globalFilter) && !blank($request->globalFilter) ? $request->globalFilter : null;

    $data = $this->quize
    ->from('quizes as qu')
    ->selectRaw('qu.*')
    ->when(!blank($sorting), function($query) use ($sorting) {
      foreach ($sorting as $sortCol) {
        $sortId = $sortCol->id;
        $query->orderBy($sortId, $sortCol->desc === true ? 'desc' : 'asc');
      }
    })
    ->when(!blank($filters), function($query) use ($filters) {
      $query->where(function($q) use ($filters) {
        foreach ($filters as $filter) {
          $filterId = $filter->id;
          $q->where($filterId, 'like', '%'.$filter->value.'%');
        }
      });
    })
    ->when(!blank($globalFilter), function ($query) use ($globalFilter) {
      $query->where(function($q) use ($globalFilter) {
        $q->where('qu.quize_name', 'like', '%'.$globalFilter.'%')
        ->orWhere('qu.description', 'like', '%'.$globalFilter.'%')
        ->orWhere('qu.status', 'like', '%'.$globalFilter.'%')
        ->orWhere('qu.expire_time', 'like', '%'.$globalFilter.'%')
        ->orWhere('qu.created_at', 'like', '%'.$globalFilter.'%')
        ->orWhere('op.quize_status', 'like', '%'.$globalFilter.'%');
      });
    });
    $count = $data->count();
    $data = $data->skip($start)->limit($size)->get();

    return [
      'quizes' => $data,
      'quizes_count' => $count
    ];
  }

  public function saveQuizeUserHistory(Request $request) {

    $quize_id = $request->quize_id;
    $question_id = $request->question_id;
    $user_answer_option_id = $request->option_id;
    $right_option_id = $request->right_option_id;

    $status = ($user_answer_option_id == $right_option_id ? UserQuizeHistory::$rightStatus : UserQuizeHistory::$wrongStatus);
    return $this->quizeUserHistory->create([
      'user_id' => Auth::user()->id,
      'quize_id' => $quize_id,
      'question_id' => $question_id,
      'user_answer_option_id' => $user_answer_option_id,
      'right_option_id' => $right_option_id,
      'status' => $status,
    ]);

  }

  public function getQuizeUserHistories(array $where = [], array $with = []) {
    return $this->quizeUserHistory->where($where)->with($with)->get();
  }


}