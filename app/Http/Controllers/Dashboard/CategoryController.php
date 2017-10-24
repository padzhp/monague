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

    public function dtQuery()
    {   

        $query = Category::where('status','>=', 0);
                
        return $query;
    }

    public function dtSort()
    {
        $request = request();
        $sort_by = 'ordering';
        $sort_order = 'ASC';
        
        return [
            'sort' => $sort_by,
            'dir' => $sort_order,
        ];
    }

    public function dtRowData(Category $category)
    {
    
        return [
            'id' => $category->id,           
            'category' => $category->name,
            'parent' => $category->parent,
            'ca_enabled' => $category->ca_enabled,            
            'us_enabled' => $category->us_enabled, 
            'ordering' => $category->ordering,             
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
        return view('dashboard.pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
