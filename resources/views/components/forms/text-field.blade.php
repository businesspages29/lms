<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>{{ $label }}:</strong>
        <input @if (!empty($type)) type="{{ $type }}"
        @else    
        type="text" @endif
            name="{{ $name }}" class="form-control" placeholder="{{ $label }}"
            @if (!empty($value)) value="{{ $value }}" @endif>
        @error($name)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
