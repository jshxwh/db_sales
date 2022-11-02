<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
    }

    public function titleChart() {
        $customer = DB::table('customers')->groupBy('title')->orderBy('total')->pluck(DB::raw('count(title) as total'),'title')->all();
        $labels = (array_keys($customer));
        
        $data= array_values($customer);
        // dd($customer, $data, $labels);
        return response()->json(array('data' => $data, 'labels' => $labels));
    }

    public function salesChart() {
        
        $sales = DB::table('item as i')
                    ->join('orderline as ol', 'i.item_id', '=', 'ol.item_id')
                    ->join('orderinfo as oi', 'ol.orderinfo_id', '=', 'oi.orderinfo_id')
                    ->select(DB::raw('monthname(oi.date_placed) as month, sum(ol.quantity * i.sell_price) as total'))
                    ->groupBy('oi.date_placed')
                    ->pluck('total','month')
                    ->all();
                    
        // dd($sales);
        $labels = (array_keys($sales));
        
        $data= array_values($sales);
        // dd($sales, $data, $labels);
        return response()->json(array('data' => $data, 'labels' => $labels));
    }

    public function itemsChart() {
        
        $items = DB::table('item as i')
                    ->join('orderline as ol', 'i.item_id', '=', 'ol.item_id')
                    ->select(DB::raw('i.description as items, sum(ol.quantity) as total'))
                    ->groupBy('i.description')
                    ->pluck('total','items')
                    ->all();
                    
        // dd($items);
        $labels = (array_keys($items));
        
        $data= array_values($items);
        // dd($sales, $data, $labels);
        return response()->json(array('data' => $data, 'labels' => $labels));
    }
}
