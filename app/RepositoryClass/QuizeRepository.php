<?php
namespace App\RepositoryClass;
use App\Interface\QuizeRepositoryInterface;
use App\Models\Quize;
use Illuminate\Http\Request;

class QuizeRepository implements QuizeRepositoryInterface {

  public function __construct(
    public Quize $quize,
  ) {}


}