<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;

class PostsController extends Controller
{

    public function index(Request $request)
    {
    	
    	return view('9gag.index');
    }    

    public function show(Request $request)
    {
    	
    	return view('9gag.show');
    }

    public function trendingIndex(Request $request)
    {

    	return view('9gag.index');
    }

    public function freshIndex(Request $request)
    {

        return view('9gag.index');
    }

    public function myProfileIndex() {
        
        $user = Auth::user();

    	return view('9gag.my-profile', ['user' => $user]);
    }

    public function store(Request $request)
    {
        define('DS', DIRECTORY_SEPARATOR);

        $this->validate($request, [
            'description' => 'required|max:160',
            'category' => 'required|integer',
            'image' => 'required'
        ]);

        try {
            
            $image_extension = $this->getImageExtension($request->image);
            $image_dir = base_path().DS.'public'.DS.'img'.DS.'posts'.DS;
            $image_file = str_random(20).$image_extension;
            $image_location = $image_dir.$image_file;

            $this->base64ToImage($request->image, $image_location);

            if($image_extension != "image/gif") {
                $this->createImageVersions($image_dir, $image_file);
            }
            
        } catch (Exception $e) {
            
            echo json_encode(['success' => false]);
            die();
        }

        echo json_encode(['success' => true]);
        die();
    }

    protected function createImageVersions($dir, $file) 
    {
        // big image
        $img = Image::make($dir.$file);
        $img->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($dir.$file, 70);        

        // medium image
        $img->resize(460, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($dir.DS.'460'.DS.$file, 70);

        // small image
        $img->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($dir.DS.'300'.DS.$file, 70);
    }

    protected function getImageExtension($base64_string)
    {
        $data = explode(',', $base64_string);
        $imgdata = base64_decode($data[1]);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);

        switch($mime_type) {

            case 'image/gif':
                $extension = '.gif';
            break;
            case 'image/jpeg':
                $extension = '.jpeg';
            break;
            case 'image/png':
                $extension = '.png';
            break;
            default:
                $extension = '.jpeg';
        }
        return $extension;
    }

    protected function base64ToImage($base64_string, $output_file) {

        $file = fopen($output_file, "wb");
        $data = explode(',', $base64_string);
        fwrite($file, base64_decode($data[1]));
        fclose($file);
     
        return $output_file;
    }
}
