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


        $image_extension = $this->getImageExtension($request->image);
        $image_title = base_path().DS.'public'.DS.'img'.DS.'posts'.DS.str_random(20).$image_extension;

        $this->base64ToImage($request->image, $image_title);

        echo json_encode(['success' => true]);
        die();
    }

    public function getImageExtension($base64_string)
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

    public function base64ToImage($base64_string, $output_file) {

        $file = fopen($output_file, "wb");
        $data = explode(',', $base64_string);
        fwrite($file, base64_decode($data[1]));
        fclose($file);
     
        return $output_file;
    }
}
