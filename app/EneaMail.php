<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use \App\User;
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
   
   public static function user_linked_to_network($user_id, $active_brand, $custom_message)
   {
    	$sender = Auth::user()->options->brand_in_use->name;
		$sender_mail = 'no-reply@eneaweb.com';
		$reply_to = Auth::user()->options->brand_in_use->confirmation_email;
    	$user_to_link = \App\User::find($user_id);
    	$user = Auth::user();
    	$brand = \App\Brand::find($active_brand);

      // INVIO ALL'UTENTE
		$data = [
		   'title' => trans('messages.Join the network'),
		   'content' => trans('messages.Dear').' '.$user_to_link->companyname.',<br><br>'.
		                  $user->companyname.' '.trans('messages.requested your join to the network').' '.
		                  $brand->name.'.<br><br>'.
		                  trans('messages.From now on you will able to select the network just clicking on the brand name on top-right').'.<br>'.
		                  '<hr>'.$custom_message.'<hr>',
			]; 
		Mail::send('email.order_confirmation', $data, function($message) use ($data, $user, $brand, $custom_message, $user_to_link, $sender_mail, $reply_to)
		{
			$message->subject(trans('messages.Join the network').' - '.$brand->name);
			$message->from($sender_mail);
			$message->to($user_to_link->email);
			$message->replyTo($reply_to);
		});
		
		return true; 
   }
   
   public static function user_invited_to_register( User $new_user, $active_brand, $custom_message)
   {
    	$sender = Auth::user()->options->brand_in_use->name;
		$sender_mail = 'no-reply@eneaweb.com';
		$reply_to = Auth::user()->options->brand_in_use->confirmation_email;
    	$user = Auth::user();
    	$brand = \App\Brand::find($active_brand);

      // INVIO ALL'UTENTE
		$data = [
		   'title' => trans('messages.Join the network'),
		   'content' => trans('messages.Dear').' '.$new_user->companyname.',<br><br>'.
		                  $user->companyname.' '.trans('messages.requested your join to the network').' '.
		                  $brand->name.'.<br><br>'.
		                  trans('messages.In order to activate your account, you will need to login and change your personal informations').'.<br><br>'.
		                  'Activation Link: <i><a href="http://ordini.eneaweb.com/registration/confirm?usr='.$new_user->username.'&pas=provvisoria">http://ordini.eneaweb.com/registration/new?usr='.$new_user->username.'&pas=provvisoria</a></i><br>'.
		                  'Username: <i>'.$new_user->username.'</i><br>'.
		                  'Password: <i>provvisoria</i><br><br>'.
		                  '<hr>'.$custom_message.'<hr>',
			]; 
		Mail::send('email.order_confirmation', $data, function($message) use ($data, $user, $new_user, $brand, $custom_message, $sender_mail, $reply_to)
		{
			$message->subject(trans('messages.Join the network').' - '.$brand->name);
			$message->from($sender_mail);
			$message->to($new_user->email);
			$message->replyTo($reply_to);
		});
		
		return true; 
   }

}
