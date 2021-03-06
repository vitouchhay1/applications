<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Product;
use App\Customuser;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\UploadedFile;
class ProductController extends Controller
{
	public function __construct()
	{
			$this->middleware('auth');
	}
	function getchild(Request $Request){
		$datas=DB::table('categories')->where('pid','=',$Request->get('pid'))->get();  
		echo json_encode($datas);
	} 
	function FindasObjectsNoParam(Request $Request){ 
		$datas[$Request->get('table')]=DB::table($Request->get('table'))->where('id','=',$Request->get('id'))->get();
		echo json_encode($datas);
	}
	function FindasObjects($columns=array(),$table){
		if (count($columns)>0){
			$columns=implode(',', $columns);
		}else{
			$columns='*';
		}
		$datas['results']=DB::select('SELECT '.$columns.' FROM '.$table);
		return $datas;
	}
	function index(){
		$datas['dynamictbl']=$this->FindasObjects(array(),'categories'); 
		$datas['customers']=DB::select('SELECT DISTINCT phone,interest,products.id,customusers.`name`,products.cid,products.pid,galleries.`name` as image,price,decriptions,start_date,end_date FROM products 
inner JOIN customusers ON customusers.id=products.customer_id
INNER JOIN galleries ON galleries.id=products.img_id'); 
		$breadcrumb=array('title'=>'List Products','home'=>'home','type'=>'form','action'=>'products');
		$label['data']='product';
		return view('home.index',array('label'=>$label,'breadcrumb'=>$breadcrumb,'datas'=>$datas));
	}
	function add(Request $Request){ 
		$datas['users']=Customuser::all(); 
		if(isset($_POST['btnSubmit'])){
			//upload multi image 
			$files = $Request->file('proImg');  
			if( count($files) > 0){
				$upload_success=array();
				foreach($files as $file){
					$id = Str::random(14); 
			        $destinationPath ='webs/products/'. $id;  
			        $filename = $file->getClientOriginalName();  
			        $extension = $file->getClientOriginalExtension();
			        $upload_success[]= $file->move($destinationPath, $filename);
				}
			}else{
				$upload_success='';
			}
			$lastid=array();
			if ($upload_success!=''){
				foreach($upload_success as $path){
					#push image id to array | insert with get last_id
					$lastid[]= DB::table('galleries')->insertGetId(['name'=>$path,'created_at'=>date("Y-m-d H:m:s")]);
					#insert only
					// Gallery::insert(array('name'=>$path, 'created_at'=>date("Y-m-d H:m:s") )); 
				}
				$idimg=implode(',', $lastid);
			}else{
				$idimg='';
			} 
			Product::insert(array('customer_id'=>$Request->get('txtPname'),
				'price'=>$Request->get('txtSetPrice'),
				// 'phone'=>$Request->get('txtPhone'),
				// 'email'=>$Request->get('txtEmail'),
				'img_id'=>$idimg,
				'pid'=>$Request->get('txtType'),
				'cid'=>$Request->get('txtModel'),
				'decriptions'=>trim($Request->get('txaDescriptions')),
				'start_date'=>$Request->get('txtStart'), 
				'end_date'=>$Request->get('txtEnd'), 
				'created_at'=>date("Y-m-d H:m:s")
			));
			return Redirect('product');
		}
		$datas['parrents']=Category::all()->where('pid', '=', 0);
		$breadcrumb=array('title'=>'Add Form','home'=>'home','type'=>'form','action'=>'add product');
		$label['data']='addpro';
		return view('home.index',array('label'=>$label,'breadcrumb'=>$breadcrumb,'datas'=>$datas));
	}
	function detail($id){
		$breadcrumb=array('title'=>'Product detail dashboard','home'=>'home','type'=>'form','action'=>'product detail');
		$datas['parrents']=Category::all()->where('pid', '=', 0);
		$datas['customusers']=$this->FindasObjects(array(),'customusers'); 
		// $datas['categories']=$this->FindasObjects(array(),'categories'); 
		$datas['categories']=Category::all();
		$datas['product'] =  DB::table('products')
		->join('customusers', 'products.customer_id', '=', 'customusers.id') 
		->join('galleries', 'galleries.id', '=', 'products.img_id')
		->select('galleries.id as gid','galleries.name as gname','products.cid as pc_id','products.pid','customusers.id as cus_id','customusers.gender', 'customusers.name as cus_name', 'customusers.phone','customusers.email','customusers.address','customusers.descriptions as cus_des','products.id as pro_id','products.price','products.decriptions as pro_des','products.interest','products.img_id','products.start_date','products.end_date')
		->where('products.id','=',$id)->first();
		$label['data']='detailpro';
		return view('home.index',['label'=>$label,'breadcrumb'=>$breadcrumb,'datas'=>$datas]);
	}
	function edit($id){ 
		$datas['parrents']=Category::all()->where('pid', '=', 0);
		$datas['customusers']=$this->FindasObjects(array(),'customusers'); 
		// $datas['categories']=$this->FindasObjects(array(),'categories'); 
		$datas['categories']=Category::all()->where('pid', '>', 0);

		$datas['product'] =  DB::table('products')
		->join('customusers', 'products.customer_id', '=', 'customusers.id') 
		->join('galleries', 'galleries.id', '=', 'products.img_id')
		->select('galleries.id as gid','galleries.name as gname','products.cid as pc_id','products.pid','customusers.id as cus_id', 'customusers.name as cus_name', 'customusers.phone','customusers.email','customusers.address','customusers.descriptions as cus_des','products.id as pro_id','products.price','products.decriptions as pro_des','products.interest','products.img_id','products.start_date','products.end_date')
		->where('products.id','=',$id)->first(); 
		$breadcrumb=array('title'=>'Product update dashboard','home'=>'home','type'=>'form','action'=>'product update');
		$label['data']='editpro';
		return view('home.index',array('label'=>$label,'breadcrumb'=>$breadcrumb,'datas'=>$datas));
	}
	function update($id,Request $Request){  
		$product = Product::findOrFail($id);
		$product->customer_id=$Request->get('cus_name');
		$product->pid=$Request->get('txtType');
		$product->cid=$Request->get('txtModel');
		$product->price=$Request->get('txtPrice');
		$product->interest=$Request->get('txtInterest');
		$product->img_id=$Request->get('img_id');
		$product->start_date=$Request->get('txtStart');
		$product->end_date=$Request->get('txtEnd');
		$product->updated_at=date("Y-m-d H:i:s");
		$product->save();  
		$cus_id=$product->customer_id; 
		$customer = Customuser::findOrFail($cus_id);
		$customer->phone=$Request->get('txtPhone');
		$customer->email=$Request->get('txtEmail');
		$customer->address=$Request->get('txtAddress');
		$customer->descriptions=trim($Request->get('txaDescriptions'));
		$customer->save();
		// $customer->descriptions=$Request->get('txtAddress');
		return Redirect('product');
	}
	public function destroy($id)
	{ 
		$product = Product::findOrFail( $id ); 
		$product->delete();
	}
}
