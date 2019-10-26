<?php

namespace App\Http\Controllers;

use App\Libraries\Auth;
use App\Models\Apply;
use App\Models\Company;
use App\Models\Freelancer;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplyController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::user($request)->load('userable');
        if ($auth->userable instanceof Freelancer) {
            $apply = Apply::where('freelancer_id', $auth->userable->id)->paginate();
        }else {

            $apply = Apply::whereHas('post', function ($query) use ($auth)
            {
                return $query->where('company_id', $auth->userable->id);
            })->paginate();
        }

        return response()->json([
            'message' => 'OK',
            'success' => true,
            'data' => $apply
        ]);
    }
    public function create(Request $request, $post)
    {
        $this->validate($request, [
            'CV' => 'required'
        ]);
        $file = $request->file('CV');
        $filename = $this->uploadCV($file);
        $auth = Auth::user($request);
        $post = Post::findOrFail($post);
        if (!$post->published) {
            return response()->json([
                'message' => 'Can`t Apply this job',
                'success' => false
            ]);
        }
        $apply = new Apply();
        $apply->why = $request->why;
        $apply->cv = $filename;
        $apply->freelancer()->associate($auth->userable->id);
        $apply->post()->associate($post);
        $apply->save();

        return response()->json([
            'message' => 'Success applied Job',
            'data' => $apply,
            'success' => true
        ]);
    }

    private function uploadCV($file, $pathname = null)
    {
        if ($pathname) {
            Storage::disk('s3')->delete();
        }
        $carbon = new Carbon();
        $filename = $carbon->now()->format('CVYmdhis').'.'.$file->getClientOriginalExtension();
        Storage::disk('local')->putFileAs(
            'cv/',
            $file,
            $filename
        );

        return $filename;
    }

    public function update(Request $request, $post, $apply)
    {
        //fixme, request is not readable
        $post = Post::findOrFail($post);
        $apply = Apply::findOrFail($apply);
        $auth = Auth::user($request);
        $file = $request->file('CV', 'cv'.$apply->cv);
        if (!$post->published) {
            return response()->json([
                'message' => 'Can`t Apply this job',
                'success' => false
            ]);
        }
        $filename = $this->uploadCV($file);
        $apply->why = $request->why;
        $apply->cv = $filename;
        $apply->freelancer()->associate($auth->userable->id);
        $apply->post()->associate($post);
        $apply->save();

        return response()->json([
            'message' => 'Success update applied Job',
            'data' => $apply,
            'success' => true
        ]);
    }

    public function delete($apply)
    {
        $apply = Post::findOrFail($apply)->delete();

        return response()->json([
            'message' => 'Success Deleted Apply',
            'success' => true
        ]);
    }
}
