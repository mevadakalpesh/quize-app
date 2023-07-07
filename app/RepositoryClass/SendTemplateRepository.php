<?php
namespace App\RepositoryClass;
use App\Interface\SendMailRepositoryInterface;
use App\Models\MailTemplate;
use Illuminate\Http\Request;

class SendTemplateRepository implements SendMailRepositoryInterface {

  public function __construct(
    public MailTemplate $mailTemplate,
  ) {}

  public function getTemplate(array $where = [], array $with = []) {
    return $this->mailTemplate->where($where)->with($with)->first();
  }

  public function getTemplates(array $where = [], array $with = []) {
    return $this->mailTemplate->where($where)->with($with)->get();
  }

  public function createTemplate(array $data = []) {
    return $this->mailTemplate->create($data);
  }

  public function updateTemplate(array $where = [], array $data = []) {
    return $this->mailTemplate->where($where)->update($data);
  }

  public function deleteTemplate(array $where = []) {
    return $this->mailTemplate->where($where)->delete();
  }


}