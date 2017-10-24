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


class DashboardController extends BaseController
{
	use ReturnsDatatable;
	protected $connection = 'mysql';

    function index(){
		return view('dashboard.pages.dashboard.index');
	}
			
}
