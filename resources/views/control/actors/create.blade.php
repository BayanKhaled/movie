@section('css')
<link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- <script src="{{ url('/') }}/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->

<!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.css">
@endsection
@include('control.layout.header')
@include('control.layout.nav')
@include('control.layout.menu')


@section('content')
<div class="container "  align="center">
<div class="col-lg-8 " >
<div class="card text-left">
    <div class="card-header">
        <h3 class="card-title">DataTable For Actors</h3>
    </div>
    <div class="card-body">
    @if ($errors->all())
	<div class="alert alert-danger">
	@foreach($errors->all() as $error)
	  <li>{{ $error }}</li>
	@endforeach
	</div>
	@endif

	{{ Form::open(array('url' => '/control/actors', 'method' => 'POST', 'files' => true)) }}

		<div class="form-group row">
		{{ Form::label('name', 'Name', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		{{ Form::text('name',$value = null, ['class' => 'form-control'])  }}
		</div>
		</div>

		<div class="form-group row">
		{{ Form::label('description', 'Description', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		{!! Form::textarea('description',$value =null,['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
		</div>
		</div>

		<div class="form-group row">
		{{ Form::label('icon_path', 'Icon', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		{{  Form::file('icon_path',['class'=>'form-control', 'rows' => 2, 'cols' => 40])  }}
		</div>
		</div>

		<div class="form-group row">
		{{ Form::label('role', 'Role', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		{!! Form::text('role',$value =null,['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
		</div>
		</div>	

		<div class="form-group row">
		{{ Form::label('country', 'Country', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		{!! Form::text('country',$value =null,['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
		</div>
		</div>

		<div class="form-group row">
		{{ Form::label('DateOfBirth', 'Date Of Birth', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		<div class="input-group">
		{!! Form::date('DateOfBirth',$value =null,['class'=>'form-control datetimepicker-input', 'rows' => 2, 'cols' => 40, 'data-target'=>"#reservationdate"]) !!}
        </div>
		</div>
		</div>


		<div class="form-group row">
			{{ Form::label('photos', 'Photos', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			<div class="input-group">
			{{  Form::file('photos[]',['multiple' => 'multiple'],['class'=>'form-control', 'rows' => 2, 'cols' => 40])  }}
			</div>
			</div>
		</div>

		<div class="form-group d-flex justify-content-center">
		{{ Form::submit('Save' ,array('class' => 'btn btn-info '))  }}
		{{ Form::button('Cancel' ,array('class' => 'btn btn-default', 'onclick' => "window.location.href='" . url('control/actors') . "'"))  }}
		</div>
	{{ Form::close() }}		

 
    </div> 


</div> 
</div> 
</div>
@endsection
@include('control.layout.body')
@push('js')
<!-- Ekko Lightbox -->
<script src="{{ url('/') }}/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<script src="{{ url('/') }}/AdminLTE/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ url('/') }}/AdminLTE/dist/js/adminlte.min.js"></script>
<script src="{{ url('/') }}/AdminLTE/plugins/filterizr/jquery.filterizr.min.js"></script>
<script>
$(function () {
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
  event.preventDefault();
  $(this).ekkoLightbox({
    alwaysShowClose: true
  });
});

$('.filter-container').filterizr({gutterPixels: 3});
$('.btn[data-filter]').on('click', function() {
  $('.btn[data-filter]').removeClass('active');
  $(this).addClass('active');
});
})

$('.select2').select2({
      theme: 'bootstrap4'
    })
$('.select3').select2()
function goBack() {
  window.history.back();
}

@endpush
@include('control.layout.footer')

