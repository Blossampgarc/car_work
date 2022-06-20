<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequestCart;
use App\Http\Requests\RequestCheckout;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\car_details;
use App\Models\User;
use App\Models\orders;
use App\Models\order_detail;
use App\Mail\InvoiceMail;
use Mail;
class CartController extends Controller
{
    public function save_cart(RequestCart $request)
    {
        $product_id = $_POST['product_id'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $code = $product_id.'|'.$price;
        $cart = array();
        if (Session::has('cart'))
        {
            $cart = Session::get('cart');
        }
        $cart[$code]['product_id'] = $product_id;
        $cart[$code]['price'] = $price;
        $cart[$code]['quantity'] = $quantity;
        Session::put('cart', $cart);
        // dd($cart);
        $product = car_details::where('is_active',1)->where('id',$product_id)->first();
        $msg ='"'. $product->model.'" has been added to cart';
        return redirect()->back()->with('message',$msg);
    }
    public function remove_cart(Request $request)
    {
        $product_id = $_POST['product_id'];
        $price = $_POST['price'];
        $code = $product_id.'|'.$price;
        if (Session::has('cart'))
        {
            $cart = Session::get('cart');
            Session::forget('cart');
            unset($cart[$code]);
            Session::put('cart', $cart);
            $status['message'] = "Product has been removed from Cart";
            $status['status'] = 1;
            return json_encode($status);
        } else{
            $status['message'] = "Product could not be removed from Cart";
            $status['status'] = 0;
            return json_encode($status);
        }
    }
    public function cart(){
        $cart = array();
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            if ($cart != []) {
                return view('web.cart')->with(compact('cart'));
            }
        }
        return redirect()->route('product')->with('error',"Cart is empty");
    }
    public function checkout(){
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            if ($cart != []) {
                return view('web.checkout')->with(compact('cart'));
            }
        }
        return redirect()->route('product')->with('error',"Cart is empty");
    }
    public function update_cart(Request $request)
    {
        $cart = array();
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $product_id = $_POST['product_id'];
            // dd($cart,$product_id,$quantity,$price);
            foreach ($product_id as $k => $value) {
                $code = $product_id[$k].'|'.$price[$k];
                // dd($code,$cart,$product_id,$quantity,$price);
                $cart[$code]['product_id'] = $value;
                $cart[$code]['quantity'] = $quantity[$k];
                $cart[$code]['price'] = $price[$k];
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message',"Bag has been Updated");
        } else{
            return redirect()->route('product')->with('error',"Cart is empty");
        }
    }
    public function checkout_submit(RequestCheckout $request)
    {
        $cart = array();
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $checkUser = User::where('is_active',1)->where('is_deleted',0)->where('email',$_POST['email'])->first();
            // Create or use existing user
            if ($checkUser) {
                $user_id = $checkUser->id;
            } else{
                $name = $_POST['first_name']." ".$_POST['last_name'];
                $user = User::create([
                    'name'=>$name,
                    'email'=>$_POST['email'],
                    'password'=>Hash::make('12345678')
                ]);
                $user_id = $user->id;
            }
            // Create order
            $orders = orders::create([
                'user_id'=>$user_id,
                'company_name'=>$_POST['company_name'],
                'address'=>$_POST['address'],
                'city'=>$_POST['city'],
                'country'=>$_POST['country'],
                'phone'=>$_POST['phone'],
                'postcode'=>$_POST['postcode'],
                'note'=>$_POST['note']
            ]);
            $total = 0;
            foreach ($cart as $key => $value) {
                $quantity = $value['quantity'];
                $price = $value['price'];
                $amount = $quantity*$price;
                $total = $total + $amount;
                $order_detail = order_detail::create([
                    'order_id'=>$orders->id,
                    'product_id'=>$value['product_id'],
                    'qty'=>$quantity,
                    'price'=>$price,
                    'amount'=>$amount
                ]);
            }
            $update = orders::where("id" , $orders->id)->update([
                'amount_total'=>$total
            ]);
            Session::forget('cart');
            $details = [
                'message' => 'INVOICE MAIL FROM SMART AUTO PARTS',
                'order_id' => $orders->id,
            ];
            $mail = \Mail::to($_POST['email'])->send(new InvoiceMail($details));
            $attempt = Auth::attempt(['email' => $_POST['email'], 'password' => '12345678']);
            return redirect()->route('product')->with('message',"Order has been Placed");
        } else{
            return redirect()->route('product')->with('error',"Cart is empty");
        }
    }
}
