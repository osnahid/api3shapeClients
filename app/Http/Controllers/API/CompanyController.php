<?php

namespace App\Http\Controllers\API;

use App\Company;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::All();
        return response()->json($companies, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required',
            'support_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        $company = new Company();
        $company->name = $request->name;
        $company->location = $request->location;
        $company->phone = $request->phone;
        $company->support_email = $request->support_email;

        if ($request->hasFile('logo')) {
            $file      = $request->file('logo');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $path = $file->move(public_path('uploads/companiesLogos'), $picture);
            $company->logo = str_replace(public_path(), '', $path);
        }

        if ($company->save()) {
            $res['company'] = $company;
            $res['status'] = 'company added succefully';
            return response()->json($res, 200);
        } else {
            return response()->json(['error'=>'something happend'], 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        if ($company) {
            return response()->json($company, 200);
        } else {
            return response()->json(['error'=>'company not found'], 401);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required',
            'support_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $company = Company::find($id);
        $company->name = $request->name;
        $company->location = $request->location;
        $company->phone = $request->phone;
        $company->support_email = $request->support_email;
        if ($request->hasFile('logo')) {
            $file      = $request->file('logo');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $path = $file->move(public_path('uploads/companiesLogos'), $picture);
            $company->logo = str_replace(public_path(), '', $path);
        }

        if ($company->save()) {
            $res['company'] = $company;
            $res['status'] = 'company added succefully';
            return response()->json($res, 200);
        } else {
            return response()->json(['error'=>'something happend'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(Company::find($id)) {
            if (Company::destroy($id)) {
                $res['status'] = 'the company was deleted';
                return response()->json($res, 200);
            } else {
                return response()->json(['error'=>'company not found'], 401);
            }
        }  else {
            return response()->json(['error'=>'company not found'], 401);
        }
    }
}
