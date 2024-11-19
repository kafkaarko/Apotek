<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Node\Query\OrExpr;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.   
     */
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');  // ambil search_date dari request
        $end_date = $request->input('end_date');  // ambil end_date dari request (jika ada)

        $orders = Order::query();

        // Jika start_date diberikan, lakukan filter berdasarkan tanggal
        if ($start_date && !$end_date) {
            $orders = $orders->whereDate('created_at', '>=', Carbon::parse($start_date));
        }

        // Jika end_date diberikan, lakukan filter berdasarkan tanggal
        if (!$start_date && $end_date) {
            $orders = $orders->whereDate('created_at', '<=', Carbon::parse($end_date));
        }

        // Jika kedua tanggal (start_date dan end_date) diberikan, lakukan filter berdasarkan rentang tanggal
        if ($start_date && $end_date) {
            $orders = $orders->whereBetween('created_at', [
                Carbon::parse($start_date)->startOfDay(),
                Carbon::parse($end_date)->endOfDay(),
            ]);
        }

        // Menambahkan relasi user dan pagination
        $orders = $orders->with('user')->simplePaginate(5);

        return view('order.kasir.index', compact('orders'));
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

            if($medicines['stock'] < $count){
                $valueBefore = [
                    'name_costumer' => $request->name_costumer,
                    'medicines' => $request->medicines
                ];
                $msg ="`data obat " .  $medicines['name'] . " sisa stock "  .$medicines['stock']. ", tidak dapat melakukan pembelian";
                return redirect()->back()->withInput()->with('failed' , $msg);
            }else{
                $medicines['stock'] -= $count;
                $medicines->save();
            }

            
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
            'name_costumer' => $request->name_costumer,
            'total_price' => $pricePpn
        ]);

        if($proses)
        {
            $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            return redirect()->route('kasir.order.print', $order->id);

        }else{
            return redirect()->back()->with('failed','gagal membuat data pembelian');   
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order,$id)
    {
        $order = Order::find($id);
        return view('order.kasir.print',compact('order'));
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

    public function downloadPdf($id)
    {
        // ambil data berdasarkan id yang ada di struk dan dipastikan terformat array

        $order = Order::find($id)->toArray();
        // kita akan shere data dengan inisialisasi awal agar bisa digunakan ke blade manapun
        view()->share('order', $order);
        // ini akan meload view halaman downloadnya
        $pdf = PDF::loadView('order.kasir.download-pdf');
        return $pdf->download('invoice.pdf');
    }

    public function data()
    {
        $orders = Order::with("user")->simplePaginate(5);
        return view("order.admin.index",compact('orders'));
    }

    public function exportExcel()
    {
        $file_name = 'data_pembelian'.'.xlsx';

        return Excel::download(new OrdersExport, $file_name);
    }
}
