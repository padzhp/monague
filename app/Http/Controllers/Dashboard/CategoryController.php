<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\ReturnsDatatable;
use App\Category;
use DB;

class CategoryController extends Controller
{
    use ReturnsDatatable;
    protected $connection = 'mysql';

    function index(){
        return view('dashboard.pages.category.index');
    }


    public function datatable(Request $request)
    {
        return $this->dtOutput();
    }

    public function dtOutput()
    {
        $total = 0;
        $data = [];
        $limit = $this->dtLimit();
        $offset = $this->dtOffset();
        
        $cat = new Category();
        $categories = $cat->getCategories('<sup>|_</sup>&nbsp;&nbsp;', false);


        if (count($categories)) {

            $total = count($categories);

            $results = array_slice($categories, $offset, $limit);

            foreach($results as $result) {
                $data[] = $this->dtRowData($result);
            }
        }

        return [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ];
    }

    public function dtRowData(Category $category)
    {
    
        return [
            'id' => $category->id,           
            'category' => $category->name,
            'parent' => $category->parent == 1 ? ' - ' : $category->parentname,
            'ca_enabled' => $category->ca_status,            
            'us_enabled' => $category->us_status, 
            'ordering' => $category->ordering,
            'DT_RowId' => $category->id,             
        ];
    }

    public function dtTotal($query)
    {
        return $query->get()->count();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lists['parent'] = $this->categoryTree();
        return view('dashboard.pages.category.create', compact('lists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function edit($id){

        $category = Category::findOrFail($id);
        
       
        $lists['parent'] = $this->categoryTree();

        return view('dashboard.pages.category.edit', compact('category','lists'));
    }

    public function store(Request $request){

        $data = $request->all();        
        //dd($data);

        $this->saveCategory($data, 0);

        return response()->json([
            'status'=>'success',
            'messages'=>['New category added successfully'],
            'returnurl'=>'/dashboard/categories',
        ]);

    }

    public function update(Request $request, $id){

        $data = $request->except(['_token']);

        //dd($data);

        $this->saveCategory($data, $id);

         return response()->json([
            'status'=>'success',
            'messages'=>['Category information updated successfully'],
            'returnurl'=>'/dashboard/categories',
        ]);

    }

    public function massupdate(Request $request){


        $data = $request->except(['_token']);


        foreach($data['category'] as $id=>$category){            
             $category['ca_status'] = isset($category['ca_status']) ? 1 : 0;
             $category['us_status'] = isset($category['us_status']) ? 1 : 0;           
             $category['ordering'] = isset($category['ordering']) ? $category['ordering'] : 0; 
             
             $updated = $this->saveCategory($category, $id);             
         }       

        return response()->json([
            'status'=>'success',
            'messages'=>['Categories updated successfully'],
            'returnurl'=>'/dashboard/categories',
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


    public function saveCategory($data, $id=0){

        if($id == 0){
            $user = Category::create($data);            
        } else {
            $category = Category::find($id);
            $category->update($data);           
        }

        return $category;

    }


    public function categoryTree(){

        $cat = new Category();
        $categories = $cat->getCategories('--');
        $data = array();
        $data[1] = 'Root Category';

        foreach($categories as $category){
            $data[$category->id] = $category->name;
        }

        return $data;
    }
}
