<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait ImageUpload {
    function multi_image_upload($images , $image_path , $id ,$model){
        $arr_images = [];
        
        foreach($images as $image){
            $extension = $image->getClientOriginalExtension();
            $file_name = strtolower(Str::random(10));
            $file = $file_name . '.' . $extension;
            $image->move(public_path($image_path),$file);

            $arr_images[] = [
               'image' => $image_path . $file,
               'imageable_type' => $model,
               'imageable_id'=> $id,
            ];
        }
        return $arr_images;
    }
}