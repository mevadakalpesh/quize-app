<?php
namespace App\Interface;

interface CategoryRepositoryInterface {
  public function getCategory(array $where = []);
  public function getCategories(array $where = [],string $selectQ = '');
}