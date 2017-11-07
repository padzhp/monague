<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Traits\ReturnsDatatable;
use App\Page;
use App\Slim;

use DB;
use Auth;


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

        $data['image'] = Slim::slimCropImageAndSave('slim', 'pages');

        $data['published'] = isset($data['published']) ? 1 : 0;
        $data['public'] = isset($data['public']) ? 1 : 0;
        $data['author'] = Auth::user()->id;
        $data['status'] = 1;


        $this->savePage($data, 0);

        return response()->json([
            'status'=>'success',
            'messages'=>['New Page added successfully'],
            'returnurl'=>'/dashboard/pages',
        ]);

    }

    public function update(Request $request, $id){

        $data = $request->except(['_token']);

        $page = Page::find($id);
        $data['image'] = Slim::slimCropImageAndSave('slim', 'pages', $page->image);
        $data['published'] = isset($data['published']) ? 1 : 0;
        $data['public'] = isset($data['public']) ? 1 : 0;

        $this->savePage($data, $id);

         return response()->json([
            'status'=>'success',
            'messages'=>['Page information updated successfully'],
            'returnurl'=>'/dashboard/pages',
        ]);

    }

     public function delete(Request $request){
        
        $ids = $request->ids;
        $data['status'] = -2;

        if(is_array($ids)){

            Page::whereIn('id',$ids)                      
            ->update(['status' => -2]);

        } else {
            $ids = $request->id;
            $page = Page::find($ids);
            $page->update($data);
        }

        return response()->json([
            'status'=>'success',
            'messages'=>['Page/s has been deleted'],
            'returnurl'=>'/dashboard/pages',
        ]);
    }
 

    public function savePage($data, $id=0){

        if($id == 0){
            $page = Page::create($data);            
        } else {
            $page = Page::find($id);
            $page->update($data);           
        }

        return $page;

    }

}
