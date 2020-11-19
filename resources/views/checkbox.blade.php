<input type="checkbox" id="master">
<input type="checkbox" id="master">
<input type="checkbox" id="master">
<input type="checkbox" id="master">
<input type="checkbox" id="master">
<input type="checkbox" id="master">

<td><input type="checkbox" class="sub_chk" data-id="1"></td>


<button onclick="myFunction()">Click me</button>


<script type="text/javascript">
function myFunction(){
	var allVals = [];
	$('.sub_chk:checked').each(function() {  
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
                    'X-CSRF-TOKEN': '" . csrf_token() ."'
                }
            });
            $.ajax({
                url: '/control/actorsDeleteAll',
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