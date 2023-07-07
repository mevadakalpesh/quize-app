<?php
namespace App\Interface;
use App\Models\Quize;
use Illuminate\Http\Request;
interface QuizeRepositoryInterface {
  public function getQuize(array $where = [],array $with = []);
  public function getQuizes(array $where = [],array $with = []);
  public function createQuize(array $data = []);
  public function updateQuize(array $where = [], array $data = []);
  public function getSearchQuizes(Request $request);
  public function deleteQuize(array $where);
 
  public function saveQuizeUserHistory(Request $request);
  public function getQuizeUserHistories(array $where = [], array $with = []);
  public function getQuizesWithCondition(array $where = [],array $with = []);
  public function getQuizeQuery(array $where = [],array $with = []);
  /*
  public function getQuizes(array $where = [],array $with = [],string $selectRaw = '');
  */
   
}