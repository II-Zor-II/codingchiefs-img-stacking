<?php


namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * @var Image $image
     */
    private $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    function uploadImage(Request $request)
    {
        $path = Storage::putFile('img', $request->file('img'));

        $this->image->img_path = $path;

        $this->image->album_id = $request->album;

        $dbResponse = $this->image->save();

        return response()->json([
            'img_path' => $this->image->img_path,
            'album' => $this->image->album_id,
            'dbResponse' => $dbResponse
        ]);

    }

    function getAll()
    {
        $dbResponse = $this->image->all()
            ->groupBy('album_id')
            ->toArray();

        return response()->json(
            $dbResponse
        );

    }
}
