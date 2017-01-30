@extends('layout.main')

@section('content')

<div class="page-content-container">
	<div class="page-content-row">

        {{-- Start changelog --}}
        <strong>2017.02.01 Ver. 2.0a</strong><br><br>
        <ul>
            <li>Added 'attributes' and 'terms' models, opening to any possible product variation</li>
            <li>Primary key for sizes is now a varchar slug value (es. 14 or xxl)</li>
            <li>Created an unique file per language (x.php) for faster translations</li>
            <li>Brand new graphical User Interface</li>
            <li>Admins have some new stats in Dashboard page</li>
        </ul>
        <br><br>

	</div>
</div>


@stop