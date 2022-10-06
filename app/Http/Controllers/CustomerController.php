<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use View;

class CustomerController extends Controller
{
    public function index()
    {
       return View::make('customer.index');
    }
    public function getCustomerAll(Request $request){
        //if ($request->ajax()){
            $customers = Customer::orderBy('lname','DESC')->get();
            return response()->json($customers);
         //}
    }

    public function store(Request $request)
    {
        $customer = Customer::create($request->all());
        return response()->json($customer);
    } 

    public function edit($id) {
        $customer = Customer::Find($id);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        //if ($request->ajax()) {
        $customer = Customer::find($id);
        $customer = $customer->update($request->all());
         return response()->json($customer);
        //}
    } 

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(["success" => "customer deleted successfully.","status" => 200]);
    }

}
