@section('css')

@endsection
@include('control.layout.header')
@include('control.layout.nav')
@include('control.layout.menu')


@section('content')
<div class="container">
<div class="col-lg-14">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DataTable For Actors</h3>
    </div>
    <div class="card-body">
        <form action="{{ url('/control/photos/2') }}" method="POST">
        <input type="hidden" name="_method" value="delete">
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i></button>
        </form>
    </div> 
</div> 
</div> 
</div>
@endsection
@include('control.layout.body')


@push('js')
@endpush
@include('control.layout.footer')

