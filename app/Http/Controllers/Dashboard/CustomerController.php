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
use DB;

class CustomerController extends BaseController
{
	use ReturnsDatatable;
	protected $connection = 'mysql';

    function index(){
		return view('dashboard.pages.customer.index');
	}

	public function datatable(Request $request)
    {
        return $this->dtOutput();
    }

    public function dtQuery()
    {
        $request = request();
        $search = $request->search;        

        $query = User::join('customers', 'users.id', '=', 'customers.user_id')
        		->where('role','=','user');

        if (!is_array($search) && trim($search) != '') {
            $query->where('users.name', 'LIKE', '%'.$search.'%');
            $query->orWhere('customers.company', 'LIKE', '%'.$search.'%');
        }

        if($request->country != "ALL"){
           $query->where('customers.billing_country', '=', $request->country); 
        }
        
        return $query;
    }

    public function dtSort()
    {
        $request = request();
        $sort_by = 'users.created_at';
        $sort_order = 'ASC';

        if (isset($request->order[0])) {
            $sortable = [                
                'users.created_at',
                'users.contact',                
                'customers.country',
                'customers.company',
                'users.email',
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

    public function dtRowData(User $user)
    {
    
        return [
            'id' => $user->id,           
            'country' => $user->billing_country,
            'created_at' => $user->created_at->format('m-d-Y'),
            'contact' => $user->name,
            'company' => $user->company,
            'email' => $user->email,            
        ];
    }

    public function dtTotal($query)
    {
        return $query->get()->count();
    }

    public function create(){
    	return view('dashboard.pages.customer.create');
    }

    public function edit($id){

        $user = User::with("customer")->findOrFail($id);
        $customer = $user->getCustomerInfo($user);
        

    	return view('dashboard.pages.customer.edit', compact('customer'));
    }

    public function store(Request $request){

        $data = $request->all();
        $this->saveCustomer($data, 0);

        return redirect()->route('customers.index')
                        ->with('success','New Customer created successfully');

    }

    public function update(Request $request, $id){

        $data = $request->except(['_token']);;
        $this->saveCustomer($data, $id);

        return redirect()->route('customers.index')
                        ->with('success','Customer Information updated successfully');

    }

    public function saveCustomer($data, $id=0){

        if($id == 0){
            $user = User::create($data);
            $customer = new Customer($data);
            $customer->user_id = $user->id;
            $customer->save();
        } else {
            $user = User::find($id);
            $user->update($data);
            $customer = Customer::where('user_id','=',$id)->first();
            $customer->update($data);
        }

        return $user;

    }

}
