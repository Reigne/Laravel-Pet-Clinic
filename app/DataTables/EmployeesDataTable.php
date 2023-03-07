<?php

namespace App\DataTables;

use App\Models\Employee;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Dompdf\Dompdf;

class EmployeesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $employees =  Employee::withTrashed()->with('users');

        return datatables()
            ->eloquent($employees)
            ->addColumn('image', function ($employees) { 
            return '<img src="'. asset($employees->imagePath) . '" width="80"height="80" class="rounded" >'; 
            })
            // ->addColumn('action', function($row) {
            //         return "<a href=". route('employee.edit', $row->id). " class=\"btn btn-warning\">Edit</a> 
            //         <form action=". route('employee.destroy', $row->id). " method= \"POST\" >". csrf_field() .
            //         '<input name="_method" type="hidden" value="DELETE">
            //         <button class="btn btn-danger" type="submit">Delete</button>
            //         </form>';
            //       })
             ->addColumn('action', function($row) {
                    if ($row->deleted_at) 
                    return '<a href="'. route('employee.restore',$row->id) .'" class="btn btn-success">Restore</a>';
                    else 
                    return
                    '<a href="'. route('employee.edit', $row->id). '" class="btn btn-warning">Edit</a> 
                    <form action="'. route('employee.forceDelete', $row->id). '" method="POST">'. csrf_field() .'
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                    <form action="'. route('employee.destroy', $row->id). '" method="POST">'. csrf_field() .'
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Deactivate</button>
                    </form>';
                  })
            ->addColumn('employee', function($employees) {
                if ($employees->deleted_at) 
                return'<span class="badge rounded-pill bg-secondary" style="color:white">Deactivated</span>';
                else 
                return '<span class="badge rounded-pill bg-success" style="color:white">'. $employees->users->role .'</span>';
            })
            // ->addColumn('owner', function ($pets) { 
            // return  $pets->customers->fname . " " . $pets->customers->lname ;
            // })
            // ->rawColumns(['listener','action'])
            ->escapeColumns([]);
                     // ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
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
                    ->setTableId('employees-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
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
            Column::make('fname')->title('First Name'),
            Column::make('lname')->title('Last Name'),
            Column::make('employee')->title('Role'),
            Column::make('image')->title('Image'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('action')
                  ->exportable(false)
                  ->printable(false)
                  ->orderable(false)
                  ->width(60),
            //       ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Employees_' . date('YmdHis');
    }
}
