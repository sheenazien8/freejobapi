<?php

namespace App\Http\Controllers;

use App\Libraries\Auth;
use App\Models\Freelancer;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    public function index(Request $request)
    {
        $auth = Auth::user($request)->load('userable');

        return response()->json([
            'message' => 'OK',
            'data' => $auth,
            'success' => true
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'bio' => 'required',
            'expected_salary' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'nationality' => 'required',
            'languages' => 'required',
            'skills' => 'required',
        ]);

        $auth = Auth::user($request);
        $freelancer = new Freelancer();
        $freelancer->fill($request->all());
        $freelancer->save();
        $auth->userable()->associate($freelancer);
        $auth->save();

        return response()->json([
            'message' => 'Success create Freelancer',
            'data' => $freelancer,
            'success' => true
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'bio' => 'required',
            'expected_salary' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'nationality' => 'required',
            'languages' => 'required',
            'skills' => 'required',
        ]);

        $auth = Auth::user($request);
        $freelancer = $auth->userable;
        $freelancer->fill($request->all());
        $freelancer->save();

        return response()->json([
            'message' => 'Success update Freelancer',
            'data' => $freelancer,
            'success' => true
        ]);
    }
}
