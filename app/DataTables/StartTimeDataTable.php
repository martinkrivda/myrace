<?php

namespace App\DataTables;

use App\StartTime;
use App\User;
use Yajra\DataTables\Services\DataTable;

class StartTimeDataTable extends DataTable {
	public function ajax() {

		return datatables()->eloquent($this->query())
			->editColumn('stime', function ($stime) {
				//change over here
				return date('H:i:s', strtotime($stime->stime));
			})
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
		$startTime = StartTime::query()
			->leftJoin('tag', 'starttime.tag_ID', '=', 'tag.tag_ID')
			->leftJoin('registration', 'starttime.stime_ID', '=', 'registration.stime_ID')
			->leftJoin('category', 'starttime.category_ID', '=', 'category.category_ID')
			->where('starttime.edition_ID', $edition_ID)
			->select([
				'starttime.stime_ID',
				'category.categoryname',
				'starttime.bib_nr',
				'tag.EPC',
				'registration.lastname',
				'registration.firstname',
				'registration.registration_ID',
				'starttime.stime',
			]);
		return $this->applyScopes($startTime);
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
			'stime_ID' => [
				'name' => 'starttime.stime_ID',
				'data' => 'stime_ID',
				'title' => 'ID',
				'visible' => false,
				'searchable' => false,
			],
			'bib_nr' => [
				'name' => 'starttime.bib_nr',
				'data' => 'bib_nr',
				'title' => 'Bib. Nr.',
				'visible' => true,
			],
			'category' => [
				'name' => 'category.categoryname',
				'data' => 'categoryname',
				'title' => 'Category',
				'visible' => true,
			],
			'lastname' => [
				'name' => 'registration.lastname',
				'data' => 'lastname',
				'title' => 'Lastname',
				'visible' => true,
			],
			'firstname' => [
				'name' => 'registration.firstname',
				'data' => 'firstname',
				'title' => 'Firstname',
				'visible' => true,
			],
			'EPC' => [
				'name' => 'tag.EPC',
				'data' => 'EPC',
				'title' => 'EPC',
				'visible' => true,
			],
			'stime' => [
				'name' => 'starttime.stime',
				'data' => 'stime',
				'title' => 'Start time',
				'visible' => true,
			],
		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename() {
		return 'StartTime_' . date('YmdHis');
	}

	protected $raceedition;
	public function forRaceEdition($edition_ID) {
		$this->raceedition = $edition_ID;
		return $this;
	}
}
