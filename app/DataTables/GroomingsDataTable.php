<?php

namespace App\DataTables;

use App\Models\Grooming;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Dompdf\Dompdf;

class GroomingsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
       $groomings =  Grooming::query();

        return datatables()
            ->eloquent($groomings)
            ->addColumn('image', function ($groomings) { 
            $url= asset('storage/'.$groomings->imagePath);
            return '<img src="'. asset($groomings->imagePath).'" border="0" width="80" height="80" class="rounded" align="center" />';
            })
            ->addColumn('action', function($row) {
                    return "<a href=". route('grooming.edit', $row->id). " class=\"btn btn-warning\">Edit</a> 
                    <form action=". route('grooming.destroy', $row->id). " method= \"POST\" >". csrf_field() .
                    '<input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit" >Delete</button>
                    </form>';
                  })
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Grooming $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Grooming $model)
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
                    ->setTableId('groomings-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        // Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
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
            Column::make('id'),
            Column::make('description')->title('Description'),
            Column::make('price')->title('Price'),
            Column::make('image')->title('Image'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('action')
                  ->exportable(false)
                  ->printable(false)
                  ->orderable(false)
                  ->width(60),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Groomings_' . date('YmdHis');
    }
}
