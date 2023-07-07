<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Quize;
use App\Models\Option;
use App\Models\UserQuizeDetails;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
//Repository Interfaces
use App\Interface\QuizeRepositoryInterface;
use App\Interface\OptionRepositoryInterface;
use App\Events\UserQuizeStatusChangeEvent;


class UserAttemptQuizeController extends Controller
{
  public function __construct(
    public QuizeRepositoryInterface $quizeRepository,
    public OptionRepositoryInterface $optionRepository,
  ) {}

  public function UserQuizeList() {
    
    $with = ['category','users','questions','quizeUserDetails'];
    
    $quizes = $this->quizeRepository->getQuizesWithCondition([
      ['status', Quize::$activeStatus],
      ['quize_status', Quize::$runningStatus],
    ], $with);
    return Inertia::render('User/UserQuestionList', [
      'quizes' => $quizes,
    ]);
  }

  public function quizeJoin($quize) {
    
    event(new UserQuizeStatusChangeEvent(
      $quize,
      UserQuizeDetails::$Atttemted,
      $this->quizeRepository
    ));
  
    $with = ['category','questions'];
    $quizes = $this->quizeRepository->getQuize([
      ['id', $quize],
      ['status', Quize::$activeStatus],
      ['quize_status', Quize::$runningStatus],
    ], $with);

    if (!blank($quizes)) {
      $quizeUrl = URL::temporarySignedRoute(
        'userQuestionListing',
        now()->addMinutes($quizes->expire_time),
        ['quize' => $quizes]
      );
      return redirect($quizeUrl);
    } else {
      return redirect()->back()->with('error', 'Quize not found');
    }

  }


  public function quizeDecline($quize) {
    event(new UserQuizeStatusChangeEvent(
      $quize,
      UserQuizeDetails::$Declined,
      $this->quizeRepository
    ));
  }

  public function userQuestionListing(Request $request, $quize) {
    if (! $request->hasValidSignature()) {
      return redirect()->route('timeUp');
    }
    $with = ['category',
      'questions',
      'questions.options'];
    $quizes = $this->quizeRepository->getQuize([
      ['id', $quize],
      ['status', Quize::$activeStatus],
      ['quize_status', Quize::$runningStatus],
    ], $with);

    $quizeHistories = $this->quizeRepository->getQuizeUserHistories([
      ['user_id', Auth::user()->id],
      ['quize_id', $quizes->id]
    ]);

    return Inertia::render('User/QuestionExam', [
      'quizes' => $quizes,
      'quizeHistories' => $quizeHistories
    ]);
  }

  /**
  * Show the form for editing the specified resource.
  */
  public function timeUp(Request $request) {
    return Inertia::render('User/TimeUp');
  }

  /**
  * Update the specified resource in storage.
  */
  public function userSaveQuizeHistory(Request $request) {
    $optionData = $this->optionRepository->getOption([
      ['question_id', $request->question_id],
      ['status', Option::$rightStatus],
    ]);
    $request->mergeIfMissing([
      'right_option_id' => $optionData->id
    ]);
    $result = $this->quizeRepository->saveQuizeUserHistory($request);
    return response()->json(['status' => 200, 'message' => 'success']);
  }

  /**
  * Remove the specified resource from storage.
  */
  public function destroy(string $id) {
    //
  }
}