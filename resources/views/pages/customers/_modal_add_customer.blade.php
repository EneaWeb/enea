<div class="modal animated fadeIn" id="modal_add_customer" tabindex="-1" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" style="display: none;">

    <div class="modal-dialog animated zoomIn">
    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">{!! trans('menu.New Customer') !!}</h4>
            </div>
            <div class="modal-body">

            </div>
            {!!Form::open(array('url' => '/customers/new', 'method'=>'POST', 'id'=>'customer-form'))!!}
            
            <div class="modal-body form-horizontal form-group-separated">  
            
                <br>                      
                <div class="form-group">
                    {!!Form::label('companyname', trans('auth.Company Name').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'companyname', '', ['class'=>'form-control ui-autocomplete-input', 'id'=>'customer-autocomplete'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('sign', trans('auth.Sign').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'sign', '', ['class'=>'form-control ui-autocomplete-input', 'id'=>'sign-autocomplete'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('name', trans('auth.Name').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'name', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('vat', trans('auth.Vat').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'vat', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                        {!!Form::label('address', trans('menu.Address').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">
                        
                        <input id="pac-input" name="address" class="controls" type="text"
                                placeholder="Enter a location">
                            <div id="type-selector" class="controls">
                              <input type="radio" name="type" id="changetype-all" checked="checked">
                              <label for="changetype-all">All</label>

                              <input type="radio" name="type" id="changetype-establishment">
                              <label for="changetype-establishment">Establishments</label>

                              <input type="radio" name="type" id="changetype-address">
                              <label for="changetype-address">Addresses</label>

                              <input type="radio" name="type" id="changetype-geocode">
                              <label for="changetype-geocode">Geocodes</label>
                            </div>
                            <div id="map"></div>

                            <script>
                              // This example requires the Places library. Include the libraries=places
                              // parameter when you first load the API. For example:
                              // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

                              function initMap() {
                                var map = new google.maps.Map(document.getElementById('map'), {
                                  center: {lat: -33.8688, lng: 151.2195},
                                  zoom: 13
                                });
                                var input = /** @type {!HTMLInputElement} */(
                                    document.getElementById('pac-input'));

                                var types = document.getElementById('type-selector');
                                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                                map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

                                var autocomplete = new google.maps.places.Autocomplete(input);
                                autocomplete.bindTo('bounds', map);

                                var infowindow = new google.maps.InfoWindow();
                                var marker = new google.maps.Marker({
                                  map: map,
                                  anchorPoint: new google.maps.Point(0, -29)
                                });

                                autocomplete.addListener('place_changed', function() {
                                  infowindow.close();
                                  marker.setVisible(false);
                                  var place = autocomplete.getPlace();
                                  if (!place.geometry) {
                                    window.alert("Autocomplete's returned place contains no geometry");
                                    return;
                                  }

                                  // If the place has a geometry, then present it on a map.
                                  if (place.geometry.viewport) {
                                    map.fitBounds(place.geometry.viewport);
                                  } else {
                                    map.setCenter(place.geometry.location);
                                    map.setZoom(17);  // Why 17? Because it looks good.
                                  }
                                  marker.setIcon(/** @type {google.maps.Icon} */({
                                    url: place.icon,
                                    size: new google.maps.Size(71, 71),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(17, 34),
                                    scaledSize: new google.maps.Size(35, 35)
                                  }));
                                  marker.setPosition(place.geometry.location);
                                  marker.setVisible(true);

                                  var address = '';
                                  if (place.address_components) {
                                    address = [
                                      (place.address_components[0] && place.address_components[0].short_name || ''),
                                      (place.address_components[1] && place.address_components[1].short_name || ''),
                                      (place.address_components[2] && place.address_components[2].short_name || '')
                                    ].join(' ');
                                  }

                                  infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                                  infowindow.open(map, marker);
                                });

                                // Sets a listener on a radio button to change the filter type on Places
                                // Autocomplete.
                                function setupClickListener(id, types) {
                                  var radioButton = document.getElementById(id);
                                  radioButton.addEventListener('click', function() {
                                    autocomplete.setTypes(types);
                                  });
                                }

                                setupClickListener('changetype-all', []);
                                setupClickListener('changetype-address', ['address']);
                                setupClickListener('changetype-establishment', ['establishment']);
                                setupClickListener('changetype-geocode', ['geocode']);
                              }
                            </script>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg0uwhTd3hEwC10wl4i0PV1cs6paJemH4&libraries=places&callback=initMap"
                                async defer></script>
                        
                        {{-- {!! $autocompleteHelper->renderHtmlContainer($autocomplete) !!} --}}
                        {{-- Google Autocomplete Script --}}
                        {{-- {!! $autocompleteHelper->renderJavascripts($autocomplete) !!} --}}
                        {{-- END Google Autocomplete Script --}}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('telephone', trans('auth.Telephone').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'telephone', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('telephone', trans('auth.Mobile'), ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::input('text', 'mobile', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('email', trans('auth.Email').'*', ['class' => 'col-md-3 control-label'])!!}
                    <div class="col-md-8">   
                        {!!Form::email('email', '', ['class'=>'form-control'])!!}
                    </div>
                </div>
                <br><br><br>
            </div>
            <div class="modal-footer">
                {!!Form::submit(trans('menu.Create'), ['class' => 'btn btn-danger'])!!}
                <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('menu.Close')!!}</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
<script>
// disable ENTER on form
$('#customer-form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
</script>