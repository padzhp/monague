<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\ReturnsDatatable;
use App\User;
use App\Customer;
use App\Member;
use App\Product;
use App\Category;
use App\Order;
use App\OrderItem;
use DB;

class MigrationController extends BaseController
{
	
    public function users(){

    	ini_set('max_execution_time', '300');
		
    	$members = Member::get();

    	$counter = 0;

    	//dd(bcrypt('admin'));

    	foreach($members as $member){
    		$data1 = array();
    		$data2 = array();

    		$data1['id'] = $member->Memberid;
			$data1['name'] = $member->contact_name;
			$data1['email'] = $member->Email;
			$data1['password'] = bcrypt($member->Password);
			$data1['unhashed'] = $member->Password;
			$data1['country'] = $member->country;
			$data1['role'] = 'customer';
			$data1['created_at'] = $member->registerDate;
			$data1['status'] = ($member->Activation == 1 ? 1 : 0);
			$data1['subscribed'] = $member->allow_subscription;


    		$data2['user_id'] = $member->Memberid;
    		$data2['company'] = $member->company_name;
    		$data2['billing_street'] = $member->billing_address;
    		$data2['billing_city'] = $member->city;
    		$data2['billing_state'] = $member->prov_state;
    		$data2['billing_country'] = $member->country;
    		$data2['billing_zip'] = $member->postal;
    		$data2['shipping_street'] = $member->shipping_address;
    		$data2['shipping_city'] = $member->city;
    		$data2['shipping_state'] = $member->prov_state;
    		$data2['shipping_country'] = $member->country;
    		$data2['shipping_zip'] = $member->postal;
    		$data2['phone'] = $member->phone;
    		$data2['fax'] = $member->fax;
    		$data2['tax_number'] = $member->tax;
    		$data2['store_operation'] = $member->store_op;
    		$data2['store_type'] = $member->type_store;
    		$data2['price_range'] = $member->price_product;
    		$data2['heard_from'] = $member->hear_about;


    		$user = User::create($data1);
            $customer = Customer::create($data2);
            $counter++;
    	}

    	echo $counter.' users migrated successfully';
	}


	public function products(){




	}


	public function categories(){
		ini_set('max_execution_time', '300');

		$data = array();
		$counter = 0;

		$categories = DB::connection('mysql2')
				->table('mnc_k2_categories')
				->get();

		foreach($categories as $category){
			$data['id'] = $category->id;
			$data['name'] = $category->name;
			$data['alias'] = $category->alias;
			$data['description'] = $category->description;
			$data['parent'] = $category->parent;
			$data['image'] = $category->image;
			$data['status'] = $category->published;
			$data['ordering'] = $category->ordering;

			$cat = Category::create($data);
			$counter++;
		}

		echo $counter.' categories migrated successfully';
		
		
	}

	public function orders(){

		ini_set('max_execution_time', '10000');

		$data = array();
		$data2 = array();
		$ids = array();
		$counter = 0;

		 $orders = DB::connection('mysql2')
				->table('mnc_k2store_orders as a')
				->join('mnc_k2store_orderinfo as b','b.order_id','=','a.order_id')				
				->get();

				
		foreach($orders as $order){
			if(in_array($order->id, $ids))
				continue;
			$ids[] = $order->id;
			$data['id'] = $order->id;
			$data['order_id'] = $order->order_id;
			$data['user_id'] = $order->user_id;
			$data['email'] = $order->user_email;
			$data['token'] = $order->token;
			$data['status'] = $order->order_state;
			$data['payment_type'] = $order->orderpayment_type;
			$data['total'] = $order->order_total;
			$data['currency'] = $order->currency_code;
			$data['customer_note'] = $order->customer_note;
			$data['company'] = $order->billing_company;
			$data['customer'] = $order->billing_first_name;
			$data['phone'] = $order->billing_phone_1;
			$data['billing_address'] = $order->billing_address_1;
			$data['billing_city'] = $order->billing_city;
			$data['billing_state'] = $order->billing_zone_name;
			$data['billing_country'] = $order->billing_country_name;
			$data['billing_zip'] = $order->billing_zip;
			$data['tax_number'] = $order->billing_tax_number;
			$data['shipping_address'] = $order->shipping_address_1;
			$data['shipping_city'] = $order->shipping_city;
			$data['shipping_state'] = $order->shipping_zone_name;
			$data['shipping_country'] = $order->shipping_country_name;
			$data['shipping_zip'] = $order->shipping_zip;
			$data['created_at'] = $order->created_date == '0000-00-00 00:00:00' ? '2012-01-01 00:00:00' : $order->created_date;
			$data['updated_at'] = $data['created_at'];

			$o = Order::create($data);
			
			$counter++;
		} 

		/*$items = DB::connection('mysql2')
				->table('mnc_k2store_orderitems as a')		
				->get();

		foreach($items as $item){
			$data['id'] = $item->orderitem_id;
			$data['order_id'] = $item->order_id;
			$data['product_id'] = $item->product_id;
			$data['product_name'] = $item->orderitem_name;
			$data['quantity'] = $item->orderitem_quantity;
			$data['product_price'] = $item->orderitem_price;
			$data['subtotal'] = $item->orderitem_final_price;
			

			$o = OrderItem::create($data);
			$counter++;
		}*/

		echo $counter.' orders migrated successfully';

	}

	public function products(){

		/* k2 images md5("Image".$item->id).'_L.jpg'; */

	}
}
