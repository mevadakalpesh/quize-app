<?php
namespace App\RepositoryClass;
use App\Interface\QuestionRepositoryInterface;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Interface\OptionRepositoryInterface;
class QuestionRepository implements QuestionRepositoryInterface {

  public function __construct(
    public Question $question,
    public OptionRepository $optionRepository
  ) {}

  public function getQuestion(array $where = [],array $with = []) {
    return $this->question->where($where)->with($with)->first();
  }

  public function getQuestions(array $where = [],array $with = [],string $selectRaw = '') {
    return $this->question->when(!blank($selectRaw),function($query) use ($selectRaw){
      return $query->selectRaw();
    })
    ->where($where)->get();
  }

  public function createQuestion(array $data = []) {
    return $this->question->create($data);
  }

  public function createOption(Question $question, array $data = []) {
    foreach ($data as $option){
      $optionModel = new Option($option);
      $question->options()->save($optionModel);
    }
  }

  public function formatOptionForCreate(array $data = []) :array
  {
    
    $optionData = [];
    if(blank($data) || empty($data)){
      return [];
    }
    foreach ($data as $option) {
      $option['status'] = $option['status'] ? Option::$rightStatus : Option::$wrongStatus;
      if (!isset($option['id']) || $option['id'] == 0) {
        unset($option['id']);
      }
      $optionData[] = $option;
    }
    return $optionData;
  }
  
  public function updateQuestion(array $where = [], array $data = []){
    return $this->question->where($where)->update($data);
  }
  
  public function getSearchQuestions(Request $request){
    $start = $request->start ?? 0;
    $size = $request->size ?? 10;
    $sorting = is_array($request->sorting) ? $request->sorting :  json_decode($request->sorting);
    $filters = is_array($request->filters) ? $request->filters :  json_decode($request->filters);
    $globalFilter = isset($request->globalFilter) && !blank($request->globalFilter) ? $request->globalFilter : null ;

   $data =  $this->question
   ->from('questions as qs')
   ->join('options as op','op.question_id','=','qs.id')
   ->selectRaw('qs.*,op.option_name as answer')
   ->where('op.status',Option::$rightStatus)
   ->when(!blank($sorting),function($query) use ($sorting) {
      foreach ($sorting as $sortCol){
        $sortId = $sortCol->id == 'answer' ? 'op.option_name' : 'qs.'.$sortCol->id;
        $query->orderBy($sortId,$sortCol->desc === true ? 'desc' : 'asc');
      }
    })
    ->when(!blank($filters),function($query) use ($filters){
       $query->where(function($q) use ($filters) {
         foreach ($filters as $filter){
            $filterId = $filter->id == 'answer' ? 'op.option_name' : 'qs.'.$filter->id;
            $q->where($filterId,'like','%'.$filter->value.'%');
         }
       });
    })
    ->when(!blank($globalFilter),function ($query) use ($globalFilter) {
      $query->where(function($q) use ($globalFilter){
        $q->where('qs.question_name','like','%'.$globalFilter.'%')
            ->orWhere('qs.explanation','like','%'.$globalFilter.'%')
            ->orWhere('qs.created_at','like','%'.$globalFilter.'%')
            ->orWhere('op.option_name','like','%'.$globalFilter.'%');
      });
    });
    $count = $data->count();
    $data = $data->skip($start)->limit($size)->get();

    return [
      'questions' => $data,
      'questions_count' => $count
    ];
  }
  
  public function deleteQuestion(array $where){
    return $this->question->where($where)->delete();
  }
}