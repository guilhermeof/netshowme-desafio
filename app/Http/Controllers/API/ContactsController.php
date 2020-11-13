<?php

namespace App\Http\Controllers\API;

use DB;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Repositories\AttachmentRepository;

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
     * Store contact.
     *
     * @param ContactRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(ContactRequest $request)
    {
        try{
            $data = $request->all();
            $data['ip'] = $request->ip();

            $attachment = $this->attachmentRepository->uploadAttachment($data['attachment']);
            $data['attachment_id'] = $attachment->id;

            $contact = Contact::create($data);

            return new JsonResponse(new ContactResource($contact), JsonResponse::HTTP_CREATED);
        }catch (\Exception $exception){
            if (config('app.debug')) {
                throw $exception;
            }

            return new JsonResponse(['message' => 'Erro ao tentar salvar. Caso o problema persista, entre em contato com o suporte.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
