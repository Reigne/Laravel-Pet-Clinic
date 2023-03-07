<?php

namespace App\DataTables;

use App\Models\Consultation;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ConsultationsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {   
        $consultations =  Consultation::with('pets','employees','conditions');
        return datatables()
            ->eloquent($consultations)
            // ->addColumn('pet', function (Consultation $consultations) { 
            //  return $consultations->pets->map(function($pet) {
            //             // return str_limit($listener->listener_name, 30, '...');
            //             return $pet->name;
            //         });
            //     })
            ->addColumn('conditions', function (Consultation $consultations) {
                    return $consultations->conditions->map(function($condition) {
                        // return str_limit($listener->listener_name, 30, '...');
                        return "<li>" . $condition->description . "</li>";
                    })->implode('<br>');
                })
            ->escapeColumns([]);
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Consultation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Consultation $model)
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
                    ->setTableId('consultations-table')
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
            // Column::make('pet'),
            Column::make('conditions'),
            Column::make('price'),
            Column::make('comment'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Consultations_' . date('YmdHis');
    }
}
