<?php

namespace App;
use Auth;
use Storage;
use Cart;
use Session;

class X
{
        
    public static function activeSeason()
    {
        return \App\Option::getOption('active_season');
    }

    public static function typeInUseSlug()
    {
        return Auth::user()->options->type_in_use->slug;
    }

    public static function users()
    {
        return \App\User::all();
    }

    public static function customers()
    {
        return \App\Customer::all();
    }

    public static function brandInUseSlug()
    {
        return Auth::user()->options->brand_in_use->slug;
    }

    public static function brandInUseId()
    {
        return Auth::user()->options->brand_in_use->id;
    }

    public static function brandInUse()
    {
        return Auth::user()->options->brand_in_use;
    }

    public static function brandInUseCustomers()
    {
        return Auth::user()->options->brand_in_use->customers;
    }

    public static function seasonDeliveryDates()
    {
        return \App\SeasonDelivery::where('season_id', \App\Option::getOption('active_season'))->where('active', '1')->get();
    }

    public static function paymentMethods()
    {
        return \App\Payment::where('active', '1')->get();
    }

    public static function brandInUseName()
    {
        return Auth::user()->options->brand_in_use->name;
    }

    public static function thisSeasonOrders()
    {
        return \App\Order::where('season_id', \App\X::activeSeason())->get();
    }

    public static function rangeNumbers($csv)
    {
        // split string using the , character
        $number_array = array_map('intval', array_unique($csv));
        sort($number_array);

        // Loop through array and build range string
        $previous_number = intval(array_shift($number_array)); 
        $range = false;
        $range_string = "" . $previous_number; 
        foreach ($number_array as $number) {
            $number = intval($number);
            if ($number == $previous_number + 1) {
            $range = true;
            }
            else {
            if ($range) {
                $range_string .= " - $previous_number";
                $range = false;
            }
            $range_string .= ", $number";
            }
            $previous_number = $number;
        }
        if ($range) {
            $range_string .= " - $previous_number";
        }

        return $range_string;
    }

    public static function arrayCartesianProduct($arrays)
    {
        $result = array();
        $arrays = array_values($arrays);
        $sizeIn = sizeof($arrays);
        $size = $sizeIn > 0 ? 1 : 0;
        foreach ($arrays as $array)
            $size = $size * sizeof($array);
        for ($i = 0; $i < $size; $i ++)
        {
            $result[$i] = array();
            for ($j = 0; $j < $sizeIn; $j ++)
                array_push($result[$i], current($arrays[$j]));
            for ($j = ($sizeIn -1); $j >= 0; $j --)
            {
                if (next($arrays[$j]))
                    break;
                elseif (isset ($arrays[$j]))
                    reset($arrays[$j]);
            }
        }
        return $result;
    }

    public static function s3_products($fileName)
    {
        //return Storage::disk('s3')->url('products/'.\App\X::brandInUseSlug().'/'.$fileName);
        return 'http://s3.eu-central-1.amazonaws.com/enea-gestionale/products/'.Auth::user()->options->brand_in_use->slug.'/'.$fileName;
    }

    public static function s3_products_thumb($fileName)
    {
        //return Storage::disk('s3')->url('products/'.\App\X::brandInUseSlug().'/400/'.$fileName);
        return 'http://s3.eu-central-1.amazonaws.com/enea-gestionale/products/'.Auth::user()->options->brand_in_use->slug.'/400/'.$fileName;
    }

    public static function cartHasItem($itemId, $instance='agent')
    {
        $x = Cart::instance($instance)->search(function ($cartItem, $rowId) use ($itemId) {
            return $cartItem->id === $itemId;
        });
        return !$x->isEmpty();
    }

    public static function cartGetItem($itemId, $instance='agent')
    {
        $x = Cart::instance($instance)->search(function ($cartItem, $rowId) use ($itemId) {
            return $cartItem->id === $itemId;
        })->first();
        return $x;
    }

    public static function addToCart($itemId, $qty)
    {
        // get Item instance
        $item = \App\Item::find($itemId);
        // get Price for Order selected price list
        $itemPrice = $item->priceForOrderList();
        // check if Item ID is already in any Cart line

        // if it's a cart UPDATE
        if (X::cartHasItem($itemId)) {
            // get rowId
            $rowId = X::cartGetItem($itemId)->rowId;
            // if the new qty is 0, need to delete the row
            if ($qty == NULL || $qty == 0 || $qty == '' || $qty == "0") {
                Cart::instance('agent')->remove($rowId);
            // if the new qty is > 0, need to update the row
            } else {
                Cart::instance('agent')->update($rowId, $qty);
            }
        // if it's a cart ADD
        } else {
            if ($qty !== NULL && $qty !== 0 && $qty !== '' && $qty !== "0") {
                Cart::instance('agent')->add( $itemId, 'Item #'.$itemId, $qty, $itemPrice );
            }
        }
        return true;
    }

    public static function cartRefreshPrices($price_list_id)
    {
        foreach (Cart::instance('agent')->content() as $row) {
            // get item instance
            $item = \App\Item::find($row->id);
            // get correct price for this ID
            $itemPrice = $item->priceForList($price_list_id);
            // update row
            Cart::instance('agent')->update($row->rowId, ['price' => $itemPrice] );
        }
        return true;
    }

    public static function isOrderInProgress()
    {
        return Session::has('cart');
    }

    public static function prettyPrice($price, $position='after')
    {
        if ($position == 'after')
            return number_format($price, 2, ',','.').' €';
        else
            return '€ '.number_format($price, 2, ',','.');
    }

    public static function priceFormat($price)
    {
        return number_format($price, 2, ',','.');
    }

    public static function calculateTotal($action, $amount, $subtotal)
    {
        switch ($action) {
            case '' : // if there is no discount or increase
                return $subtotal; // return subtotal as it is
                break;
            case '-' : // if there is a discount
                return ($subtotal - ( $subtotal/100*$amount ) ); // return discounted price
                break;
            case '+' : // if there is an increase
                return ($subtotal + ( $subtotal/100*$amount ) ); // return increased price
                break;
            default : // by default return no discount or increase
                return $subtotal; // so return subtotal as it is
                break;
        }  
    }

}
