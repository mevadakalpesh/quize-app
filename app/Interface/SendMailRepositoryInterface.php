<?php
namespace App\Interface;
use App\Models\Quize;
use Illuminate\Http\Request;
interface SendMailRepositoryInterface {
  
  public function getTemplate(array $where = [],array $with = []);
  public function getTemplates(array $where = [],array $with = []);
  public function createTemplate(array $data = []);
  public function updateTemplate(array $where = [],array $data = []);
  public function deleteTemplate(array $where = []);

   
}