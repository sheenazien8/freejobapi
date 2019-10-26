<?php

namespace App\Http\Controllers;

use App\Libraries\Auth;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(Request $request)
    {
        $experiences = Experience::where('freelancer_id', Auth::user($request)->userable->id)->get();

        return response()->json([
            'message' => 'OK',
            'data' => $experiences,
            'success' => true
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'start_work' => 'required',
            'currently_work_here' => 'required',
            'position' => 'required',
            'salary' => 'required'
        ]);

        $auth = Auth::user($request);
        $experience = new Experience();
        $experience->fill($request->all());
        $experience->freelancer()->associate($auth->userable);
        $experience->save();

        return response()->json([
            'message' => 'Success create Experience',
            'data' => $experience,
            'success' => true
        ]);
    }

    public function update(Request $request, $experience)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'start_work' => 'required',
            'currently_work_here' => 'required',
            'position' => 'required',
            'salary' => 'required'
        ]);

        $auth = Auth::user($request);
        $experience = $auth->userable->experiences->find($experience);
        $experience->fill($request->all());
        $experience->freelancer()->associate($auth->userable);
        $experience->save();

        return response()->json([
            'message' => 'Success update Experience',
            'data' => $experience,
            'success' => true
        ]);
    }

    public function delete($experience)
    {
        Experience::findOrFail($experience)->delete();

        return response()->json([
            'message' => 'Success Delete Experience',
            'success' => true
        ]);
    }
}
