<?php

namespace App\Http\Controllers\API;

use DB;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Repositories\AttachmentRepository;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{
    protected $attachmentRepository;

    /**
     * ContactController constructor.
     * @param AttachmentRepository $attachment
     */
    public function __construct(AttachmentRepository $attachment)
    {
        $this->attachmentRepository = $attachment;
    }

    /**
     * Return all contacts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return new JsonResponse(ContactResource::collection(Contact::all()));
    }

    /**
     * Show contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return new JsonResponse(new ContactResource($contact));
    }

    /**
     * Store contact.
     *
     * @param ContactRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(ContactRequest $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $data['ip'] = $request->ip();

            $attachment = $this->attachmentRepository->uploadAttachment($data['attachment']);
            $data['attachment_id'] = $attachment->id;

            $contact = Contact::create($data);

            Mail::send(new ContactMail($contact));

            DB::commit();
            return new JsonResponse(new ContactResource($contact), JsonResponse::HTTP_CREATED);
        }catch (\Exception $exception){
            DB::rollBack();
            if (config('app.debug')) {
                throw $exception;
            }

            return new JsonResponse(['message' => 'Erro ao tentar salvar. Caso o problema persista, entre em contato com o suporte.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
