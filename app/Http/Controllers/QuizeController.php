<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\QuizeStoreRequest;
use App\Http\Requests\QuizeUpdateRequest;
use App\Models\User;
use App\Models\Quize;
use Illuminate\Support\Facades\DB;

//Repository Interfaces
use App\Interface\CategoryRepositoryInterface;
use App\Interface\QuizeRepositoryInterface;
use App\Interface\UserRepositoryInterface;
use App\Interface\QuestionRepositoryInterface;

class QuizeController extends Controller
{
  public function __construct(
    public CategoryRepositoryInterface $categoryRepository,
    public QuizeRepositoryInterface $quizeRepository,
    public UserRepositoryInterface $userRepository,
    public QuestionRepositoryInterface $questionRepository,
  ) {}

  /**
  * Display a listing of the resource.
  */
  public function index() {
    return Inertia('Quize/QuizeListing');
  }
  
  
  public function getQuizes(Request $request){
    $questions =  $this->quizeRepository->getSearchQuizes($request);
    return response()->json(['message' => 'Success','code' => 200, 'result'=>$questions]);
  }
  /**
  * Show the form for creating a new resource.
  */
  public function create() {
    $users = $this->userRepository->getUsers([['is_admin', '!=', User::$admin]]);
    $categories = $this->categoryRepository->getCategories();
    return Inertia('Quize/QuizeCreate', [
      'categories' => $categories,
      'users' => $users,
      'form_type' => 'add'
    ]);
  }

  /**
  * Store a newly created resource in storage.
  */
  public function store(QuizeStoreRequest $request) {
    //return $request->all();
    DB::beginTransaction();
    try {
      $categories = array_column($request->category  ?? [], 'value');
      $users = array_column($request->users  ?? [], 'value');
      $questions = array_column($request->questions  ?? [], 'value');
      $buttonType = isset($request->buttonType) ? $request->buttonType  :'back';
      $data = [
        'quize_name' => $request->quize_name,
        'expire_time' => $request->expire_time,
        'status' => $request->status ? Quize::$activeStatus : Quize::$deactiveStatus,
        'description' => $request->description ?? null,
      ];

      $quize = $this->quizeRepository->createQuize($data);

      if (blank($quize)) {
        return redirect()->back()->with('error', 'something went wrong');
      }

      if (!empty($categories) && !blank($quize)) {
        $quize->category()->attach($categories);
      }
      
      if (!empty($users) && !blank($quize)) {
          $quize->users()->attach($users);
      }
      
      $quize->questions()->attach($questions);

      DB::commit();
      return redirect()->route('quize.index')->with('success', 'Quize Create Successfully.!');

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
      'users',
      'category',
      'questions'
    ];
    $quize = $this->quizeRepository->getQuize([['id',$id]],$with);
    
 //dd($quize->toArray());
    
    $users = $this->userRepository->getUsers([['is_admin', '!=', User::$admin]]);
    $categories = $this->categoryRepository->getCategories();
    return Inertia('Quize/QuizeCreate', [
      'categories' => $categories,
      'users' => $users,
      'quize' => $quize,
      'form_type' => 'edit'
    ]);
  }

  /**
  * Update the specified resource in storage.
  */
  public function update(QuizeUpdateRequest $request, string $id) {
   //dd($request->all());
    DB::beginTransaction();
    try {
      $trueStatuArray  = [1,true,'Active'];
      $categories = array_column($request->category ?? [], 'value');
      $users = array_column($request->users ?? [], 'value');
      $questions = array_column($request->questions ?? [], 'value');
      $buttonType = isset($request->buttonType) ? $request->buttonType  :'back';
      
      $data = [
        'quize_name' => $request->quize_name,
        'expire_time' => $request->expire_time,
        'status' => in_array($request->status,$trueStatuArray,true) ? Quize::$activeStatus : Quize::$deactiveStatus,
        'description' => $request->description ?? null,
      ];
    
      $this->quizeRepository->updateQuize([['id',$id]],$data);
      
      $quize =  $this->quizeRepository->getQuize([
        ['id',$id]
      ]);

      if (blank($quize)) {
        return redirect()->back()->with('error', 'something went wrong');
      }

        $quize->category()->sync($categories);
        $quize->users()->sync($users);
        $quize->questions()->sync($questions);

      DB::commit();
      return redirect()->route('quize.index')->with('success', 'Quize Update Successfully.!');

    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  /**
  * Remove the specified resource from storage.
  */
  public function destroy(string $id) {
    $result = $this->quizeRepository->deleteQuize([['id',$id]]);
    if (!blank($result)) {
      return response()->json(['message' => 'Success', 'code' => 200, 'result'
      => 'Quize Deleted Succssfully']);
    } else {
      return response()->json(['message' => 'Error', 'code' => 101, 'result' => []]);
    }
  }

  public function getQuestionByCategory(Request $request) {
    $questions = $this->questionRepository->getQuestionByCategories($request);
    return response()->json(['message' => 'Success', 'code' => 200, 'result' => $questions]);
  }
}