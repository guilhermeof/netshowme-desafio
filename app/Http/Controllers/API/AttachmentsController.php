<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\AttachmentRepository;

class AttachmentsController extends Controller
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
     * Return path file
     *
     * @param $id
     * @return string|null
     */
    public function show($id)
    {
        return $this->attachmentRepository->downloadAttachment($id);
    }
}
