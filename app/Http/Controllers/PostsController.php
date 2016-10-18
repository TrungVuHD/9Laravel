<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use App\Comment;
use App\Post;
use App\Point;

class PostsController extends Controller
{

    public function index(Request $request)
    {

        $posts = $this->retrieveHotAjax(0, 20)['posts'];
        return view('9gag.index', ['posts_category' =>'hot', 'posts' => $posts]);
    }    

    public function trendingIndex(Request $request)
    {

        $posts = $this->retrieveTrendingAjax(0, 20)['posts'];
        return view('9gag.index', ['posts_category' =>'trending', 'posts' => $posts]);
    }

    public function freshIndex(Request $request)
    {

    	$posts = this.retrieveFreshAjax(0, 20)['posts'];
        return view('9gag.index', ['posts_category' =>'fresh', 'posts' => $posts]);
    }

    public function show($slug)
    {
    	$post = Post::where('slug', $slug)->firstOrFail();
        $next_post = Post::where('id', '>', $post->id)->first();
        $points = count($post->points) > 0 ? count($post->points) : 0;
        $comments = Comment::where('post_id', $post->id)->get();
        $no_comments = $comments->count();
        $thumb_up = null;
        
        if(Auth::check())
        {
            $thumb_up = Point::where('post_id', $post->id)
                ->where('user_id', Auth::user()->id)
                ->first();
        }

    	return view('9gag.show', compact('post', 'points', 'thumb_up', 'comments', 'no_comments', 'next_post'));
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

            $post = new Post();

            $post->title = $request->description;
            $post->image = $image_file;
            $post->slug = str_slug($request->description).'-'.str_random(10);
            $post->attribution = $request->attribution;
            $post->nsfw = isset($request->nsfw) && $request->nsfw == 'on' ? 1 : 0;
            $post->cat_id = $request->category;
            $post->user_id = Auth::user()->id;

            $post->save();

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
        $img->resizeCanvas(300, 160, 'center');
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

    protected function base64ToImage($base64_string, $output_file) 
    {

        $file = fopen($output_file, "wb");
        $data = explode(',', $base64_string);
        fwrite($file, base64_decode($data[1]));
        fclose($file);
     
        return $output_file;
    }

    public function search(Request $request)
    {

        $this->validate($request, [
            'keyword' => 'required'
        ]);

        $keyword = strtolower($request->keyword);

        $results = Post::where('title', 'like', $keyword.'%')
            ->take(10)
            ->get();

        return $results;
    }

    public function searchIndex(Request $request)
    {
        
        $query = $request->query();
        $query = $query['query'];

        $posts = Post::where('title', 'like', "%$query%")->paginate(20);
        $total_results = Post::where('title', 'like', "%$query%")->count();

        return view('9gag.search', compact('posts', 'total_results', 'query'));
    }

    public function retrieveCategoryAjax($category, $start)
    {
        $data = ['success' => true];
        $start = (int)$start;
        $category = (int)$category;
        
        try {

            $data['posts'] = Post::where('cat_id', $category)
                ->offset($start)
                ->limit(20)
                ->get();

        } catch (Exception $e) {
            $data['success'] = false;
        }

        return $data;
    }

    public function retrieveFreshAjax($offset, $limit)
    {
        $offset = (int) $offset;
        $limit = (int) $limit;
        $data = ['success' => true];

        try {
            $data['posts'] = Post::orderBy('id', 'DESC')
                ->offset($offset)
                ->limit($limit)
                ->get();

        } catch (Exception $e) {
            
            $data['success']=false;
        }

        return $data;
    }

    protected function retrieveTrendingAjax($offset, $limit)
    {

        $offset = (int) $offset;
        $limit = (int) $limit;
        $data = [ 'success' => true ];

        try {
            // get the first part of posts ids
            $post_ids = Point::orderBy('post_id', 'desc')
                ->groupBy('post_id')
                ->having('no_points', '>', 300)
                ->having('no_points', '<', 1000)
                ->select(DB::raw('count(post_id) as no_points, points.*'))
                ->offset($offset)
                ->limit($limit)
                ->pluck('post_id');

            // get the posts
            $posts = Post::orderBy('id', 'desc')
                ->whereIn('id', $post_ids)
                ->get();

            $limit -= $posts->count(); 

            $more_posts = Post::orderBy('id', 'desc')
                ->whereNotIn('id', $post_ids)
                ->offset($offset)
                ->limit($limit)
                ->get();

            $posts = $posts->merge($more_posts);

            foreach ($posts as &$post) {
                
                if($post->points->where('post_id', $post->id)->where('user_id', Auth::user()->id )->count()) {
                    $post->active_thumbs_up = true;
                }

                $post->no_comments = $post->comments->count();
                $post->no_points = $post->points->count();
                $post->auth = Auth::check();
                $post->no_auth = !$post->auth;
                
            }

            $data['posts'] = $posts;
        
        } catch (Exception $e) {
            
            $data['success'] = false;
        }

        return $data;
    }

    protected function retrieveHotAjax($offset, $limit)
    {

        $offset = (int) $offset;
        $limit = (int) $limit;
        $data = [ 'success' => true ];

        try {
            // get the first part of posts ids
            $post_ids = Point::orderBy('post_id', 'desc')
                ->groupBy('post_id')
                ->having('no_points', '>=', 1000)
                ->select(DB::raw('count(post_id) as no_points, points.*'))
                ->offset($offset)
                ->limit($limit)
                ->pluck('post_id');

            // get the posts
            $posts = Post::orderBy('id', 'desc')
                ->whereIn('id', $post_ids)
                ->get();

            $limit -= $posts->count(); 

            $more_posts = Post::orderBy('id', 'desc')
                ->whereNotIn('id', $post_ids)
                ->offset($offset)
                ->limit($limit)
                ->get();

            $posts = $posts->merge($more_posts);

            foreach ($posts as &$post) {
                
                $post->active_thumbs_up = false;
                if(Auth::check()) {
                    if($post->points->where('post_id', $post->id)->where('user_id', Auth::user()->id )->count()) {
                        $post->active_thumbs_up = true;
                    }
                }

                $post->no_comments = $post->comments->count();
                $post->no_points = $post->points->count();
                $post->auth = Auth::check();
                $post->no_auth = !$post->auth;
                
            }

            $data['posts'] = $posts;
        
        } catch (Exception $e) {
            
            $data['success'] = false;
        }

        return $data;
    }
}
