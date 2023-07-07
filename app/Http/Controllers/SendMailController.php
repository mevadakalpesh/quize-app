<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interface\SendMailRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TemplateUpdateRequest;
use App\Http\Requests\TemplateCreateRequest;
use App\Http\Requests\ClientSendMailRequest;
use App\Jobs\SendClientMailJob;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;


class SendMailController extends Controller
{

  public function __construct(
    public SendMailRepositoryInterface $sendMailRepository
  ) {}

  public function index(Request $request) {
    $templates = $this->sendMailRepository->getTemplates();
    return Inertia('SendMail/MailLists', [
      'templates' => $templates
    ]);
  }

  public function create(Request $request) {
    return Inertia('SendMail/CreateOrUpdateTemplate', [
      'form_type' => 'add',
      'template' => [],
    ]);
  }

  public function store(TemplateCreateRequest $request) {
    DB::beginTransaction();
    try {
      $data = [
        'subject' => $request->subject,
        'body' => $request->body
      ];
      $template = $this->sendMailRepository->createTemplate($data);
      DB::commit();
      return redirect()->route('templates.index')->with('success', 'Templates Create Successfully.!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  public function edit(string $id) {

    $template = $this->sendMailRepository->getTemplate([
      ['id', $id]
    ]);

    return Inertia('SendMail/CreateOrUpdateTemplate', [
      'form_type' => 'edit',
      'template' => $template,
    ]);
  }

  public function sendMail(Request $request) {
    $templates = $this->sendMailRepository->getTemplates();
    return Inertia('SendMail/SendMailView', [
      'templates' => $templates,
    ]);
  }

  public function sendClientMail(ClientSendMailRequest $request) {
    $data = $request->all();
    $data['template'] = $data['template']['value'];
    
    $emails = explode(',', $data['emails']);
    $templatesData = MailTemplate::find($data['template']);
    
    if ($emails) {
      foreach ($emails as $email) {
        $email = trim($email);
        if($email && filter_var($email, FILTER_VALIDATE_EMAIL)){
          SendClientMailJob::dispatch($email,$templatesData,$data)->delay(now()->addSeconds(2));
        }
      }
    }
    
    return redirect()->route('templates.index')->with('success', 'Mail Sent Successfully.!');
  }


  public function update(TemplateUpdateRequest $request, $id) {

    DB::beginTransaction();
    try {
      $data = [
        'subject' => $request->subject,
        'body' => $request->body
      ];
      $template = $this->sendMailRepository->updateTemplate([
        ['id', $id]
      ], $data);
      DB::commit();
      return redirect()->route('templates.index')->with('success', 'Templates
      Update Successfully.!');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }

  public function destroy(string $id) {
    $result = $this->sendMailRepository->deleteTemplate([['id', $id]]);
    if (!blank($result)) {
      return response()->json(['message' => 'Success', 'code' => 200, 'result' => 'Template Deleted Succssfully']);
    } else {
      return response()->json(['message' => 'Error', 'code' => 101, 'result' => []]);
    }
  }

}