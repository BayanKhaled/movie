<?php

namespace App\DataTables;

use App\Models\Keywords;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use URL;


class KeywordsDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->setRowId('id')
            ->addColumn('checkbox', '<td><input type="checkbox" class="sub_chk" data-id="{{$id}}"></td>')
            ->addColumn('action', '
                <a class="btn btn-default btn-outline-primary" href="keywords/{{ $id }}/edit">Edit</a>
                <form action="keywords/{{ $id }}" method="POST" onsubmit="return confirm(\'Are You sure?\');" style="display: inline-block;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="'. csrf_token() .'">
                <input type="submit" class="btn btn-default btn-outline-danger" value="Delete">
            ')
            ->rawColumns(['action', 'checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Keywords $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Keywords $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('actorsdatatables-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->pageLength(10)
                    ->lengthMenu([ [10, 25, 50, 100, -1], [10, 25, 50, 100, 'All'] ])
                    ->pagingType('full')
                    ->parameters([
                        'dom' => '<"float-left"B><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
                    ])
                    ->buttons(
                        Button::make('create')->extend('collection')->text('create')->className("btn btn-outline-primary")
                        ->action("function () {
                            window.location.replace('" . URL::current() . "/create');
                            }"),
                        Button::make(['copy'])->extend('collection')->text('MultiRemove')
                        ->addClass("btn btn-outline-danger delete_all")
                        ->attr(['data-url' => url("myproductsDeleteAll")])
                        ->action("
                            var allVals = [];  
                            $('.sub_chk:checked').each(function() {  
                                allVals.push($(this).attr('data-id'));
                            });  


                            if(allVals.length <=0)  
                            {  
                                alert('Please select row.');  
                            }  else {  


                                var check = confirm('Are you sure you want to delete this row?');  
                                if(check == true){  


                                    var join_selected_values = allVals.join(','); 


                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': '" . csrf_token() ."'
                                        }
                                    });
                                    $.ajax({
                                        url: '/control/keywordsDeleteAll',
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
                                    $('table tr').filter(\"[data-row-id='\" + value + \"']\").remove();
                                  });
                                }  
                            } 
                        "),
                        Button::make('print')->className("btn btn-outline-primary"),
                        Button::make(['copy'])->extend('collection')->text('Save as ..')->className("btn btn-outline-success")->buttons([
                          Button::make('csv'),
                          Button::make('excel'),
                        ]),
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'name' => 'checkbox',
                'data' => 'checkbox',
                'title' => 'Check',
                'checkbox' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
                'width' => '15px',
                'title' => '<input type="checkbox" id="master">',
            ],
            Column::make('id')->name('id'),
            Column::make('name'),
            [
                'name' => 'action',
                'data' => 'action',
                'title' => 'Action',
                'width' => '150px',
            ],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Keywords_' . date('YmdHis');
    }
}
