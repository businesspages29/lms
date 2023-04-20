<x-right-side-modal title="Add Product Variant" target="addProductVariantModal" action="product-variant"
    id="productVariantForm">
    <x-slot name="body">
        <x-forms.text-field label="Name" name="name" value="{{ !empty($user->name) ? $user->name : old('name') }}" />
        <x-forms.text-field label="Price" name="price"
            value="{{ !empty($user->price) ? $user->price : old('price') }}" />
        <x-forms.text-field label="Offer Price" name="offer_price"
            value="{{ !empty($user->offer_price) ? $user->offer_price : old('offer_price') }}" />
    </x-slot>
    <x-slot name="footer">
        <button class="btn btn-secondary" data-bs-target="#addProductModal" data-bs-toggle="modal"
            data-bs-dismiss="modal">Close</button>
        <button id="addProductVariantModalSubmit" class="btn btn-primary" data-bs-target="#addProductModal"
            data-bs-toggle="modal" data-bs-dismiss="modal">Save changes</button>
    </x-slot>
    @push('js')
        <script type="text/javascript">
            $("#addProductVariantModalSubmit").click(function(e) {
                e.preventDefault();
                var form = $('#productVariantForm').serializeArray()
                var name = form[1].value;
                var price = form[2].value;
                var offerPrice = form[3].value;
                console.log(form[1].value);
                var html = '<div class="card mt-2">' +
                    '<input type="hidden" name="variant[name][]" value="' + name + '">' +
                    '<input type="hidden" name="variant[price][]" value="' + price + '">' +
                    '<input type="hidden" name="variant[offer_price][]" value="' + offerPrice + '">' +
                    '<div class="card-body d-flex justify-content-between">' +
                    '<div>' + name + '</div>' +
                    '<div class="d-flex justify-content-between g-2"><span>Rs. ' + price +
                    '</span><span class="ms-2"><del>Rs. ' + offerPrice +
                    '</del></span></div>' +
                    '</div>' +
                    '</div>';
                $('body').find('.variant-list').append(html);
                $("#productVariantForm").trigger('reset');
            });
        </script>
    @endpush
</x-right-side-modal>
