<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\ReturnsDatatable;
use App\User;
use App\Country;
use App\Customer;
use DB;

class CustomerController extends BaseController
{
	use ReturnsDatatable;
	protected $connection = 'mysql';    


    function index(){        

         $lists['countries'] = $this->getCountriesList('ALL');

		return view('dashboard.pages.customer.index', compact('lists'));
	}

	public function datatable(Request $request)
    {
        return $this->dtOutput();
    }

    public function getCountriesList($default="Select Country"){
        return ([null=>$default ] + Country::orderBy('country')->pluck('country', 'id')->all());
    }

    public function dtQuery()
    {
        $request = request();
        $search = $request->search;        

        $query = User::join('countries', 'countries.id', '=', 'users.country_id')
                ->join('customers', 'users.id', '=', 'customers.user_id')
        		->where('role','=','customer')
                ->where('status','>=',0);

        if (!is_array($search) && trim($search) != '') {
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'LIKE', '%'.$search.'%');
                $q->orWhere('customers.company', 'LIKE', '%'.$search.'%');
            });           
        }

        if($request->country != ""){
           $query->where('users.country_id', '=', $request->country); 
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
                'countries.country',
                'customers.company',
                'users.name',                
                'users.email',
                'users.created_at',
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
            'DT_RowId' => $user->user_id,
            'id' => $user->user_id,           
            'country' => $user->country,
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
        $lists['countries'] = $this->getCountriesList();
    	return view('dashboard.pages.customer.create', compact('lists'));
    }

    public function edit($id){

        $user = User::with("customer")->findOrFail($id);
        
        $customer = $user->getCustomerInfo($user);
        
        $lists['countries'] = $this->getCountriesList();

    	return view('dashboard.pages.customer.edit', compact('customer','lists'));
    }

    public function store(Request $request){

        $data = $request->all();
        $data['unhashed'] = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $data['role']  = 'customer';
        $data['subscribed']  = 0;
        $data['country_id']  =  $data['billing_country'];

        //dd($data);

        $this->saveCustomer($data, 0);

        return response()->json([
            'status'=>'success',
            'messages'=>['New customer added successfully'],
            'returnurl'=>'/dashboard/customers',
        ]);

    }

    public function update(Request $request, $id){

        $data = $request->except(['_token']);

        $data['unhashed'] = $data['password'];
        $data['password'] = bcrypt($data['password']);
        
        $this->saveCustomer($data, $id);

         return response()->json([
            'status'=>'success',
            'messages'=>['Customer information updated successfully'],
            'returnurl'=>'/dashboard/customers',
        ]);

    }

    public function delete(Request $request){
        
        $ids = $request->ids;
        $data['status'] = -2;

        if(is_array($ids)){

            User::whereIn('id',$ids)                      
            ->update(['status' => -2]);

        } else {
            $ids = $request->id;
            $user = User::find($ids);
            $user->update($data);
        }

        return response()->json([
            'status'=>'success',
            'messages'=>['Customer has been deleted'],
            'returnurl'=>'/dashboard/customers',
        ]);
    }


    public function activate(Request $request){
        $id = $request->id;
        $data['status'] = $request->status;
        
        $status = $data['status'] ? 'activated' : 'deactivated';

        $user = User::find($id);
        $user->update($data);

        return response()->json([
            'status'=>'success',
            'messages'=>['Customer has been '.$status],
            'returnurl'=>'/dashboard/customers',
        ]);
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

    public function uniqueEmail(Request $request){
        
        $user = User::where('email', $request->get('email'))
                ->where('id','<>', $request->get('id'))
                ->get();
   

        if(count($user)){
            return response()->json(false);
        } else {
            return response()->json(true);
        }

    }

}
