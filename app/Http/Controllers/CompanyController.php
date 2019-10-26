<?php

namespace App\Http\Controllers;

use App\Libraries\Auth;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
            'name' => 'required',
            'company_size' => 'required',
            'description' => 'required',
            'languages' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $auth = Auth::user($request);
        $company = new Company();
        $company->fill($request->all());
        $company->save();
        $auth->userable()->associate($company);
        $auth->save();

        return response()->json([
            'message' => 'Success create Company',
            'data' => $company,
            'success' => true
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'company_size' => 'required',
            'description' => 'required',
            'languages' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $auth = Auth::user($request);
        $company = $auth->userable;
        $company->fill($request->all());
        $company->save();

        return response()->json([
            'message' => 'Success update Company',
            'data' => $company,
            'success' => true
        ]);
    }
}
