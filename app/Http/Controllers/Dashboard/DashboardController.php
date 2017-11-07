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
use App\OrderItem;
use DB;


class DashboardController extends BaseController
{
	use ReturnsDatatable;
	protected $connection = 'mysql';

    function index(){

    	$lists = array();

    	$lists['payment_types'] = config('app.payment_types');

    	$orders = Order::where('id','<>',0)
    			  		->orderBy('created_at','DESC')
    			  		->limit(5)
    			  		->get();

    	$customers = User::join('countries', 'countries.id', '=', 'users.country_id')
		                ->join('customers', 'users.id', '=', 'customers.user_id')
		        		->where('role','=','customer')
		                ->where('status','=',0)
		                ->orderBy('created_at','DESC')
		                ->limit(5)
		                ->get();

		$lists['monthly_sales'] = Order::whereDate('created_at','>=',date("Y-m-01"))
    			  		->whereDate('created_at','<=',date("Y-m-t"))
    			  		->select(DB::raw('SUM(total) as total_sales'))
    			  		->value('total_sales');

    	$lists['new_customers'] = User::whereDate('created_at','>=',date("Y-m-01"))
    			  		->whereDate('created_at','<=',date("Y-m-t"))
    			  		->where('role','=','customer')
    			  		->select(DB::raw('count(*) as new_users'))
    			  		->value('new_users');

    	
		return view('dashboard.pages.dashboard.index', compact('orders','customers','lists'));
	}

	public function topOrderedItems(){

		$orders = OrderItem::where('id','<>',0)
    			  		->orderBy('total_sales','DESC')
    			  		->groupBy('product_id')
    			  		->select(DB::raw('SUM(subtotal) as total_sales, product_id'))
    			  		->limit(10)
    			  		->get();

    	
	}


    public function activate(Request $request){

        $id = $request->id;
        $data['status'] = 1;


        
        $user = User::find($id);
        $user->update($data);

        return response()->json([
            'status'=>'success',
            'messages'=>['Customer activated successfully'],
        ]);
    }

    public function deactivate(Request $request){

        $id = $request->id;
        $data['status'] = 0;


        
        $user = User::find($id);
        $user->update($data);

        return response()->json([
            'status'=>'success',
            'messages'=>['Customer deactivated successfully'],
        ]);
    }
			
}
