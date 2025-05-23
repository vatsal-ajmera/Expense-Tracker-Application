@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
	<div class="content">
		<div class="page-header">
			<div class="page-title">
				<h4>{{ $meta_data['title'] }}</h4>
				<h6>{{ $meta_data['description'] }}</h6>
			</div>
			<div class="page-btn">
				<a href="{{ Route('income.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New {{ $meta_data['title'] }}</a>
			</div>
		</div>
		
		<div class="card">
			<div class="card-body">
				<div class="table-top">
					<div class="search-set">
						<div class="search-path">
							
						</div>
						<div class="search-input">
							<a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img"></a>
						</div>
					</div>
					<div class="wordset">
						<ul>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="{{ asset('assets/img/icons/printer.svg') }}" alt="img"></a>
							</li>
						</ul>
					</div>
				</div>

				<div class="table-responsive">
					<table class="table yajra-datatable">
						<thead>
							<tr>
								<th>Account</th>
								<th>Note</th>
								<th>Date</th>
								<th>amount</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('page-js')
<script>
	$(document).ready(function () {
		let table = $('.yajra-datatable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url: "{{ route('income.get-records') }}",
				beforeSend: function() {
					$('#global-loader').show();
				},
				complete: function() {
					$('#global-loader').hide();
				}
			},
			lengthMenu: [10, 20, 50, 100],
			columns: [
				{ data: 'account_name', name: 'account_name' },
				{ data: 'notes', name: 'notes' },
				{ data: 'date', name: 'date' },
				{ data: 'amount', name: 'amount' },
				{
					data: 'action',
					name: 'action',
					orderable: true,
					searchable: true
				},
			],
				
			dom: "<'table-responsive'tr>" +
				"<'row'<'col-sm-6'l><'col-sm-6'p>>",
		});

		airpos_app.deleteItem(".confirm-text");
	});

	
</script>
@endsection
