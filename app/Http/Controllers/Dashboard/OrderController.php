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

    function index(){
		return view('dashboard.pages.order.index');
	}

	public function datatable(Request $request)
    {
        return $this->dtOutput();
    }

    public function dtQuery()
    {
        $request = request();
        $search = $request->search;

        $query = Order::where('id','<>',0);

        if (!is_array($search) && trim($search) != '') {
            $query->where('orders.order_company', 'LIKE', '%'.$search.'%');
            $query->orWhere('orders.order_contact', 'LIKE', '%'.$search.'%');
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
        $sort_order = 'ASC';

        if (isset($request->order[0])) {
            $sortable = [                
                'orders.created_at',
                'orders.order_id',                
                'orders.order_country',
                'orders.order_company',
                'orders.order_contact',                
                'orders.order_total',
                'orders.order_payment_type',
                'orders.order_status',
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
            'id' => $order->id,
            'order_id' => $order->order_id,
            'order_country' => $order->order_country,
            'created_at' => $order->created_at->format('m-d-Y'),
            'order_contact' => $order->order_contact,
            'order_total' => $order->order_total,
            'order_company' => $order->order_company,
            'order_payment_type' => $order->order_payment_type,
            'order_status' => $order->order_status,            
        ];
    }

    public function dtTotal($query)
    {
        return $query->get()->count();
    }
	
	
}
