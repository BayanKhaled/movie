@section('css')
<link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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


		{{ Form::open(array('url' =>  '/control/actors/'.$actor->id, 'method' => 'put', 'files' => true)) }}

			<div class="form-group row">
			{{ Form::label('name', 'Name', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			{{ Form::text('name',$value = $actor->name, ['class' => 'form-control'])  }}
			</div>
			</div>

			<div class="form-group row">
			{{ Form::label('description', 'Description', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			{!! Form::textarea('description',$value =$actor->description,['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
			</div>
			</div>

			<div class="form-group row">
			{{ Form::label('icon_path', 'Icon', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
				{{  Form::file('icon_path',['class'=>'form-control', 'rows' => 2, 'cols' => 40])  }}
				@if($icon->count())
					<div class="col-sm-2">
			    	<a href="{{ $icon[0]->path }}" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">
					<img src="{{ $icon[0]->path }}" class="img-fluid mb-2" alt="white sample"/>
					</a>
					<form action="{{ url('/control/photos/') . '/' . $icon[0]->id }}" method="POST">
		            <input type="hidden" name="_method" value="delete">
		            {!! csrf_field() !!}
		            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i></button>
		            </form>
					</div>
				@endif
			</div>
			
			</div>

			<div class="form-group row">
			{{ Form::label('role', 'Role', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			{!! Form::text('role',$value =$actor->role,['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
			</div>
			</div>	

			<div class="form-group row">
			{{ Form::label('country', 'Country', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			{!! Form::text('country',$value =$actor->country,['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
			</div>
			</div>

			<div class="form-group row">
			{{ Form::label('DateOfBirth', 'Date Of Birth', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			<div class="input-group">
			{!! Form::date('DateOfBirth',$value =$actor->DateOfBirth,['class'=>'form-control datetimepicker-input', 'rows' => 2, 'cols' => 40, 'data-target'=>"#reservationdate"]) !!}
	        </div>
			</div>
			</div>


			

			<div class="form-group row">
				{{ Form::label('photos', 'Photos', ['class' => 'col-sm-2 col-form-label'])  }}
				{{  Form::file('photos[]',['multiple' => 'multiple'],['class'=>'form-control', 'rows' => 2, 'cols' => 40])  }}
				<div class="col-sm-10">
					<div class="card card-primary">
					  <div class="card-header">
					    <div class="card-title">
					      Ekko Lightbox
					    </div>
					  </div>
					  <div class="card-body">
					    <div class="row">
					    </div>
					  </div>
					</div>
				</div>
			</div>

			<div class="form-group row">
				{{ Form::submit('save' , array('class' => 'btn btn-info'))  }}
			</div>

		{{ Form::close() }}	
 
	</div> 
</div> 
</div>
</div>
@endsection
@include('control.layout.body')
@push('js')
<script src="{{ url('/') }}/AdminLTE/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ url('/') }}/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
$('.select2').select2({
      theme: 'bootstrap4'
    })
$('.select3').select2()
function goBack() {
  window.history.back();
}
</script>
@endpush
@include('control.layout.footer')

