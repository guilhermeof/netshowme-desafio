<?php

namespace App\Repositories;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use League\Flysystem\FileExistsException;

class AttachmentRepository extends BaseRepository
{
    protected $basePath;

    public function __construct(Attachment $attachment)
    {
        parent::__construct($attachment);

        $driver = Storage::disk()->getDriver();
        $prefix = $driver->getAdapter()->getPathPrefix();

        $this->basePath = $prefix . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
    }

    /**
     * Array com o nome dos diretorios baseados no hash passado
     * @param $hash
     * @return array
     */
    private function hashDirectories($hash)
    {
        return array(substr($hash, 0, 2), substr($hash, 2, 2));
    }

    /**
     * Trata uploads guardando o arquivo no servidor e registrando na
     * base de dados
     * @param UploadedFile $uploadedFile
     * @return \Illuminate\Http\RedirectResponse|static
     * @throws FileExistsException
     * @throws \Exception
     */
    public function uploadAttachment(UploadedFile $uploadedFile)
    {
        $hash = sha1_file($uploadedFile);
        list($firstDir, $secondDir) = $this->hashDirectories($hash);

        $filePath = $this->basePath . $firstDir . DIRECTORY_SEPARATOR . $secondDir;

        try {
            $attachment = [
                'name' => $uploadedFile->getClientOriginalName(),
                'mime' => $uploadedFile->getClientMimeType(),
                'extension' => $uploadedFile->getClientOriginalExtension(),
                'location' => $hash
            ];

            if (!file_exists($filePath . DIRECTORY_SEPARATOR . $hash)) {
                $uploadedFile->move($filePath, $hash);
            }
            return $this->create($attachment);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                throw $e;
            }
        }
    }

    /**
     * @param $attachmentId
     * @return null
     */
    public function downloadAttachment($attachmentId)
    {
        $attachment = $this->find($attachmentId);

        if (!$attachment) {
            $attachment = 'error_non_existent';
            return $attachment;
        }

        list($firstDir, $secondDir) = $this->hashDirectories($attachment->location);

        $filePath = $this->basePath . $firstDir . DIRECTORY_SEPARATOR . $secondDir . DIRECTORY_SEPARATOR . $attachment->location;

        $headers = array('Content-Type: ' . $attachment->mime);

        return Response::file($filePath, $headers);
    }

    /**
     * Atualiza o registro de um anexo
     * @param $attachmentId
     * @param UploadedFile $uploadedFile
     * @return \Illuminate\Http\RedirectResponse|string
     * @throws FileExistsException
     * @throws \Exception
     */
    public function updateAttachment($attachmentId, UploadedFile $uploadedFile)
    {
        $attachment = $this->find($attachmentId);

        if (!$attachment) {
            return array(
                'type' => 'error_non_existent',
                'message' => 'Arquivo não existe!'
            );
        }

        $hash = sha1_file($uploadedFile);
        list($firstDir, $secondDir) = $this->hashDirectories($hash);

        $filePath = $this->basePath . $firstDir . DIRECTORY_SEPARATOR . $secondDir;

        if (file_exists($filePath . DIRECTORY_SEPARATOR . $hash)) {
            if (config('app.debug')) {
                throw new FileExistsException($filePath . DIRECTORY_SEPARATOR . $hash);
            }

            return array(
                'type' => 'error_exists',
                'message' => 'Arquivo enviado já existe'
            );
        }

        try {
            list($firstOldDir, $secondOldDir) = $this->hashDirectories($attachment->location);
            array_map('unlink', glob($this->basePath . $firstOldDir . DIRECTORY_SEPARATOR . $secondOldDir . DIRECTORY_SEPARATOR . $attachment->location));

            $data = [
                'name' => $uploadedFile->getClientOriginalName(),
                'mime' => $uploadedFile->getClientMimeType(),
                'extension' => $uploadedFile->getClientOriginalExtension(),
                'location' => $hash
            ];

            $uploadedFile->move($filePath, $hash);
            return $this->update($data, $attachmentId, 'id');
        } catch (\Exception $e) {
            if (config('app.debug')) {
                throw $e;
            }
        }
    }

    /**
     * Deleta um anexo do servidor e seu registro no banco
     * @param $attachmentId
     * @return int|string|array
     * @throws \Exception
     */
    public function deleteAttachment($attachmentId)
    {
        $attachment = $this->find($attachmentId);

        if (!$attachment) {
            return array(
                'type' => 'error_non_existent',
                'message' => 'Arquivo não existe!'
            );
        }

        try {
            list($firstOldDir, $secondOldDir) = $this->hashDirectories($attachment->location);
            array_map('unlink', glob($this->basePath . $firstOldDir . DIRECTORY_SEPARATOR . $secondOldDir . DIRECTORY_SEPARATOR . $attachment->location));
            return $this->delete($attachmentId);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                throw $e;
            }
        }
    }
}
