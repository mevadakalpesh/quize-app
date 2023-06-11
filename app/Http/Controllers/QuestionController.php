<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use Illuminate\Support\Facades\DB;

//Repository Interfaces
use App\Interface\QuestionRepositoryInterface;
use App\Interface\OptionRepositoryInterface;
use App\Interface\CategoryRepositoryInterface;

//models
use App\Models\Question;

class QuestionController extends Controller
{

  public function __construct(
    public CategoryRepositoryInterface $categoryRepository,
    public QuestionRepositoryInterface $questionRepository,
    public OptionRepositoryInterface $optionRepository
  ) {}


  public function index(Request $request) {
    return Inertia('Question/QuestionListing');
  }
  
  public function getQuestions(Request $request){
  //  return $request->all();
    $questions =  $this->questionRepository->getSearchQuestions($request);
    return response()->json(['message' => 'Success','code' => 200, 'result'=>$questions]);
  }
  /**
  * Show the form for creating a new resource.
  */
  public function create() {
    $categories = $this->categoryRepository->getCategories();
    return Inertia('Question/QuestionCreate', [
      'categories' => $categories,
      'form_type' => 'add'
    ]);
  }

  /**
  * Store a newly created resource in storage.
  */
  public function store(QuestionStoreRequest $request) {
    DB::beginTransaction();
    try {
      $categories = array_column($request->category, 'value');
      $options = $this->questionRepository->formatOptionForCreate($request->options);
      $data = [
        'question_name' => $request->question_name,
        'status' => $request->status ? Question::$activeStatus : Question::$deactiveStatus,
        'explanation' => $request->explanation ?? null,
      ];
      $question = $this->questionRepository->createQuestion($data);

      if (blank($question) || blank($options)) {
        return redirect()->back()->with('error', 'question or option not be blank');
      }

      if (!empty($categories) && !blank($question)) {
        $question->category()->attach($categories);
      }

      $this->questionRepository->createOption($question, $options);

      DB::commit();
      if($request->buttonType == 'back'){
        return redirect()->back()->with('success', 'Question Create Successfully.!');
      }else {
        return redirect()->route('question.index')->with('success', 'Question Create Successfully.!');
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  /**
  * Display the specified resource.
  */
  public function show(string $id) {
    //
  }

  /**
  * Show the form for editing the specified resource.
  */
  public function edit(string $id) {
    $with = [
      'options' => function ($q){
        return $q->selectRaw('id,question_id,option_name,status');
      },
      'category' => function ($q){
        return $q->selectRaw('categories.id,categories.name');
      }
    ];
    $categories = $this->categoryRepository->getCategories(selectQ:'id,name');
    $question = $this->questionRepository->getQuestion([['id', $id]
    ],$with);
    
    return Inertia('Question/QuestionCreate', [
      'categories' => $categories,
      'question' => $question,
      'form_type' => 'edit'
    ]);
  }

  /**
  * Update the specified resource in storage.
  */
  public function update(QuestionUpdateRequest $request, string $id) {
    
    DB::beginTransaction();
    try {
      $data = [
        'question_name' => $request->question_name,
        'status' => $request->status ? Question::$activeStatus : Question::$deactiveStatus,
        'explanation' => $request->explanation ?? '',
      ];

      $question = $this->questionRepository->updateQuestion([['id', $id]], $data);
      foreach ($request->options as $option) {
        $option_id = $option['id'];
        unset($option['id']);
        $this->optionRepository->updateOption([['id', $option_id]], $option);
      }
      
      $question = $this->questionRepository->getQuestion([['id',$id]]);
      $categories = array_column($request->category, 'value');
      if (!empty($categories) && !blank($question)) {
        $question->category()->sync($categories);
      }
      
      DB::commit();
      return redirect()->route('question.index')->with('success', 'Question
      Update Successfully.!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }


  }

  /**
  * Remove the specified resource from storage.
  */
  public function destroy(string $id) {
    $resut = $this->questionRepository->deleteQuestion([['id',$id]]);
    if($resut){
      request()->session()->flash('success','Question Deleted Successfully..!');
      return  response()->json(['message' => 'Question Deleted Successfully..!','code' => 200,
      'result'=> []]);
    }  else {
      return  response()->json(['message' => 'Something Went Wrong','code' => 101,
      'result'=> []]);
    }
  }
}