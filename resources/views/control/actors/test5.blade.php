@section('css')
<!-- <link rel="stylesheet" href="{{asset('css/editor.bootstrap.css')}}"> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.4/css/select.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">



@endsection
@include('control.layout.header')
@include('control.layout.nav')
@include('control.layout.menu')


@section('content')

<div class="container">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<h3 class="card-title">DataTable For Actors</h3>
	</div>
	<div class="card-body">
	{{$dataTable->table(['id' => 'actors'])}}	
	</div> 
</div> 
</div> 
</div>
@endsection
@include('control.layout.body')

@push('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="{{asset('/vendor/datatables/buttons.server-side.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<!-- 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
 -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<!-- <script src="{{asset('js/dataTables.editor.js')}}"></script> -->
<!-- <script src="{{asset('js/editor.bootstrap.min.js')}}"></script> -->
<!-- <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script> -->

{{ $dataTable->scripts() }} 

<script>
	/*var selected = [];
	$('#actors').on('click', 'tbody tr', function (e) {
		console.log( this.id );
        var id = this.id;
        var index = $.inArray(id, selected);
 
        if ( index === -1 ) {
            selected.push( id );
        } else {
            selected.splice( index, 1 );
        }

        if (selected.length == 1) {
        	$('.copyButton').attr('disabled', false);
        	$('.copyButton').on('click'), function (e) {
		        window.location.replace('http://127.0.0.1:5000/control/actors/5');
		    }
        } else {
        	$('.copyButton').attr('disabled', true);
        }
        if (selected.length > 1) {
        	$('.rmAll').attr('disabled', false);
        } else {
        	$('.rmAll').attr('disabled', true);
        }
 
        $(this).toggleClass('selected');

       	$('.rmAll').attr("onclick" , 'https://' + window.location.hostname + window.location.pathname + '5');

        
    } );
    function notify() {
	  alert( "clicked" );
	}
	$( "#actors tbody tr" ).on( "click", notify );

    
    $('#actors').on('click', 'tbody tr', function (e) {
		console.log( this.id );
    } );
    $('#actors ').on('select','tbody tr',function (e) {
    	alert( "selected" );
    });*/

    selected = [];
    function sh () { 
    	$('#actors tr.selected').each(function() {
	    	alert( this );
	    	var items = $('#actors tr.selected').length;
	    	selected.push( this.id );
	    	selected.push( items );

	    });
    }

    $('#actors').on('click', 'tbody tr', function (e) {
    	var items = $('#actors tr.selected').length;
    	if (items == 1) {
        	$('.copyButton').attr('disabled', true);
        } else {
        	$('.copyButton').attr('disabled', false);
        }

        if (items == 1) {
        	$('.rmAll').attr('disabled', false);
        } else {
        	$('.rmAll').attr('disabled', true);
        }

        selected = [];
        $('#actors tr.selected').each(function() {
        	var id = this.id;
	        selected.push( id );



        });
    });


	 

</script>	
<!-- <script>
$( "tbody" )
  .change(function () {
    var str = "";
    $( "tbody tr:selected" ).each(function() {
      str += $( this ).text() + " ";
    });
    $( "#hii" ).text( str );
  })
  .change();
</script> -->

@endpush
@include('control.layout.footer')

<!-- 
<div class="modal fade DTED in" style="display: block;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="DTE DTE_Action_Edit">
				<div data-dte-e="head" class="DTE_Header modal-header">
					<button class="close" title="Close">×</button>
					<div class="DTE_Header_Content">
						<h3>Edit entry</h3>
					</div>
				</div>
				<div data-dte-e="processing" class="DTE_Processing_Indicator">
					<span></span>
				</div>
				<div data-dte-e="body" class="DTE_Body modal-body">
					<div data-dte-e="body_content" class="DTE_Body_Content">
						<div data-dte-e="form_info" class="DTE_Form_Info" style="display: none;"></div>
						<form data-dte-e="form" class="form-horizontal" style="display: block;">
							<div data-dte-e="form_content" class="DTE_Form_Content">
								<div class="DTE_Field DTE_Field_Type_text DTE_Field_Name_name">
									<label data-dte-e="label" class="col-lg-4 control-label" for="DTE_Field_name">Name:<div data-dte-e="msg-label" class="DTE_Label_Info"></div></label>
									<div data-dte-e="input" class="col-lg-8 controls">
										<div data-dte-e="input-control" class="DTE_Field_InputControl" style="display: block;">
											<input id="DTE_Field_name" type="text" class="form-control"></div>
											<div data-dte-e="multi-value" class="well well-sm multi-value" style="display: none;">Multiple values
												<span data-dte-e="multi-info" class="small" style="display: none;">The selected items contain different values for this input. To edit and set all items for this input to the same value, click or tap here, otherwise they will retain their individual values.
												</span>
											</div>
											<div data-dte-e="msg-multi" class="well well-sm multi-restore" style="display: none;">Undo changes</div>
											<div data-dte-e="msg-error" class="help-block" style="display: none;"></div>
											<div data-dte-e="msg-message" class="help-block" style="display: none;"></div>
											<div data-dte-e="msg-info" class="help-block"></div>
										</div>
										<div data-dte-e="field-processing" class="DTE_Processing_Indicator"><span></span>
										</div>
									</div>
									<div class="DTE_Field DTE_Field_Type_text DTE_Field_Name_email">
										<label data-dte-e="label" class="col-lg-4 control-label" for="DTE_Field_email">Email:<div data-dte-e="msg-label" class="DTE_Label_Info">
											
										</div>
									</label>
									<div data-dte-e="input" class="col-lg-8 controls">
										<div data-dte-e="input-control" class="DTE_Field_InputControl" style="display: block;">
											<input id="DTE_Field_email" type="text" class="form-control">
										</div>
										<div data-dte-e="multi-value" class="well well-sm multi-value" style="display: none;">Multiple values
											<span data-dte-e="multi-info" class="small" style="display: none;">The selected items contain different values for this input. To edit and set all items for this input to the same value, click or tap here, otherwise they will retain their individual values.
											</span>
										</div>
										<div data-dte-e="msg-multi" class="well well-sm multi-restore" style="display: none;">Undo changes</div>
										<div data-dte-e="msg-error" class="help-block" style="display: none;"></div>
										<div data-dte-e="msg-message" class="help-block" style="display: none;"></div>
										<div data-dte-e="msg-info" class="help-block"></div>
									</div>
									<div data-dte-e="field-processing" class="DTE_Processing_Indicator"><span></span></div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div data-dte-e="foot" class="DTE_Footer modal-footer"><div class="DTE_Footer_Content"></div>
				<div data-dte-e="form_error" class="DTE_Form_Error" style="display: none;"></div>
				<div data-dte-e="form_buttons" class="DTE_Form_Buttons">
					<button class="btn btn-default" tabindex="0">Edit</button>
					<button class="btn btn-default primary" tabindex="0">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
 -->