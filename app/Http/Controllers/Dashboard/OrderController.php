<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\ReturnsDatatable;
use App\User;
use App\Order;
use DB;

class OrderController extends BaseController
{
	use ReturnsDatatable;
	protected $connection = 'mysql';
    var $payment_types = '';
    var $order_status = '';
    

    function index(){
		return view('dashboard.pages.order.index');
	}

	public function datatable(Request $request)
    {
        $this->payment_types = config('app.payment_types');
        return $this->dtOutput();
    }

    public function dtQuery()
    {
        $request = request();
        $search = $request->search;

        $query = Order::where('id','<>',0);

        if (!is_array($search) && trim($search) != '') {
            $query->where('orders.company', 'LIKE', '%'.$search.'%');
            $query->orWhere('orders.customer', 'LIKE', '%'.$search.'%');
        }

        if ($request->year) {
            $year = Carbon::createFromFormat('d/m/Y', $request->year);
            $query->whereYear('orders.created_at', '=', $created_at->format('Y'));
        }

        if ($request->month) {
            $month = Carbon::createFromFormat('d/m/Y', $request->month);
            $query->whereMonth('orders.created_at', '=', $created_at->format('m'));
        }

        return $query;
    }

    public function dtSort()
    {
        $request = request();
        $sort_by = 'orders.created_at';
        $sort_order = 'DESC';

        if (isset($request->order[0])) {
            $sortable = [                
                'orders.created_at',
                'orders.order_id',                
                'orders.order_country',
                'orders.company',
                'orders.customer',                
                'orders.amount',
                'orders.payment_type',
                'orders.status',
            ];
            $col = $request->order[0]['column'];
            $sort_by = isset($sortable[$col]) ? $sortable[$col] : 'created_at';
            $sort_order = $request->order[0]['dir'];
        }

        return [
            'sort' => $sort_by,
            'dir' => $sort_order,
        ];
    }

    public function dtRowData(Order $order)
    {
        
        return [
            'DT_RowId' => $order->id,
            'id' => $order->id,
            'order_id' => $order->id,
            'order_country' => $order->billing_country,
            'created_at' => date('m-d-Y',strtotime($order->created_at)),
            'order_contact' => $order->customer,
            'order_total' => $order->total,
            'order_company' => $order->company,
            'order_payment_type' => $order->payment_type ? $this->payment_types[$order->payment_type] : '',
            'order_status' => $order->status ? $order->status : '',            
        ];
    }

    public function dtTotal($query)
    {
        return $query->get()->count();
    }


    public function details($id){


        $order = Order::with('orderitems')
                ->findOrFail($id); 


        if($order->shipping_address){
            $order->shipping_address .= ' '.$order->shipping_city;
            $order->shipping_address .= ' '.$order->shipping_state;
            $order->shipping_address .= ' '.$order->shipping_zip;
            $order->shipping_address .= ', '.$order->shipping_country;
        } else {
            $order->shipping_address .= $order->billing_address.' '.$order->billing_city;
            $order->shipping_address .= ' '.$order->billing_state;
            $order->shipping_address .= ' '.$order->billing_zip;
            $order->shipping_address .= ', '.$order->billing_country;
        }
       
        $lists = array();
        $lists['payment_types'] = config('app.payment_types');
        $lists['order_status'] = config('app.order_status');

        return view('dashboard.pages.order.details', compact('order','lists'));
    }
	
	
}
