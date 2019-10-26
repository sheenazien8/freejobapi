<?php

namespace App\Http\Controllers;

use App\Libraries\Auth;
use App\Models\Company;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::user($request)->load('userable');
        if (!$auth->userable_id) {
            return response()->json([
                'message' => 'You must complete the profile as a company or freelancer',
                'success' => false
            ], 422);
        }else {
            if ($auth->userable instanceof Company) {
                $posts = Post::where('company_id', $auth->userable->id)->paginate();
            }else {
                $posts = Post::paginate();
            }
        }

        return response()->json([
            'message' => 'OK',
            'data' => $posts,
            'success' => true
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_range_salary' => 'required',
            'experience' => 'required',
            'due_date_applied' => 'required',
        ]);
        $auth = Auth::user($request);
        $post = new Post();
        $post->fill($request->all());
        $post->company()->associate($auth->userable->id);
        $post->save();

        return response()->json([
            'message' => 'Success Create Post',
            'data' => $post,
            'success' => true
        ]);
    }

    public function update(Request $request, $post)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'start_range_salary' => 'required',
            'experience' => 'required',
            'due_date_applied' => 'required',
        ]);
        $auth = Auth::user($request);
        $post = Post::find($post);
        $post->fill($request->all());
        $post->company()->associate($auth->userable->id);
        $post->save();

        return response()->json([
            'message' => 'Success Update Post',
            'data' => $post,
            'success' => true
        ]);
    }

    public function delete($post)
    {
        $post = Post::find($post)->delete();

        return response()->json([
            'message' => 'Success Deleted Post',
            'success' => true
        ]);
    }

    public function all(Request $request)
    {
        $auth = Auth::user($request)->load('userable');
        if (!$auth->userable_id) {
            return response()->json([
                'message' => 'You must complete the profile as a company or freelancer',
                'success' => false
            ], 422);
        }else {
            if ($auth->userable instanceof Company) {
                $posts = Post::where('company_id', $auth->userable->id)->paginate();
            }else {
                $posts = Post::paginate();
            }
        }

        return response()->json([
            'message' => 'OK',
            'data' => $posts,
            'success' => true
        ]);
    }
}
