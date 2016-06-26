<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Auth;
use Mail;
use PDF;
use App;
use Input;

class EneaMail extends Model
{
	
   public static function order_confirmation($order_id)
   {
    	
    	$sender = Auth::user()->options->brand_in_use->name;
		$sender_mail = 'no-reply@eneaweb.com';
		$cc = Auth::user()->options->brand_in_use->confirmation_email;
		$reply_to = Auth::user()->options->brand_in_use->confirmation_email;
    	
    	$order = \App\Order::find($order_id);
    	$customer = \App\Customer::find($order->customer_id);
      
		if ($order->customer_delivery_id == 0)
			$customer_delivery = $order->customer;
		else
			$customer_delivery = \App\CustomerDelivery::find($order->customer_delivery_id);
		$order_details = \App\OrderDetail::where('order_id', $order->id)->get();
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);

      $pdf = PDF::loadView('pdf.order_confirmation', compact('order', 'brand', 'order_details', 'customer_delivery'));
      
      // INVIO AL CLIENTE
		$data = [
		   'title' => trans('messages.New Order').' #'.$order->id,
		   'content' => trans('messages.Dear').' '.$customer->companyname.',<br><br>'.
		                  trans('messages.As attached you can find a copy of your Order').' '.
		                  Auth::user()->options->brand_in_use->name.' #'.
		                  $order->id,
			]; 
		Mail::send('email.order_confirmation', $data, function($message) use ($data, $order, $sender_mail, $customer, $cc, $reply_to, $brand, $pdf)
		{
			$message->subject(Auth::user()->options->brand_in_use->name.' - '.trans('messages.New Order'));
			$message->attachData($pdf->output(), trans('messages.Order').' '.$brand->name.' #'.$order->id.'.pdf');
			$message->from($sender_mail);
			$message->to($customer->email);
			$message->bcc($cc);
			$message->bcc(Auth::user()->email);
			$message->replyTo($reply_to);
		});
		
		return true;      
   }

}
