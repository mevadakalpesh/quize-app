<?php
namespace App\RepositoryClass;
use App\Interface\OptionRepositoryInterface;
use App\Models\Option;
class OptionRepository implements OptionRepositoryInterface {

  public function __construct(
    public Option $option,
  ) {}
  
  public function createOption(array $data = []){
    return $this->option->create($data);
  }
  
  public function updateOption(array $where ,array $data){
    return $this->option->where($where)->update($data);
  }
}