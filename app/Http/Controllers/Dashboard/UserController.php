<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\ReturnsDatatable;
use App\User;
use DB;

class UserController extends BaseController
{
	protected $connection = 'mysql';	

    public function index(){
		return view('dashboard.pages.dashboard.index');
	}
	
	public function login(){
		return view('dashboard.pages.dashboard.login');
	}

}
