<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilePost;
use App\Mail\FileUploaded;
use App\Models\UserFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class FileUpload extends Controller
{
    public function store(StoreFilePost $request)
    {

        /**
         * @var $file UploadedFile
         */
        DB::beginTransaction();
        $userFileModel = null;
        try {
            $file = $request->fileContent;
            $fileHash = hash_file('md5', $file);
            $userHash = hash('md5', $request->input('fileSenderEmail'));
            $file->storeAs('uploaded'.'/'.$userHash, $fileHash);
            $userFileModel = new UserFiles();
            $userFileModel->description = $request->input('fileDescription');
            $userFileModel->email = $request->input('fileSenderEmail');
            $userFileModel->file_hash = $fileHash;
            $userFileModel->user_hash = $userHash;
            $userFileModel->filename = $file->getClientOriginalName();
            $userFileModel->save();
            Mail::to($userFileModel->email)->send(new FileUploaded($userFileModel));
        } catch (Exception $exception) {
            DB::rollBack();

            abort(500, 'Internal Server Error');
        }
        DB::commit();

        return ['status' => true];
    }
}
