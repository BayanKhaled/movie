@section('css')
<!-- Select2 -->
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
        <h3 class="card-title">DataTable For Episodes</h3>
    </div>
    <div class="card-body">
    @if ($errors->all())
	<div class="alert alert-danger">
	@foreach($errors->all() as $error)
	  <li>{{ $error }}</li>
	@endforeach
	</div>
	@endif

	{{ Form::open(array('url' => '/control/episodes', 'method' => 'POST')) }}

		<div class="form-group row">
		{{ Form::label('title', 'Title', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		{{ Form::text('title',$value = null, ['class' => 'form-control'])  }}
		</div>
		</div>

		<div class="form-group row">
		{{ Form::label('summary', 'Summary', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		{{ Form::text('summary',$value = null, ['class' => 'form-control'])  }}
		</div>
		</div>

		<div class="form-group row">
		{{ Form::label('duration', 'Duration', ['class' => 'col-sm-2 col-form-label'])  }}
		<div class="col-sm-10">
		{{ Form::text('duration',$value = null, ['class' => 'form-control'])  }}
		</div>
		</div>

		<div class="form-group row">
	      	{{ Form::label('series_id', 'Series', ['class' => 'col-sm-2 col-form-label'])  }}
	    <div class="col-sm-10">
			{{ Form::select('series_id', App\Models\Series::pluck('title', 'id'),$value = null, ['class' => 'form-control', 'id' => 'series'])  }}
	    </div>
		</div>

		<div class="form-group row">
	      	{{ Form::label('season_id', 'Seasons', ['class' => 'col-sm-2 col-form-label'])  }}
	    <div class="col-sm-10">
	    	{{ Form::select('season_id',array() ,null,['class' => 'form-control', 'id' => 'seasons'])  }}

	    </div>
		</div>


		<div class="form-group d-flex justify-content-center">
		{{ Form::submit('Save' ,array('class' => 'btn btn-info '))  }}
		{{ Form::button('Cancel' ,array('class' => 'btn btn-default', 'onclick' => "window.location.href='" . url('control/episodes') . "'"))  }}
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
<script src="{{ url('/') }}/AdminLTE/dist/js/adminlte.min.js"></script>
<script>
$('.select2').select2({
      theme: 'bootstrap4'
    })
$('.select3').select2()



$('#series').change(function(){
	var Series = $('#series').val();
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
    $.ajax({
        url: "/control/getSeasons/" + Series,
        dataType:"json",
        type: "post",
        success: function(data){
        	
        	var output = '';
        	if (data.length > 0){
        		for (i in data){
					console.log(data[i].id);
					console.log(data[i].summary);
					output += '<option value="'+ data[i].id +'">' + data[i].summary + '</option>';

				}

				$('#seasons').html(output);
        	}else {
	        	output += '<option value="'+ data[Series].id +'">' + data[Series].summary + '</option>';
	        	$('#seasons').html(output);
        	}
        }
    });
});
</script>
@endpush
@include('control.layout.footer')

