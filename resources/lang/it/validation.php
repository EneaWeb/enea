<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'Please Confirm' => 'Conferma',
    'Are you sure you want to unlink the user from your brand?' => 'Sei sicuro di volere scollegare questo utente dal tuo brand?',
    'Are you sure you want to delete this date?' => 'Sei sicuro di volere rimuovere questa data?',
    'Are you sure you want to delete this price list?' => 'Sei sicuro di volere rimuovere questo listino?',
    'Are you sure you want to delete this payment option?' => 'Sei sicuro di volere rimuovere questa opzione di pagamento?',
    
    'required-attribute-name' => 'Il campo Nome Attributo è obbligatorio',
    'required-attribute-slug' => 'Il campo Codice Attributo è obbligatorio',
    'required-attribute-value-name' => 'Il campo Nome Valore Attributo è obbligatorio',
    'required-attribute-value-slug' => 'Il campo Codice Valore Attributo è obbligatorio',
    'required-option-name' => 'Il Nome Opzione è obbligatorio',
    'required-option-value' => 'Il Valore Opzione è obbligatorio',
    'required-season_delivery-season_id' => 'Season_id is required',
    'required-season_delivery-name' => 'Il Nome della consegna è obbligatorio',
    'required-season_list-season_id' => 'Season_id is required',
    'required-season_list-name' => 'Il nome del Listino è obbligatorio',
    'required-payment-name' => 'Il nome della condizione di pagamento è obbligatorio',
    'required-customer-companyname' => 'Ragione Sociale è obbligatoria',
    'required-customer-name' => 'Nome è obbligatorio',
    'required-customer-surname' => 'Cognome è obbligatorio',
    'required-customer-address' => 'Indirizzo è obbligatorio',
    'required-customer-telephone' => 'Telefono è obbligatorio',
    'required-customer-email' => 'Email è obbligatoria',
    
    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
