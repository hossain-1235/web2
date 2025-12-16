<?php
      
namespace App\Http\Controllers;
       
use Illuminate\Http\Request;
use Stripe;
use Illuminate\View\View;
use App\Models\Order;
use App\Models\StripeOrder;
use App\Models\OrderProduct;
use App\Models\Inventory;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
       
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe($id): View
    {
        $total = StripeOrder::where('order_id', $id)->first()->total;
        return view('stripe', [
            'order_id'=>$id,
            'total'=>$total,
        ]);
    }
      
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request, $order_id): RedirectResponse
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $total = StripeOrder::where('order_id', $order_id)->first()->total;
        $stripe_order =  StripeOrder::where('order_id', $order_id)->first();
        Stripe\Charge::create ([
                "amount" => $total * 100,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);

         Order::insert([
                'order_id' => $order_id,
                'customer_id'=>Auth::guard('customer')->id(),
                'total'=> $stripe_order->total,
                'discount'=> $stripe_order->discount,
                'payment_method'=> $stripe_order->payment_method,
                'charge'=> $stripe_order->charge,
                'name'=> $stripe_order->name,
                'email'=> $stripe_order->email,
                'phone'=> $stripe_order->phone,
                'address'=> $stripe_order->address,
                'country_id'=> $stripe_order->country_id,
                'city_id'=> $stripe_order->city_id,
                'zip'=> $stripe_order->zip,
                'company'=> $stripe_order->company,
                'additional'=> $stripe_order->additional,
                'created_at'=> Carbon::now(),
            ]);

            $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();

            foreach($carts as $cart){
                OrderProduct::insert([
                    'order_id'=>$order_id,
                    'customer_id'=>Auth::guard('customer')->id(),
                    'product_id'=>$cart->product_id,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'price'=>Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->first()->discount_price,
                    'quantity'=>$cart->quantity,
                    'created_at'=> Carbon::now(),
                ]);

                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
            }

            Cart::where('customer_id', Auth::guard('customer')->id())->delete();

            //mail
            Mail::to($stripe_order->email)->send(new InvoiceMail($order_id));

            //sms
            $url = "http://bulksmsbd.net/api/smsapi";
            $api_key = "3rBFl5rfIJQuRA6XN7Yw";
            $senderid = "8809617630868";
            $number = $stripe_order->phone;
            $message = "We have received your order";
        
            $data = [
                "api_key" => $api_key,
                "senderid" => $senderid,
                "number" => $number,
                "message" => $message
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);

                
       return redirect()->route('order.success', $order_id);
    }
}