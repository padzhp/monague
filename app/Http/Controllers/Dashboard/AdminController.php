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
use App\Slim;
use DB;

class AdminController extends BaseController
{
	use ReturnsDatatable;
	protected $connection = 'mysql';    


    function index(){        

         $lists['countries'] = $this->getCountriesList('ALL');

		return view('dashboard.pages.admin.index', compact('lists'));
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

        $query = User::where('status','>=',0)
        		->where('role','=','admin');

        if (!is_array($search) && trim($search) != '') {
            $query->where(function($q) use ($search) {
                $q->where('users.username', 'LIKE', '%'.$search.'%');
                $q->orWhere('users.email', 'LIKE', '%'.$search.'%');
                $q->orWhere('users.name', 'LIKE', '%'.$search.'%');
            });           
        }       
        
        return $query;
    }

    public function dtSort()
    {
        $request = request();
        $sort_by = 'users.name';
        $sort_order = 'ASC';

        if (isset($request->order[0])) {
            $sortable = [                
                'users.username',
                'users.name',
                'users.email',
                'users.last_login',                
            ];
            $col = $request->order[0]['column'];
            $sort_by = isset($sortable[$col]) ? $sortable[$col] : 'users.name';
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
        	'DT_RowId' => $user->id,
            'id' => $user->id,           
            'username' => $user->username,
            'last_login' => $user->last_login ? $user->last_login->format('m-d-Y') : '--',
            'name' => $user->name,
            'email' => $user->email,

        ];
    }

    public function dtTotal($query)
    {
        return $query->get()->count();
    }

    public function create(){
        $lists['countries'] = $this->getCountriesList();
    	return view('dashboard.pages.admin.create', compact('lists'));
    }

    public function edit($id){

        $admin = User::findOrFail($id);
        $admin->password = $admin->unhashed;
                        
        $lists['countries'] = $this->getCountriesList();

    	return view('dashboard.pages.admin.edit', compact('admin','lists'));
    }

    public function store(Request $request){

        $data = $request->all();

        $data['photo'] = Slim::slimCropImageAndSave('slim');

        $data['unhashed'] = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $data['role']  = 'admin';
        $data['subscribed']  = 0;
        $data['country_id']  =  0;
        //dd($data);

        $this->saveAdmin($data, 0);

        return response()->json([
            'status'=>'success',
            'messages'=>['New admin added successfully'],
            'returnurl'=>'/dashboard/admins',
        ]);

    }

    public function update(Request $request, $id){

        $data = $request->except(['_token']);

        $data['unhashed'] = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $user = User::find($id);
        $data['photo'] = Slim::slimCropImageAndSave('slim', 'admins', $user->photo);
        //dd()

        $this->saveAdmin($data, $id);

         return response()->json([
            'status'=>'success',
            'messages'=>['Admin information updated successfully'],
            'returnurl'=>'/dashboard/admins',
        ]);

    }

    public function delete(Request $request){
        $id = $request->id;
        $data['status'] = -2;
        $updated = $this->saveAdmin($data, $id);

        return response()->json([
            'status'=>'success',
            'messages'=>['Admin has been deleted'],
            'returnurl'=>'/dashboard/admins',
        ]);
    }


    public function activate(Request $request){
        $id = $request->id;
        $data['status'] = 1;
        
        $user = User::find($id);
        $user->update($data);

        return response()->json([
            'status'=>'success',
            'messages'=>['Admin has been activated'],
            'returnurl'=>'/dashboard/admins',
        ]);
    }

    public function saveAdmin($data, $id=0){

        if($id == 0){
            $user = User::create($data);            
        } else {
            $user = User::find($id);
            $user->update($data);           
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
