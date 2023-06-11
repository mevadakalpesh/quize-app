<?php
namespace App\RepositoryClass;
use App\Interface\CategoryRepositoryInterface;
use App\Models\Category;
class CategoryRepository implements CategoryRepositoryInterface {

  public function __construct(
    public Category $category,
  ) {}
  
  public function getCategory(array $where = []){
    return $this->category->where($where)->first();
  }
  public function getCategories(array $where = [],string $selectQ = ''){
    return $this->category->when(!blank($selectQ),function($query) use ($selectQ) {
      return $query->selectRaw($selectQ);
      })->where($where)->get();
  }
}