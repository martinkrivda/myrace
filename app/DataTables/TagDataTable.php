<?php

namespace App\DataTables;

use App\Tag;
use Yajra\DataTables\Services\DataTable;

class TagDataTable extends DataTable {
	public function ajax() {

		return datatables()->eloquent($this->query())->make(true);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\User $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query() {
		$tags = Tag::select();
		return $this->applyScopes($tags);
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
				'dom' => 'Bfrtip',
				'paging' => true,
				'searching' => true,
				'responsive' => true,
				'buttons' => ['csv', 'excel', 'pdf', 'print', 'reset', 'reload', 'colvis'],
				'processing' => false,
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
			'tag_ID',
			'EPC',
			'created_at',
		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename() {
		return 'RFIDTags_' . date('YmdHis');
	}
}
