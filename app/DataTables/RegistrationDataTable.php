<?php

namespace App\DataTables;

use App\Registration;
use Yajra\DataTables\Services\DataTable;

class RegistrationDataTable extends DataTable {
	public function ajax() {

		return datatables()->eloquent($this->query())
			->addColumn('action', function ($registration) {
				return '<a class="btn btn-xs btn-success" href="/race/' . $this->raceedition . '/registration/' . $registration->registration_ID . '"><i class="fa fa-eye" aria-hidden="true"></i></a> <a class="btn btn-xs btn-info" href="/race/' . $this->raceedition . '/registration/' . $registration->registration_ID . '/edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a onclick="deleteRegistration(' . $registration->registration_ID . ')" class="btn btn-xs btn-danger remove-registration" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
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
		return datatables($query)
			->addColumn('action', 'registrationdatatable.action');
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\User $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	protected function query() {
		$edition_ID = $this->raceedition;
		$registration = Registration::query()
			->leftJoin('category', 'registration.category_ID', '=', 'category.category_ID')
			->leftJoin('club', 'registration.club_ID', '=', 'club.club_ID')
			->leftJoin('registrationsum', 'registration.regsummary_ID', '=', 'registrationsum.regsummary_ID')
			->leftJoin('starttime', 'registration.stime_ID', '=', 'starttime.stime_ID')
			->where('registration.edition_ID', $edition_ID)
			->select([
				'registration_ID',
				'registration.firstname',
				'registration.lastname',
				'category.categoryname',
				'starttime.bib_nr',
				'registration.yearofbirth',
				'registration.gender',
				'club.clubname',
				'registration.entryfee',
				'registrationsum.payref',
				'registration.paid',
				'registration.DNS',
				'registration.DNF',
				'registration.DSQ',
			]);
		return $this->applyScopes($registration);
	}

	/**
	 * Optional method if you want to use html builder.
	 *
	 * @return \Yajra\DataTables\Html\Builder
	 */
	public function html() {
		return $this->builder()
			->columns($this->getColumns())
			->addAction(['width' => '80px', 'printable' => false, 'exportable' => false])
			->minifiedAjax()
			->parameters([
				'dom' => 'lBfrtip',
				'paging' => true,
				'searching' => true,
				'responsive' => true,
				'autoWidth' => false,
				'pageLength' => 50,
				'buttons' => [
					'create',
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
				'name' => 'registration.registration_ID',
				'data' => 'registration_ID',
				'title' => 'ID',
				'visible' => true,
			],
			'lastname',
			'firstname',
			'category' => [
				'name' => 'category.categoryname',
				'data' => 'categoryname',
				'title' => 'Category',
				'visible' => true,
			],
			'bib_nr' => [
				'name' => 'starttime.bib_nr',
				'data' => 'bib_nr',
				'title' => 'Bib.Nr.',
				'visible' => true,
			],
			'yearofbirth',
			'gender',
			'club' => [
				'name' => 'club.clubname',
				'data' => 'clubname',
				'title' => 'Club',
				'visible' => true,
			],
			'entryfee' => [
				'name' => 'registration.entryfee',
				'data' => 'entryfee',
				'title' => 'Entry Fee',
				'visible' => true,
			],
			'payref' => [
				'name' => 'registrationsum.payref',
				'data' => 'payref',
				'title' => 'Pay reference',
				'visible' => true,
			],
			'paid',
			'DNS',
			'DNF',
			'DSQ',
		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename() {
		return 'Registration_' . date('YmdHis');
	}

	protected $raceedition;
	public function forRaceEdition($edition_ID) {
		$this->raceedition = $edition_ID;
		return $this;
	}
}
