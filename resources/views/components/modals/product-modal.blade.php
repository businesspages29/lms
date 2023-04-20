<x-right-side-modal title="Add Product" target="addProductModal" action="product" id="productForm">
    <x-slot name="body">
        <x-forms.text-field label="Name" name="name" value="{{ !empty($user->name) ? $user->name : old('name') }}" />
        <x-forms.text-field label="Description" name="description"
            value="{{ !empty($user->description) ? $user->description : old('description') }}" />
        <x-forms.text-field type="file" label="Image" name="image"
            value="{{ !empty($user->image) ? $user->image : old('image') }}" />
        <input type="hidden" name="category_id" value="{{ request()->get('category_id') }}">
        <div class="col-xs-12 col-sm-12 col-md-12 ">
            <div class="variant-list">
            </div>
            <a class="text-secondary"data-bs-toggle="modal"
                data-bs-target="#addProductVariantModal">{{ __('+ Add Variant') }}</a>

        </div>
    </x-slot>
    <x-slot name="footer">
        <button id="addProductModalClose" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button id="addProductModalSubmit" type="button" class="btn btn-primary">Save changes</button>
    </x-slot>
    @push('js')
        <script type="text/javascript">
            $("#addProductModalSubmit").click(function(e) {
                e.preventDefault();
                // var form = $('#productForm').serializeArray()
                var form = $('#productForm');
                var formData = new FormData(form[0]);
                formData.append('image', $('input[type=file]')[0].files[0]);
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ajaxProduct') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $("#productForm").trigger('reset');
                    }
                });
            });
            $("#addProductModalSubmit").click(function(e) {
                e.preventDefault();
                $("#productForm").trigger('reset');
            });
        </script>
    @endpush
</x-right-side-modal>
