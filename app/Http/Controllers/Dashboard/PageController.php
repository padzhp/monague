<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Traits\ReturnsDatatable;
use App\Page;
use App\Slim;

use DB;


class PageController extends Controller
{
    use ReturnsDatatable;
    protected $connection = 'mysql';    


    function index(){         
        return view('dashboard.pages.page.index');
    }

    public function datatable(Request $request)
    {
        return $this->dtOutput();
    }
    
    public function dtQuery()
    {
        $request = request();
        $search = $request->search;        

        $query = Page::where('status','>=',0);
               
        return $query;
    }

    public function dtSort()
    {
        $request = request();
        $sort_by = 'pages.ordering';
        $sort_order = 'ASC';
        
        return [
            'sort' => $sort_by,
            'dir' => $sort_order,
        ];
    }

    public function dtRowData(Page $page)
    {
    
        return [
            'DT_RowId' => $page->id,
            'id' => $page->id,           
            'title' => $page->title,
            'image' => $page->image ? asset($page->image) : asset(config('app.default_header_image')),
            'published' => $page->published,
            'public' => $page->public,
            'ordering' => $page->ordering,

        ];
    }

    public function dtTotal($query)
    {
        return $query->get()->count();
    }

    public function create(){        
        return view('dashboard.pages.page.create');
    }

    public function edit($id){

        $page = Page::findOrFail($id);

        return view('dashboard.pages.page.edit', compact('page'));
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
            'messages'=>['New Page added successfully'],
            'returnurl'=>'/dashboard/pages',
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
            'messages'=>['Page information updated successfully'],
            'returnurl'=>'/dashboard/pages',
        ]);

    }

    public function delete(Request $request){
        $id = $request->id;
        $data['status'] = -2;
        $updated = $this->saveAdmin($data, $id);

        return response()->json([
            'status'=>'success',
            'messages'=>['Page has been deleted'],
            'returnurl'=>'/dashboard/pages',
        ]);
    }


    public function activate(Request $request){
        $id = $request->id;
        $data['status'] = 1;
        
        $user = User::find($id);
        $user->update($data);

        return response()->json([
            'status'=>'success',
            'messages'=>['Page has been activated'],
            'returnurl'=>'/dashboard/pages',
        ]);
    }

    public function savePages($data, $id=0){

        if($id == 0){
            $page = Page::create($data);            
        } else {
            $page = Page::find($id);
            $page->update($data);           
        }

        return $page;

    }

}
