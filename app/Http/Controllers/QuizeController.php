<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\QuizeStoreRequest;
use App\Http\Requests\QuizeUpdateRequest;
use App\Models\User;

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
    //
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
    //
  }

  /**
  * Update the specified resource in storage.
  */
  public function update(QuizeUpdateRequest $request, string $id) {
    //
  }

  /**
  * Remove the specified resource from storage.
  */
  public function destroy(string $id) {
    //
  }

  public function getQuestionByCategory(Request $request) {
   $questions = $this->questionRepository->getQuestionByCategories($request);
   if(!blank($questions)){
     return response()->json(['message' => 'Success','code' => 200, 'result'=> $questions]);
   }else{
     return response()->json(['message' => 'Error','code' => 101, 'result'=> []]);
   }
  }
}