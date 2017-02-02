<select id="variations" class="form-control select2-multiple" multiple>
    @foreach(\App\Attribute::all() as $attribute)
        <optgroup label="{!!$attribute->name!!}">
        @foreach ($attribute->terms as $term)
            <option value="{!!$term->id!!}" data-attribute="{!!$term->attribute->id!!}">{!!$term->name!!}</option>
        @endforeach
        </optgroup>
    @endforeach
</select>