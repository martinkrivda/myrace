<?php

namespace App\DataTables;

use App\History;
use App\User;
use Yajra\DataTables\Services\DataTable;

class HistoryDataTable extends DataTable {

	public function ajax() {

		return datatables()->eloquent($this->query())
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
		$history = History::query()
			->leftJoin('users', 'history.creator_ID', '=', 'users.id')
			->where('history.edition_ID', $edition_ID)
			->select([
				'history.history_ID',
				'history.registration_ID',
				'history.type',
				'history.description',
				'history.created_at',
				'users.username',
			])
			->orderBy('history_ID', 'desc');
		return $this->applyScopes($history);
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
			'history_ID' => [
				'name' => 'history.history_ID',
				'data' => 'history_ID',
				'title' => 'ID',
				'visible' => true,
			],
			'registration_ID' => [
				'name' => 'history.registration_ID',
				'data' => 'registration_ID',
				'title' => 'Registration ID',
				'visible' => true,
			],
			'type' => [
				'name' => 'history.type',
				'data' => 'type',
				'title' => 'Type',
				'visible' => true,
			],
			'description' => [
				'name' => 'history.description',
				'data' => 'description',
				'title' => 'Description',
				'visible' => true,
			],
			'username' => [
				'name' => 'users.username',
				'data' => 'username',
				'title' => 'Creator',
				'visible' => true,
			],
			'created_at' => [
				'name' => 'history.created_at',
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
		return 'History_' . date('YmdHis');
	}

	protected $raceedition;
	public function forRaceEdition($edition_ID) {
		$this->raceedition = $edition_ID;
		return $this;
	}
}
