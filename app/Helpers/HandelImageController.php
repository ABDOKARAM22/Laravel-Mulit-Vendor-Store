<?php
namespace app\Helpers\HandelImageController;
use Illuminate\Support\Facades\Storage;

class HandelImageController {

    public static function show_image($imagePath){

        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        if (Storage::disk('uploads')->exists($imagePath)) {
            return asset('uploads/' . $imagePath);
        }

        return asset('img/product-3.jpg');  
    
}
}