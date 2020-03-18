<?php

namespace App\Http\Controllers\API;

use App\Software;
use App\Company;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Software::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $company_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'version' => 'required',
            'hasSubscription' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $soft = new Software();
        $soft->name = $request['name'];
        $soft->version = $request['version'];
        $soft->hasSubscription = $request['hasSubscription'];
        $soft->company_id = $company_id;

        if ($soft->save() && Company::find($company_id)) {
            $res['software'] = $soft;
            $res['status'] = 'software added succefully';
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
        $software = Software::find($id);

        if ($software) {
            return response()->json($software, 200);
        } else {
            return response()->json(['error'=>'materiel not found'], 401);
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
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $soft = Software::find($id);
        $soft->name = $request['name'];
        $soft->version = $request['version'];
        $soft->hasSubscription = $request['hasSubscription'];
        $soft->company_id = $company_id;

        if ($soft->save()) {
            $res['software'] = $soft;
            $res['status'] = 'software updated successfully';
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
        if (Software::destroy($id)) {
            $res['status'] = 'the software was deleted';
            return response()->json($res, 200);
        } else {
            return response()->json(['error'=>'software not found'], 401);
        }
    }
}
