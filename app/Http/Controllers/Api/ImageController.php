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
        $variations = [];

        $dbResponse = $this->image->all()
            ->groupBy('album_id')
            ->toArray();

        dd(
            self::permutations([
                '1' => [1, 2, 3, 8],
                '2' => [4, 5, 7],
                '3' => [6, 7],
                '4' => [9]
            ])
        );
        return response()->json();
    }

    public static function permutations(array $array)
    {
        switch (count($array)) {
            case 1:
                // Return the array as-is; returning the first item
                // of the array was confusing and unnecessary
                return $array;
                break;
            case 0:
                throw new \InvalidArgumentException('Requires at least one array');
                break;
        }

        // We 'll need these, as array_shift destroys them
        $keys = array_keys($array);

        $a = array_shift($array);
        $k = array_shift($keys); // Get the key that $a had
        $b = self::permutations($array);

        $return = array();
        foreach ($a as $v) {
            if (is_numeric($v)) {
                foreach ($b as $v2) {
                    // array($k => $v) re-associates $v (each item in $a)
                    // with the key that $a originally had
                    // array_combine re-associates each item in $v2 with
                    // the corresponding key it had in the original array
                    // Also, using operator+ instead of array_merge
                    // allows us to not lose the keys once more
                    if (count($keys) != count($v2)) {
                        dd(
                            $array, // [ [9,10] ]
                            $a, // [6,7]
                            $v, // 6
                            $b, // [ [9,10] ]
                            $v2, // [9,10]
                            array($k => $v), // [ 0 => 6 ]
                            $keys // [1]
                        );
                        $return[] = array($k => $v) + array_combine($keys, $v2);
                    }
                    dd(
                        $array, // [ [9] ]
                        $a, // [6,7]
                        $v, // 6
                        $b, // [ [9] ]
                        $v2, // [9]
                        array($k => $v), // [ 0 => 6 ]
                        $keys, // [1],
                        array_combine($keys, $v2)
                    );
                    $return[] = array($k => $v) + array_combine($keys, $v2);
                }
            }
        }

        return $return;
    }

}
