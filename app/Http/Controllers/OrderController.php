<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.   
     */
    public function index()
    {
        return view('order.kasir.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view("order.kasir.create",compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name_costumer'=>'required|max:50',
        'medicines'=>'required',
        ]);

        $arrayDistinct = array_count_values($request->medicines);
        $arrayMedicines = [];

        foreach($arrayDistinct as $id => $count)
        {
            $medicines = Medicine::where('id',$id)->first();

            $subPrice = $medicines['price'] * $count;

            $arrayItem = [
                "id" => $id,
                'name_medicine' => $medicines['name'],
                'qty' => $count,
                'sub_price' => $subPrice,
            ];
            array_push($arrayMedicines,$arrayItem);
        }

        $totalPrice = 0;
        foreach($arrayMedicines as $item)
        {
            $totalPrice += (int)$item['sub_price'];
        }

        $pricePpn = $totalPrice + ($totalPrice * 0.01);

        $proses = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayMedicines,
            'name_costumer' => $request->name_customer,
            'total_price' => $pricePpn
        ]);

        if($proses)
        {
            $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}