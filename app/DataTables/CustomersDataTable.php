<?php

namespace App\DataTables;

use App\Models\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Dompdf\Dompdf;

class CustomersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {   
        $customers =  Customer::withTrashed()->with(['users','pets']);

        return datatables()
            ->eloquent($customers)
            ->addColumn('status', function($customers) {
                if ($customers->deleted_at) 
                return '<span class="badge rounded-pill bg-secondary" style="color:white"> Deactivated </span>';
                else
                return '<span class="badge rounded-pill bg-success" style="color:white"> Available </span>';
            })
            ->addColumn('image', function ($customers) { 
            return '<img src="'. asset($customers->imagePath) . '" width="80"height="80" class="rounded" >'; 
            })

            // ->addColumn('action', function($row) {
            //         return "<a href=". route('customer.edit', $row->id). " class=\"btn btn-warning\">Edit</a> 
            //         <form action=". route('customer.destroy', $row->id). " method= \"POST\" >". csrf_field() .
            //         '<input name="_method" type="hidden" value="DELETE">
            //         <button class="btn btn-danger" type="submit">Deactivate</button>
            //         </form>';
            //       })
            // ->addColumn('action', function($row) {
            //         $restore = '<a href="'. route('customer.restore',$row->id) .'" class="btn btn-success">Restore</a>';
            //         $action =  '<a href="'. route('customer.edit', $row->id). '" class="btn btn-warning">Edit</a>';
            //         $action .= '<form action="'. route('customer.forceDelete', $row->id). '" method="POST">'. csrf_field() .'
            //         <input name="_method" type="hidden" value="DELETE">
            //         <button class="btn btn-danger" type="submit">Delete</button>
            //         </form>';
            //         $action .= '</form>
            //         <form action="'. route('customer.destroy', $row->id). '" method="POST">'. csrf_field() .'
            //         <input name="_method" type="hidden" value="DELETE">
            //         <button class="btn btn-danger" type="submit">Deactivate</button>
            //         </form>';
            //         if ($row->deleted_at) 
            //         return $restore;
            //         else
            //         return $action;
            //       })
            ->addColumn('action', function($row) {
                    if ($row->deleted_at) 
                    return '<a href="'. route('customer.restore',$row->id) .'" class="btn btn-success">Restore</a>';
                    else 
                    return
                    '<a href="'. route('customer.edit', $row->id). '" class="btn btn-warning">Edit</a> 
                    <form action="'. route('customer.forceDelete', $row->id). '" method="POST">'. csrf_field() .'
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                    <form action="'. route('customer.destroy', $row->id). '" method="POST">'. csrf_field() .'
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Deactivate</button>
                    </form>';
                  })
            ->addColumn('pet', function (Customer $customers) {
                    return $customers->pets->map(function($pet) {
                        // return str_limit($listener->listener_name, 30, '...');
                        return "<li>" . $pet->name . "</li>";
                    })->implode('<br>');
                })
            // ->rawColumns(['listener','action'])
            ->escapeColumns([]);
                     // ->rawColumns(['action']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
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
                    ->setTableId('customers-table')
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
            // Column::make('user_id')->title('User I.D'),
            Column::make('fname')->title('First Name'),
            Column::make('lname')->title('Last Name'),
            Column::make('pet')->name('pets.name')->title('Pets')->width(100),
            Column::make('image')->title('Image'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('action')
                  ->exportable(false)
                  ->printable(false)
                  ->orderable(false)
                  ->width(150),
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
        return 'Customers_' . date('YmdHis');
    }
}
