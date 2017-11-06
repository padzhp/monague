<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\ReturnsDatatable;
use App\Product;
use App\Category;
use App\Slim;
use DB;
use Form;

class ProductController extends Controller
{
    use ReturnsDatatable;
    protected $connection = 'mysql';
    var $category_tree = '';

    function index(){
        return view('dashboard.pages.product.index');
    }

    public function datatable(Request $request)    
    {
        $this->category_tree = $this->categoryTree();
        return $this->dtOutput();
    }

    public function dtQuery()
    {
        $request = request();
        $search = $request->search;        

        $query = Product::join('categories', 'categories.id', '=', 'products.category_id')
                        ->where('products.status','>=', 0)
                        ->select('products.*','categories.id as category_id','categories.name as category_name');

        /*if (!is_array($search) && trim($search) != '') {
            $query->where('products.name', 'LIKE', '%'.$search.'%');
            $query->orWhere('products.ca_sku', 'LIKE', '%'.$search.'%');
            $query->orWhere('products.us_sku', 'LIKE', '%'.$search.'%');

        }

        if($request->published != "ALL"){
           $query->where('products.status', '=', $request->status); 
        }

        if($request->category != "ALL"){
           $query->where('products.category_id', '=', $request->category); 
        }*/
        
        return $query;
    }

    public function dtSort()
    {
        $request = request();
        $sort_by = 'products.ordering';
        $sort_order = 'ASC';
        
        return [
            'sort' => $sort_by,
            'dir' => $sort_order,
        ];
    }

    public function dtRowData(Product $product)
    {
        
        return [
            'id' => $product->id,           
            'name' => $product->name,
            'description' => $product->description,
            'image' => asset($product->image),
            'status' => $product->status,
            'ordering' => $product->ordering, 
            'category' => $product->category, 
            'ca_enabled' => $product->ca_enabled, 
            'ca_price' => $product->ca_price, 
            'ca_six_plus' => $product->ca_six_plus,
            'ca_six_pack' => $product->ca_six_pack,             
            'ca_dozen_pack' => $product->ca_dozen_pack, 
            'ca_sku' => $product->ca_sku, 
            'us_enabled' => $product->us_enabled, 
            'us_price' => $product->us_price, 
            'us_six_plus' => $product->us_six_plus,
            'us_six_pack' => $product->us_six_pack,             
            'us_dozen_pack' => $product->us_dozen_pack, 
            'us_sku' => $product->us_sku,
            'category_list' => Form::select('product['.$product->id.'][category_id]', $this->category_tree, $product->category_id, ['class' => 'form-control'])->toHtml(),
        ];
    }

    public function dtTotal($query)
    {
        return $query->get()->count();
    }

    public function create(){        
        $lists['categories'] = $this->categoryTree();


        return view('dashboard.pages.product.create', compact('lists'));
    }
    
    public function store(Request $request){

        $data = $request->all();
        $data['image'] = Slim::slimCropImageAndSave('slim','products');


        $this->saveProduct($data, 0);

        return response()->json([
            'status'=>'success',
            'messages'=>['New product added successfully'],
            'returnurl'=>'/dashboard/products',
        ]);

    }

    public function delete(Request $request){
        $id = $request->id;
        $data['status'] = -2;
        $updated = $this->saveProduct($data, $id);

        return response()->json([
            'status'=>'success',
            'messages'=>['Product has been deleted'],
            'returnurl'=>'/dashboard/products',
        ]);
    }

    public function update(Request $request){


        $data = $request->except(['_token']);

        foreach($data['product'] as $id=>$product){
             $product['ca_published'] = isset($product['ca_published']) ? 1 : 0;
             $product['us_published'] = isset($product['us_published']) ? 1 : 0;
             $product['ca_enabled'] = isset($product['ca_enabled']) ? 1 : 0;
             $product['us_enabled'] = isset($product['us_enabled']) ? 1 : 0;
             $product['image'] = Slim::slimCropImageAndSave('', 'products', $id, $product['image']);
             //dd($product);             
             $updated = $this->saveProduct($product, $id);             
         }       

        return response()->json([
            'status'=>'success',
            'messages'=>['Product information updated successfully'],
            'returnurl'=>'/dashboard/products',
        ]);

    }

    public function details(Request $request){
        $id = $request->id;
        $data = array();
        
        $product = Product::findOrFail($id);

        $data = $product->toArray();        
        $data['image'] = asset($data['image']);
        
        return response()->json($data);
    }

    public function updateDescription(Request $request){
        $id = $request->id;
        $data = array();
        $data['description'] = $request->desc;

        $updated = $this->saveProduct($data, $id);

        return response()->json([
            'status'=>'success',
            'messages'=>['Product description updated successfully']
        ]);
    }

    public function saveProduct($data, $id=0){

        if($id == 0){           
            $product = new Product($data);
            $product->save();
        } else {
            $product = Product::find($id);
            $product->update($data);           
        }

        return $product;

    }

    public function categoryTree(){

        $cat = new Category();
        $categories = $cat->getCategories('--');
        $data = array();
        $data[0] = 'Select Category';

        foreach($categories as $category){
            $data[$category->id] = $category->name;
        }

        return $data;
    }
    
}
