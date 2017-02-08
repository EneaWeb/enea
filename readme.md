## ABOUT

## SDK

### The "X" Helper

Class <code>X</code> is the main Helper. Quite everything can be done with the <b>X</b> class.<br>
<code>App\X::class</code> is registered as <code>X</code> alias.<br><br>
Don't forget to import the <b>X</b> class in your Model/Controller with the synthax:
```PHP
use X;
```

### Season

Season delivery dates for current season:
```PHP
X::seasonDeliveryDates()
```

### Customers

All customers:
```PHP
X::customers();
```

All customers registered for Brand in use:
```PHP
X::brandInUseCustomers();
```

### Users

All customers:
```PHP
X::users();
```

### SHOPPING CART

#### Creating / Editing orders

Add an item to the cart get parameters: <b>ID</b> (string), <b>Name</b> (string), <b>Qty</b> (int), <b>Price</b> (float).
```PHP
Cart::instance('agent')->add( '34', 'Product X', 2, 25.99 );
```

Get cart content:
```PHP
Cart::instance('agent')->content();
```

Get cart total:
```PHP
Cart::instance('agent')->total();
```

Destroy cart:
```PHP
Cart::destroy();
```

Check if Item ID is in cart
```PHP
// returns TRUE or FALSE
X::cartHasItem($itemId, $instance='agent');
```

Get Cart content row by Item ID
```PHP
// returns Cart content row object or NULL
X::cartGetItem($itemId, $instance='agent');
```

Cart options are stored as array in <b>cart.options</b>. You can save to session single option or an array with multiple options:
```PHP
\App\Order::setOptions( 'price_list_id', 2 );
\App\Order::setOptions( [ 'price_list_id' => 2, 'season_delivery_id' => 3 ] );
```

Apply all session options to an Order instance:
```PHP
$order->saveOptions();
```

## STRINGS

Method <code>formatPrice($float, $position='after')</code> formats prices for ITA with EUR symbol. Example:
X::prettyPrice(25,366.25, 'before'); // renders "€ 25.366,25"

## PICTURES

This app uses Amazon AWS S3 as storage filesystem for pictures and documents.<br>
Each product picture is stored inside a <b>brand</b> named folder following this tructure:

```bash
/___ users/
|
|___ brands/
|
|___ products/
    |
    |___ {brandName}/
        |
        |___ 400/
        |    |
        |    |_ {400x400_thumb}
        |    |_ {400x400_thumb}
        |    |_ {400x400_thumb}
        |    |_ ....
        |
        |_ {2000x2000_picture}
        |_ {2000x2000_picture}
        |_ {2000x2000_picture} 
        |_ ....
```

Generate HTML <code>\<img\></code> element with S3 url is pretty simple with the <code>X</code> helper and blade synthax:

```blade
<!-- get full size picture -->
<img src="{{ X::s3_products( $product->featuredPicture() ) }}" />

<!-- get thumbnail picture -->
<img src="{{ X::s3_products_thumb( $product->featuredPicture() ) }}" /> 
```

## LICENSE

...

