<x-right-side-modal title="Add Category" target="addCategoryModal" action="category" id="categoryForm">
    <x-slot name="body">
        <x-forms.text-field label="Name" name="name" value="{{ !empty($user->name) ? $user->name : old('name') }}" />
        <x-forms.select-field label="Parent" name="parent_id" :options="$parentCategories"
            value="{{ !empty($user->parent_id) ? $user->parent_id : old('parent_id') }}" />
    </x-slot>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button id="addCategoryModalSubmit" type="button" class="btn btn-primary">Save changes</button>

    </x-slot>
    @push('js')
        <script type="text/javascript">
            $("#addCategoryModalSubmit").click(function(e) {
                e.preventDefault();
                console.log("here");
                var form = $('#categoryForm').serializeArray()
                $.ajax({
                    type: 'POST',
                    url: "{{ route('ajaxCategory') }}",
                    data: form,
                    success: function(data) {
                        alert(data.success);
                    }
                });
            });
        </script>
    @endpush
</x-right-side-modal>
