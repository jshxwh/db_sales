<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use View;
use File;

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
        $item = $item->update($request->all());

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
}
