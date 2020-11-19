@section('css')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">

<!-- 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">-->
<link rel="stylesheet" href="{{asset('css/editor.bootstrap.css')}}"> 
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.4/css/select.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endsection
@include('control.layout.header')
@include('control.layout.nav')
@include('control.layout.menu')


@section('content')
<div class="container">
</div>
<!-- {!! $dataTable->table(['class' => 'table table-bordered table-striped dataTable dtr-inline', 'id' => 'actors']) !!} -->
<div class="card">
	<div class="card-header">
		<h3 class="card-title">DataTable For Actors</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
<!-- {{$dataTable->table(['class' => 'table table-bordered table-striped dataTable dtr-inline', 'id' => 'actors'])}}	 -->
{!! $dataTable->table(['id' => 'actors']) !!}

	</div> 
</div> 
@endsection
@include('control.layout.body')


@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script>
<script src="{{asset('js/dataTables.editor.js')}}"></script>
<!-- <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> -->
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.bootstrap.min.js"></script>
<script src="{{asset('js/editor.bootstrap.min.js')}}"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/vendor/datatables/buttons.server-side.js')}}"></script> 
<script>
	$(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });

        var editor = new $.fn.dataTable.Editor({
            ajax: "/control/actors",
            table: "#actors",
            display: "bootstrap",
            fields: [
                // {label: "Id:", name: "id"},
                {label: "Bame:", name: "name"},
                {label: "Description:", name: "description"},
            ]
        });


        {{-- $('#actors').on('click', 'tbody td:not(:first-child)', function (e) {
            editor.inline(this);
        });    --}}

        {{$dataTable->generateScripts()}}
    })
</script>

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/vendor/datatables/buttons.server-side.js')}}"></script> -->
{{ $dataTable->scripts() }}
<!-- {!! $dataTable->scripts() !!} -->
@endpush
@include('control.layout.footer')

