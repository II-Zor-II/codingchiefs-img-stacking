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

    function getAllVariations()
    {
        $dbResponse = $this->image->all()
            ->groupBy('album_id')
            ->toArray();

        return response()->json(
            self::permutations($dbResponse)
        );
    }

    public static function permutations(array $array)
    {
        switch (count($array)) {
            case 1:
                return $array[0];
                break;
            case 0:
                throw new \InvalidArgumentException('Requires at least one array');
                break;
        }

        $a = array_shift($array);
        $b = self::permutations($array);

        $return = array();
        foreach ($a as $key => $v) {
            foreach ($b as $key2 => $v2) {
                $return[] = array_merge(array($v), (array)$v2);
            }
        }

        return $return;
    }

}
