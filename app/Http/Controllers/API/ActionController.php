<?php

namespace App\Http\Controllers\API;

use App\Action;
use App\Software;
use App\Materiel;
use App\Account;
use App\Customer;
use App\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actions = Action::all();
        foreach($actions as $action) {
            if (Materiel::find($action->materiel_id)) {
                $action->materiel = Materiel::find($action->materiel_id);
            }
            if (Account::find($action->account_id)) {
                $action->account = Account::find($action->account_id);
            }
            if (Customer::find($action->customer_id)) {
                $action->customer = Customer::find($action->customer_id);
            }
            if (Subscription::find($action->subscription_id)) {
                $action->subscription = Subscription::find($action->subscription_id);
            }
            if (Software::find($action->software_id)) {
                $action->software = Software::find($action->software_id);
            }
        }
        return response()->json($actions, 200);
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
            'type' => 'required',
            'customer_id' => 'required',
            'account_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        $action = new Action();
        $action->type = $request['type'];
        $action->note = $request['note'];
        $action->account_id = $request['account_id'];
        $action->customer_id = $request['customer_id'];
        $action->materiel_id = $request['materiel_id'];
        $action->software_id = $request['software_id'];
        if ( Software::find($request['software_id']) ){
           if (Software::find($request['software_id'])->hasSubscription) {
               if ($request->has(['name', 'dongle'])) {
                $subscription = new App\Subscription();
                $subscription->type = $request['type_subscription'];
                $subscription->name = $request['name'];
                $subscription->dongle = $request['dongle'];
                $subscription['strat-date'] = $request['strat-date'];
                $subscription['end-date'] = $request['end-date'];
                if ($subscription->save()) {
                    $action->subscription_id = $subscription->id;
                } else {
                    return response()->json(['error' => 'can not create the subscription'], 401);
                }
               } else {
                    return response()->json(['error' => 'can not create the subscription, dongle and subscription type are required'], 401);
               }
           }

        }

        if ($action->save()) {
            $res['action'] = $action;
            $res['status'] = 'action added succefully';
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
        $action = Action::find($id)->with(['account']);


        return response()->json($action, 200);
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
            'type' => 'required',
            'customer_id' => 'required',
            'account_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        }

        $action = Action::find($id);
        if (Action::find($id)) {
            $action->type = $request['type'];
            $action->note = $request['note'];
            $action->account_id = $request['account_id'];
            $action->customer_id = $request['customer_id'];
            $action->materiel_id = $request['materiel_id'];
            $action->software_id = $request['software_id'];
        } else {
            return response()->json(['error'=>'something happend'], 401);
        }



        if ($action->save()) {
            $res['action'] = $action;
            $res['status'] = 'action added succefully';
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
        $action = Action::find($id);
        if ($action->destroy()) {
            App\Subscripton::find($action->subscription_id)->destroy();
            return response()->json($res, 200);
        } else {
            return response()->json(['error'=>'action not found'], 401);
        }
    }
}
