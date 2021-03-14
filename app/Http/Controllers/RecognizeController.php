<?php

namespace App\Http\Controllers;

use App\Models\File;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class RecognizeController extends Controller
{
    public function recognize(Request $request)
    {
        $validate = $request->validate([
            'image' => 'mimes:png,jpg|max:2014'
        ]);

        $imageAnnotator = new ImageAnnotatorClient(
            ['credentials' => json_decode(file_get_contents(app_path('auth.json')), true)]
        );

        if (!$request->hasFile('image')) {
            return response(['message' => 'Error on load image!'], 400);
        }

        try {
            $uuid = Uuid::uuid();

            $extension = $request->image->extension();
            $imageName = $uuid.'.'.$extension;

            $request->image->storeAs('', $imageName);

            $parsedUrl = parse_url(Storage::url($imageName));

            $validate['image_path'] = $parsedUrl['path'];

            $file = new File($validate);

            $file->save();

            $image = Storage::get($imageName);

            $response = $imageAnnotator->textDetection($image);
            $texts    = $response->getTextAnnotations();

            $imageAnnotator->close();

            return response(['result' => $texts[0]->getDescription()], 200);

        } catch (\Exception $e) {
            return response(['message' => 'Error on Recognize image!'], 400);
        }
    }
}
