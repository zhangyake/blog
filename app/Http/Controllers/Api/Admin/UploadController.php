<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Tools\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadController  extends ApiController
{
    protected  $manager;

    public function __construct()
    {
        $this->manager = new FileManager();
    }
    /**
     * Response the folder info.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->manager->folderInfo($request->get('folder'));

        return response()->json(['data' => $data]);
    }

    /**
     * Upload the file for file manager.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadForManager(Request $request)
    {
        $file = $request->file('file');

        $fileName = $request->get('name')
            ? $request->get('name').'.'.explode('/', $file->getClientMimeType())[1]
            : $file->getClientOriginalName();

        $path = Str::finish($request->get('folder'), '/');

        if ($this->manager->checkFile($path.$fileName)) {
            return  response()->json('This File exists.',400);
        }

        $result = $this->manager->store($file, $path, $fileName);

        return response()->json($result);
    }

    /**
     * Generic file upload method.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileUpload(Request $request)
    {
        $this->reqValidate($request,[ 'image' => 'image|mimes:jpeg,jpg,png,gif']);
        $strategy = $request->get('strategy', 'images');

        if (!$request->hasFile('image')) {
            return response()->json('no file found.',400);
        }

        $path = $strategy.'/'.date('Y').'/'.date('m').'/'.date('d');

        $result = $this->manager->store($request->file('image'), $path);

        return response()->json($result);
    }

    /**
     * Create the folder.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createFolder(Request $request)
    {
        $folder = $request->get('folder');

        $data = $this->manager->createFolder($folder);

        return response()->json(['data' => $data]);
    }

    /**
     * Delete the folder.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');

        $folder = $request->get('folder').'/'.$del_folder;

        $data = $this->manager->deleteFolder($folder);

        if (!$data) {
            return response()->json('The directory must be empty to delete it.',403);
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Delete the file.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile(Request $request)
    {
        $path = $request->get('path');

        $data = $this->manager->deleteFile($path);

        return response()->json(['data' => $data]);
    }
}