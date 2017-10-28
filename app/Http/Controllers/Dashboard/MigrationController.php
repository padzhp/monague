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
}
