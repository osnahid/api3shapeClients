<?php

namespace App\Http\Controllers\API;

use App\Employe;
use App\Customer;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;


class EmployeController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($customer_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email',
            'type' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $employe = new Employe();
        $employe->name = $request['name'];
        $employe->email = $request['email'];
        $employe->type = $request['type'];
        $employe->phone = $request['phone'];
        $employe->customer_id = $customer_id;

        if ($employe->save() && Customer::find($customer_id)) {
            $res['employe'] = $employe;
            $res['status'] = 'employe added succefully';
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
        $employe = Employe::find($id);

        if ($employe) {
            return response()->json($employe, 200);
        } else {
            return response()->json(['error'=>'employe not found'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customer_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $employe = Employe::find($id);
        if ($employe) {
            $employe->name = $request['name'];
            $employe->email = $request['email'];
            $employe->type = $request['type'];
            $employe->phone = $request['phone'];
            $employe->customer_id = $customer_id;

            if ($employe->save()) {
                $res['employe'] = $employe;
                $res['status'] = 'employe updated succefully';
                return response()->json($res, 200);
            } else {
                return response()->json(['error'=>'something happend'], 401);
            }
        } else {
            return response()->json(['error'=>'employe not found'], 401);
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
        if (Employe::destroy($id)) {
            $res['status'] = 'the employe was deleted';
            return response()->json($res, 200);
        } else {
            return response()->json(['error'=>'employe not found'], 401);
        }
    }
}
