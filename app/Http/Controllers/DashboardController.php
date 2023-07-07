<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Quize;
//Repository Interfaces
use App\Interface\QuizeRepositoryInterface;
use App\Interface\DashboardRepositoryInterface;

class DashboardController extends Controller
{
  public function __construct(
    public QuizeRepositoryInterface $quizeRepository,
    public DashboardRepositoryInterface $dashboardRepository,
  ) {}

  public function index(Request $request) {
    
    $quizes = $this->quizeRepository->getQuizeQuery([
      ['status', Quize::$activeStatus]
    ])->has('attemptuser')->get();
    
    return Inertia::render('Dashboard', [
      'quizes' => $quizes
    ]);
  }

  public function getUserDataByQuizeId(Request $request) {
    $result = $this->dashboardRepository->getUserByQestion($request);
    return response()->json(['message' => 'Success','code' => 200, 'result'=> $result]);
  }

}