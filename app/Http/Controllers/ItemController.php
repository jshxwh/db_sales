<?php

namespace App\Http\Controllers;

use File;
use View;
use App\Models\Item;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if ($request->ajax()){
            $items = Item::orderBy('item_id')->get();
            return response()->json($items);
        // }
    }

    // public function getItem (){
    //     return view('Item.index');
    // }
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
        $item = new Item;
        $item->description = $request->description;
        $item->sell_price = $request->sell_price;
        $item->cost_price = $request->cost_price;
        $item->title = $request->title;

        // $fileName = time().$request->file('imagePath')->getClientOriginalName();
        // $path = $request->file('imagePath')->storeAs('images', $fileName, 'public');
        // $requestData["imagePath"] = '/storage/'.$path;
        // $item->imagePath = $requestData["imagePath"];

        $files = $request->file('uploads');

        $item->imagePath = 'images/'.time().'-'.$files->getClientOriginalName();
        $item->save();

        $data = array('status' => 'saved');
        Storage::put('images/'.time().'-'.$files->getClientOriginalName(), file_get_contents($files));

        return response()->json(["success" => "Item Created Successfully.", "item" => $item, "status" => 200]);

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
        $item = Item::Find($id);
        return response()->json($item);
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
        $item = Item::find($id);

        // $item = Item::find($request->item_id);
        // dd($request->imagePath);
		// if ($request->hasFile('imagePath')) {
		// 	$file = $request->file('imagePath');
		// 	$fileName = time().'-'.$file->getClientOriginalName();
		// 	$file->storeAs('images/', $fileName);
		// 	if ($item->avatar) {
		// 		File::delete("storage/".$item->imagePath);
		// 	}
		// } else {
		// 	$fileName = $request->itemimage;
		// }

        $item = $item->update($request->all());

        // $itemdata = ['description' => $request->description, 'cost_price' => $request->cost_price, 'sell_price' => $request->sell_price, 'title' => $request->title, 'imagePath' => $fileName];

		// $item->update($itemdata);

        $item = Item::find($id);

         return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $item = Item::findOrFail($id);

        if (File::exists("storage/".$item->imagePath)) {
            File::delete("storage/".$item->imagePath);
        }

        $item->delete();

        $data = array('success' =>'deleted','code'=>'200');
        return response()->json($data);
    }

    public function postCheckout(Request $request){
        $items = json_decode($request->getContent(),true);
        Log::info(print_r($items, true));
          try {
            DB::beginTransaction();
            $order = new Order();
            $customer =  Customer::find(1);
              
            $customer->orders()->save($order);
            
            foreach($items as $item) {
               $id = $item['item_id'];
               $order->items()->attach($order->orderinfo_id,['quantity'=> $item['quantity'],'item_id'=>$id]);
               $stock = Stock::find($id);
               $stock->quantity = $stock->quantity - $item['quantity'];
               $stock->save();
            }
            
          }
        catch (\Exception $e) {
              DB::rollback();
              return response()->json(array('status' => 'Order failed','code'=>409,'error'=>$e->getMessage()));
        }
      
          DB::commit();
          return response()->json(array('status' => 'Order Success','code'=>200,'order id'=>$order->orderinfo_id));
      
        
    }

}
