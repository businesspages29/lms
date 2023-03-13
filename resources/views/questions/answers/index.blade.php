@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <h3>Questions</h3>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('questions.index') }}"> Back</a>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card p-3 mt-2">
            <div>
                <b>Content: </b> {{ $question->content }}
            </div>
            <div>
                <b>Timer: </b> {{ $question->timer }}
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2 mb-2">
            <div>
                <a class="btn btn-success" href="{{ route('answers.create', $question->id) }}"> Create Answer</a>
            </div>
        </div>
        <div class="card p-3 mt-2">
            <table class="table table-bordered w-100" id="datatable-crud">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Content</th>
                        <th>Correct</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('answers.index', $question->id) }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'content',
                        name: 'content'
                    },
                    {
                        data: 'is_correct',
                        name: 'is_correct'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
            $('body').on('click', '.delete', function() {
                if (confirm("Delete Record?") == true) {
                    var id = $(this).data('id');
                    // ajax
                    $.ajax({
                        type: "POST",
                        url: "{{ url('delete-answer') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#datatable-crud').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }
            });
        });
    </script>
@endpush
