<?php
namespace App\Interface;
use Illuminate\Http\Request;

interface DashboardRepositoryInterface {
 public function getUserByQestion($request);
}