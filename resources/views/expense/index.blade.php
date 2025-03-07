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
				<a href="{{ Route('expense.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New {{ $meta_data['title'] }}</a>
			</div>
		</div>
		

		<!-- /product list -->
		<div class="card">
			<div class="card-body">
				<div class="table-top">
					<div class="search-set">
						<div class="search-path">
							<a class="btn btn-filter" id="filter_search">
								<img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
								<span><img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img"></span>
							</a>
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
				<!-- /Filter -->
				<div class="card mb-0" id="filter_inputs">
					<div class="card-body pb-0">
						<div class="row">
							<div class="col-lg-4 col-sm-12">
								<div class="row">
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<select class="select" id="account_id">
												<option value="">Select Any Account</option>
												@foreach ($accounts as $key => $account)
													<option value="{{ $account->id }}">{{ $account->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12">
								<div class="row">
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<select class="select" id="category_id">
												<option value="">Select Any Type</option>
												@foreach ($categories as $key => $category)
													<option value="{{ $category->id }}">{{ $category->category_name }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12">
								
							</div>
						</div>
					</div>
				</div>
				<!-- /Filter -->
				<div class="table-responsive">
					<table class="table yajra-datatable">
						<thead>
							<tr>
								<th>Account</th>
								<th>Category</th>
								<th>Expense</th>
								<th>Amount</th>
								<th>Expense Date</th>
								<th>status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /product list -->
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
				url: "{{ route('expense.get-records') }}",
				data: function (d) {
					d.account_id = $('#account_id').val();
					d.category_id = $('#category_id').val();
				},
				beforeSend: function() {
					$('#global-loader').show();
				},
				complete: function() {
					$('#global-loader').hide();
				}
			},
			lengthMenu: [10, 20, 50, 100],
			columns: [
				{ data: 'account_name', name: 'account_name', orderable: true },
				{ data: 'category_name', name: 'category_name' },
				{ data: 'text', name: 'text', searchable: true },
				{ data: 'amount', name: 'amount' },
				{ data: 'expense_date', name: 'expense_date' },
				{ data: 'status', name: 'status' },
				{ data: 'action', name: 'action' },
			],
				
			dom: "<'table-responsive'tr>" +
				"<'row'<'col-sm-6'l><'col-sm-6'p>>",
		});

		$('#account_id').change(function () {
			table.draw();
		});
		$('#category_id').change(function () {
			table.draw();
		});
		
		airpos_app.deleteItem(".confirm-text");
	});

	
</script>
@endsection
