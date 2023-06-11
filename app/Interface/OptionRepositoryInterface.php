<?php
namespace App\Interface;

interface OptionRepositoryInterface {
  public function createOption(array $data = []);
  public function updateOption(array $where ,array $data);
  
}