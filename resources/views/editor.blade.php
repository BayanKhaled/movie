@section('css')

<link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/summernote/summernote-bs4.css">
@endsection
@include('control.layout.header')
@include('control.layout.nav')
@include('control.layout.menu')


@section('content')

	

	
<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Form Editor
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body pad">
            	{{ Form::open(array('url' => '/control/users', 'method' => 'POST')) }}

            		<div class="form-group row">
					{{ Form::label('title', 'Title', ['class' => 'col-sm-2 col-form-label'])  }}
					<div class="col-sm-10">
					{{ Form::text('title',$value = null, ['class' => 'form-control'])  }}
					</div>
					</div>

	              	<div class="mb-3">
	                	{!! Form::textarea('description',$value =null,['class'=>'form-control textarea', 'rows' => 2, 'cols' => 40]) !!}
	              	</div>

	              	<div class="form-group d-flex justify-content-center">
					{{ Form::submit('Save' ,array('class' => 'btn btn-info '))  }}
					</div>

              	{{ Form::close() }}	


            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
@endsection
@include('control.layout.body')

@push('js')
<script src="{{ url('/') }}/AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>


<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>

@endpush
@include('control.layout.footer')

