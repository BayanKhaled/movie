@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
        <h3 class="card-title">DataTable For Movies</h3>
    </div>
    <div class="card-body">
	    @if ($errors->all())
		<div class="alert alert-danger">
		@foreach($errors->all() as $error)
		  <li>{{ $error }}</li>
		@endforeach
		</div>
		@endif


		{{ Form::open(array('url' =>  '/control/movies/'.$movies->id, 'method' => 'put', 'files' => true)) }}

			<div class="form-group row">
			{{ Form::label('title', 'Title', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			{{ Form::text('title',$value = $movies->title, ['class' => 'form-control'])  }}
			</div>
			</div>

			<div class="form-group row">
			{{ Form::label('description', 'Description', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			{{ Form::text('description',$value = $movies->description, ['class' => 'form-control'])  }}
			</div>
			</div>

			<div class="form-group row">
			{{ Form::label('release_date', 'Release Date', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			{{ Form::text('release_date',$value = $movies->release_date, ['class' => 'form-control'])  }}
			</div>
			</div>

			<div class="form-group row">
			{{ Form::label('duration', 'Duration', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
			{{ Form::text('duration',$value = $movies->duration, ['class' => 'form-control'])  }}
			</div>
			</div>


			<div class="form-group row">
			{{ Form::label('poster_path', 'Icon', ['class' => 'col-sm-2 col-form-label'])  }}
			<div class="col-sm-10">
				{{  Form::file('poster_path',['class'=>'form-control', 'rows' => 2, 'cols' => 40])  }}

				@if($icon->count())
					<div class="col-sm-2">
			    	<a href="{{ $icon[0]->path }}" data-toggle="lightbox" data-title="{{$movies->title}}" data-gallery="gallery">
					<img src="{{ $icon[0]->path }}" class="img-fluid mb-2" alt="white sample"/>
					</a>
					</div>
					<input type="checkbox" id="master" data-id="{{$icon[0]->id}}">
				@endif
			</div>
			
			</div>

			<div class="form-group row">
	      	{{ Form::label('actors', 'Actors', ['class' => 'col-sm-2 col-form-label'])  }}
		    <div class="col-sm-10">
				{{ Form::select('actors[]', App\Models\Actors::pluck('name', 'id'),
				$actors
				,['multiple'=>'multiple','id'=>'sports3','class' => 'select2 select2-hidden-accessible','data-placeholder' => 'Select a State','style' => 'width: 100%;', 'data-select2-id' => '7', 'aria-hidden' => 'true'])  }}
		    </div>
			</div>

			<div class="form-group row">
	      	{{ Form::label('genres', 'Genres', ['class' => 'col-sm-2 col-form-label'])  }}
		    <div class="col-sm-10">
				{{ Form::select('genres[]', App\Models\Genres::pluck('name', 'id'),
				$genres
				,['multiple'=>'multiple','id'=>'sports2','class' => 'select2 select2-hidden-accessible','data-placeholder' => 'Select a State','style' => 'width: 100%;', 'data-select2-id' => '8', 'aria-hidden' => 'true'])  }}
		    </div>
			</div>

			<div class="form-group row">
		      	{{ Form::label('tags', 'Tags', ['class' => 'col-sm-2 col-form-label'])  }}
		    <div class="col-sm-10">
				{{ Form::select('tags[]', App\Models\Tags::pluck('name', 'id'),
				$tags,
				['multiple'=>'multiple','id'=>'sports1','class' => 'select2 select2-hidden-accessible','data-placeholder' => 'Select a State','style' => 'width: 100%;', 'data-select2-id' => '9', 'aria-hidden' => 'true'])  }}
		    </div>
			</div>

			<div class="form-group row">
				{{ Form::submit('save' , array('class' => 'btn btn-info'))  }}
			</div>

		{{ Form::close() }}	
 
	</div> 
</div> 

	<div class="card text-left card-primary">
    <div class="card-header">
        <h3 class="card-title">Photos For Actor</h3>
    </div>
	<div class="card-body">
		{{ Form::open(array('url' =>  '/control/photos', 'method' => 'put', 'files' => true)) }}

			<input name="id" type="hidden" value="{{$movies->id}}">
			<div class="form-group row">
				{{ Form::label('photos', 'Photos', ['class' => 'col-sm-2 col-form-label'])  }}
				{{  Form::file('photos[]',['multiple' => 'multiple'],['class'=>'form-control', 'rows' => 2, 'cols' => 40])  }}
				<div class="col-sm-10">
			    <div class="form-group row">
						{{ Form::submit('save' , array('class' => 'btn btn-info'))  }}
				</div>
				</div>
			</div>
	    {{ Form::close() }}	
		@if($photos->count())
	    	<div class="row">
	    	@foreach ($photos as $photo)
		    	<div class="col-sm-2">
			    	<a href="{{ $photo->path }}" data-toggle="lightbox" data-title="{{$movies->title}}" data-gallery="gallery">
					<img src="{{ $photo->path }}" class="img-fluid mb-2" alt="white sample"/>
					</a>
					<input type="checkbox" id="master" data-id="{{$photo->id}}">
				</div>
	        @endforeach
			</div>
			<button class="btn btn-danger btn-sm" onclick="myFunction()">Delete</button>
	    @endif


	</div> 
	</div>

</div>
</div>
@endsection
@include('control.layout.body')
@push('js')

<script src="{{ url('/') }}/AdminLTE/plugins/select2/js/select2.full.min.js"></script>
<script src="{{ url('/') }}/AdminLTE/dist/js/adminlte.min.js"></script>
<script src="{{ url('/') }}/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script src="{{ url('/') }}/AdminLTE/plugins/filterizr/jquery.filterizr.min.js"></script>

<script>
$('.select2').select2({
      theme: 'bootstrap4'
    })
$('.select3').select2()
</script>



<script type="text/javascript">
function myFunction(){
	var allVals = [];
	$('#master:checked').each(function() {  
        allVals.push($(this).attr('data-id'));
    }); 

    if(allVals.length <=0)  
    {  
        alert('Please select row.');  
    }else {  
        var check = confirm('Are you sure you want to delete this row?');  
        if(check == true){  


            var join_selected_values = allVals.join(','); 


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.ajax({
                url: '/control/photos',
                type: 'DELETE',
                data: 'ids='+join_selected_values,
                success: function (data) {
                    if (data['success']) {
                        $('.sub_chk:checked').each(function() {  
                            $(this).parents('tr').remove();
                        });
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            }); 


          $.each(allVals, function( index, value ) {
            $('table tr').filter("[data-row-id='" + value + "']").remove();
          });
        }  
    }
}


</script>

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
</script>

@endpush
@include('control.layout.footer')

