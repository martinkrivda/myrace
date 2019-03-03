<?php

namespace App\DataTables;

use App\RegistrationSum;
use Yajra\DataTables\Services\DataTable;

class RegistrationSumDataTable extends DataTable {
	public function ajax() {

		return datatables()->eloquent($this->query())
			->editColumn('status', function ($regsummary) {
				switch ($regsummary->status) {
				case 0:
					$label = '<span class="label label-danger">Neuhrazeno</span>';
					break;
				case 3:
					$label = '<span class="label label-success">Uhrazeno</span>';
					break;
				default:
					$label = '<span class="label label-warning">Neznámý</span>';
				}
				return $label;
			})
			->rawColumns(['status'])
			->make(true);
	}
	/**
	 * Build DataTable class.
	 *
	 * @param mixed $query Results from query() method.
	 * @return \Yajra\DataTables\DataTableAbstract
	 */
	public function dataTable($query) {
		return datatables($query);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\User $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query() {
		$edition_ID = $this->raceedition;
		$registrationSum = RegistrationSum::query()
			->where('registrationsum.edition_ID', $edition_ID)
			->select([
				'regsummary_ID',
				'registrationsum.name',
				'registrationsum.email',
				'registrationsum.price',
				'registrationsum.discount',
				'registrationsum.totalprice',
				'registrationsum.payref',
				'registrationsum.status',
				'registrationsum.created_at',
			]);
		return $this->applyScopes($registrationSum);
	}

	/**
	 * Optional method if you want to use html builder.
	 *
	 * @return \Yajra\DataTables\Html\Builder
	 */
	public function html() {
		return $this->builder()
			->columns($this->getColumns())
			->minifiedAjax()
			->parameters([
				'dom' => 'lBfrtip',
				'paging' => true,
				'searching' => true,
				'responsive' => true,
				'autoWidth' => false,
				'pageLength' => 50,
				'buttons' => [
					[
						'extend' => 'collection',
						'text' => '<i class="fa fa-download"></i> Export',
						'buttons' => [
							'csv',
							'excel',
							'pdf',
						],
					],
					'print',
					'reset',
					'reload',
					'colvis',
				],
				'processing' => true,
				'serverSide' => true,
				'initComplete' => "function () {
                            this.api().columns().every(function () {
                                var column = this;
                                var input = document.createElement(\"input\");
                                $(input).appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }",
			]);
	}

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	protected function getColumns() {
		return [
			'id' => [
				'name' => 'registrationsum.regsummary_ID',
				'data' => 'regsummary_ID',
				'title' => 'ID',
				'visible' => true,
			],
			'name' => [
				'name' => 'registrationsum.name',
				'data' => 'name',
				'title' => 'Name',
				'visible' => true,
			],
			'email' => [
				'name' => 'registrationsum.email',
				'data' => 'email',
				'title' => 'E-mail',
				'visible' => true,
			],
			'price' => [
				'name' => 'registrationsum.price',
				'data' => 'price',
				'title' => 'Price',
				'visible' => true,
			],
			'discount' => [
				'name' => 'registrationsum.discount',
				'data' => 'discount',
				'title' => 'Discount',
				'visible' => true,
			],
			'totalprice' => [
				'name' => 'registrationsum.totalprice',
				'data' => 'totalprice',
				'title' => 'Total Price',
				'visible' => true,
			],
			'payref' => [
				'name' => 'registrationsum.payref',
				'data' => 'payref',
				'title' => 'Pay reference',
				'visible' => true,
			],
			'status' => [
				'name' => 'registrationsum.status',
				'data' => 'status',
				'title' => 'Status',
				'visible' => true,
			],
			'created_at' => [
				'name' => 'registrationsum.created_at',
				'data' => 'created_at',
				'title' => 'Created At',
				'visible' => true,
				'printable' => false,
			],
		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename() {
		return 'RegistrationSum_' . date('YmdHis');
	}

	protected $raceedition;
	public function forRaceEdition($edition_ID) {
		$this->raceedition = $edition_ID;
		return $this;
	}
}
