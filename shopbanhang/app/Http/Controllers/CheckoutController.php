<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();

class CheckoutController extends Controller
{
    public function login_checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_startus','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_startus','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request -> customer_name;
        $data['customer_email'] = $request -> customer_email;
        $data['customer_password'] = md5($request -> customer_password);
        $data['customer_phone'] = $request -> customer_phone;

        $customer_id = DB::table('tbl_customer')-> insertGetId($data);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request -> customer_name);
        return Redirect::to('/checkout');

    }

    public function checkout(){
        $cate_product = DB::table('tbl_category_product')->where('category_startus','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_startus','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function save_checkout_customer(Request $request) {
        $data = array();
        $data['shipping_name'] = $request -> shipping_name;
        $data['shipping_email'] = $request -> shipping_email;
        $data['shipping_note'] = $request -> shipping_note;
        $data['shipping_phone'] = $request -> shipping_phone;
        $data['shipping_address'] = $request -> shipping_address;

        $shipping_id = DB::table('tbl_shipping')-> insertGetId($data);
        Session::put('shipping_id',$shipping_id);
      
        return Redirect::to('/payment');

    }

    public function payment(){
        $cate_product = DB::table('tbl_category_product')->where('category_startus','1')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_startus','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect('/login-checkout');
    }

    public function login_customer(Request $request){
        $email = $request -> email_account;
        $password = md5($request -> password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)-> where('customer_password',$password)->first();
        if($result){
            Session::put('customer_id',$result -> customer_id);
            return Redirect('/checkout');
        }else{
            return Redirect('/login-checkout');
        }
       
   
    
    }

    public function order_place(Request $request){
        // print_r(Cart::content());
        //insert payment method
        $data = array();
        $data['payment_method'] = $request -> payment_option;
        $data['payment_status'] = '??ang x??? l??';
        
        $payment_id = DB::table('tbl_payment')-> insertGetId($data);

        //insert order
      
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] =  $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = '??ang ch??? x??? l??';
        
        $order_id = DB::table('tbl_order')-> insertGetId($order_data);

        //insert order detail
        $content = Cart::content();
        foreach ($content as $v_content) {
            $order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $v_content-> id;
            $order_d_data['product_name'] = $v_content-> name;
            $order_d_data['product_price'] = $v_content-> price;
            $order_d_data['product_sales_quality'] = $v_content-> qty;
            DB::table('tbl_order_details')-> insert($order_d_data);
        }
       
        if(  $data['payment_method']==1){
            echo 'Thanh to??n b???ng th??? ATM';
        }elseif(  $data['payment_method']==2){
            $cate_product = DB::table('tbl_category_product')->where('category_startus','1')->orderBy('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_startus','1')->orderBy('brand_id','desc')->get();
            Cart::destroy();
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product);

        }else{
            echo 'Thanh to??n b??ng th??? ghi n???';
        }

    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('tbl_order') 
        -> join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->select('tbl_order.*','tbl_customer.customer_name')
        ->orderBy('tbl_order.order_id','desc')->get();
        $manager_order = view('admin.manage') -> with('all_order',$all_order);
         return view('admin_layout')-> with('admin.manage',$manager_order);

    }

    public function view_order($order_id){
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order') 
        -> join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        -> join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        -> join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->first();
        $manager_order_by_id = view('admin.view_order') -> with('order_by_id', $order_by_id);
         return view('admin_layout')-> with('admin.view_order',$manager_order_by_id);
        

    }
}

