<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Customer::all(), 200);
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
            'email' => 'email',
            'type' => 'required',
            'phone' => 'required',
            'city' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->type = $request->type;
        $customer->phone = $request->phone;
        $customer->location = $request->location;
        $customer->city = $request->city;
        $customer->email = $request->email;

        if ($customer->save()) {
            $res['customer'] = $customer;
            $res['status'] = 'customer added succefully';
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
        $customer = Customer::find($id);
        if ($customer) {
            return response()->json($customer, 200);
        } else {
            return response()->json(['error'=>'customer not found'], 401);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'phone' => 'required',
            'city' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }
        $customer = Customer::find($id);
        if ($customer) {
            $customer->name = $request->name;
            $customer->type = $request->type;
            $customer->phone = $request->phone;
            $customer->location = $request->location;
            $customer->city = $request->city;
            $customer->email = $request->email;

            if ($customer->save()) {
                $res['customer'] = $customer;
                $res['status'] = 'customer updated succefully';
                return response()->json($res, 200);
            } else {
                return response()->json(['error'=>'something happend'], 401);
            }
        } else {
            return response()->json(['error'=>'customer not found'], 401);
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
        if(Customer::find($id)) {
            $array_employees = Customer::find($id)->employees;
            if (Customer::destroy($id)) {
                foreach($array_employees as $emp) {
                    App/Employe::destroy($emp->id);
                }
                $res['status'] = 'the customer was deleted';
                return response()->json($res, 200);
            } else {
                return response()->json(['error'=>'customer not found'], 401);
            }
        }  else {
            return response()->json(['error'=>'customer not found'], 401);
        }

    }
}
