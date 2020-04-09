<?php

namespace App\Http\Controllers\API;

use App\Materiel;
use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class MaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Materiel::All(), 200);
    }

    public function indexByCompany($company_id) {
        return response()->json(Materiel::All()->where('company_id', $company_id), 200);
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
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $materiel = new Materiel();
        $materiel->name = $request['name'];
        $materiel->image = $request['image'];
        $materiel->type = $request['type'];
        $materiel->hasSoftware = $request['hasSoftware'];
        $materiel->characteristics = $request['characteristics'];
        $materiel->company_id = $company_id;
        $company = Company::find($company_id);
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $path = $file->move(public_path('uploads/materialPictures'), $picture);
            $materiel->image = str_replace(public_path(), '', $path);
        }
        if ($materiel->save() && $company) {
            $res['materiel'] = $materiel;
            $res['status'] = 'materiel added succefully';
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
        $materiel = Materiel::find($id);

        if ($materiel) {
            return response()->json($materiel, 200);
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
        $materiel = Materiel::find($id);
        $materiel->name = $request['name'];
        $materiel->image = $request['image'];
        $materiel->type = $request['type'];
        $materiel->hasSoftware = $request['hasSoftware'];
        $materiel->characteristics = $request['characteristics'];
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $path = $file->move(public_path('uploads/materialsPictures'), $picture);
            $materiel->image = str_replace(public_path(), '', $path);
        }
        if ($materiel->save()) {
            $res['materiel'] = $materiel;
            $res['status'] = 'materiel updated successfully';
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
        if (Materiel::destroy($id)) {
            $res['status'] = 'the materiel was deleted';
            return response()->json($res, 200);
        } else {
            return response()->json(['error'=>'materiel not found'], 401);
        }
    }
}
