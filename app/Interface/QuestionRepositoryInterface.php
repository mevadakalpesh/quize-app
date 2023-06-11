<?php
namespace App\Interface;
use App\Models\Question;
use Illuminate\Http\Request;
interface QuestionRepositoryInterface {
  public function getQuestion(array $where = [],array $with = []);
  public function getQuestions(array $where = [],array $with = [],string $selectRaw = '');
  public function createQuestion(array $data = []);
  public function createOption(Question $question,array $data = []);
  public function formatOptionForCreate(array $data = []);
  public function updateQuestion(array $where = [], array $data = []);
  public function getSearchQuestions(Request $request);
  public function deleteQuestion(array $where);
  
   
}