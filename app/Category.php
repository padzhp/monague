<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

	protected $fillable = [
        'id','parent','name','alias','description','image','status','ordering','ca_status','us_status'
    ];
    //

    protected $connection = "mysql";

    
   	public function getCategories($prefix = '', $repeatprefix = true){
    	$data = array();
    	$level = 1;
	
    	$categories = $this->where('categories.status','>=',0)
    				->join('categories as cat','cat.id','=','categories.parent')
    				->where('categories.parent','>=',1)
    				->orderBy('categories.ordering','asc')
    				->select('categories.*','cat.name as parentname')
    				->get(); 


    	foreach($categories as $category){
    		if($category->parent == 1){
	    		$data[] = $category;
	    		$children = $this->getSubCategories($categories, $category->id, $prefix, $level, $repeatprefix);
	    		if(count($children)){
	    			$data = array_merge($data, $children);
	    		}
	    	}
    	}
    	
    	return $data;

    }


    public function getSubCategories($categories, $parent, $prefix, $level, $repeatprefix) {
    	$data = array();
    	$newprefix = '';
    	$spacer = '';
    	
    		       	
    	for($i=0;$i<$level;$i++){
    		if($repeatprefix)
    			$newprefix .= $prefix;
    		else
    			$newprefix = $prefix;
    		$spacer .= '&nbsp;&nbsp;';
    	}    

    	$level++;		
    	

    	foreach($categories as $category){

    		if($category->parent == $parent){
	    		$category->name = $spacer.$newprefix.' '.$category->name;

	    		$data[] = $category;
	    		$children = $this->getSubCategories($categories, $category->id, $prefix, $level, $repeatprefix);
	    		if(count($children)){
	    			$data = array_merge($data, $children);
	    		}
	    	}
    	}

    	return $data;
    }
}
