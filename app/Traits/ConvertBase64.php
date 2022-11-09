<?php

namespace App\Traits;

trait ConvertBase64
{
    public function image($imageName) {
        return base64_encode(file_get_contents(public_path($imageName)));
    }
}
