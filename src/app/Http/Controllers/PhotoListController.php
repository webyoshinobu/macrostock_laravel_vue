<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhotoList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class PhotoListController extends Controller
{
    public function getPhotoList(Request $request) {

        $data = $request->all();
        // Log::debug(print_r($data, true));
        $photo_list_model = new PhotoList;
        $photo_list = $photo_list_model->photoList($request);
        // Log::debug(print_r($photo_list, true));
        foreach($photo_list as $photo) {
            // Log::debug(print_r($photo->filename, true));
            $url = Storage::disk('s3')->url($photo->filename);
            // Log::debug(print_r($url, true));
            $photo->img_url = $url;
            // Log::debug(print_r($photo, true));
        }
        Log::debug(print_r($photo_list, true));
        return $photo_list;
    }
}
