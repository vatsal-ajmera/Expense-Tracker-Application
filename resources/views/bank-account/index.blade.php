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
				<a href="{{ Route('accounts.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">Add New Product</a>
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
							<div class="col-lg-12 col-sm-12">
								<div class="row">
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<select class="select">
												<option>Choose Product</option>
												<option>Macbook pro</option>
												<option>Orange</option>
											</select>
										</div>
									</div>
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<select class="select">
												<option>Choose Category</option>
												<option>Computers</option>
												<option>Fruits</option>
											</select>
										</div>
									</div>
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<select class="select">
												<option>Choose Sub Category</option>
												<option>Computer</option>
											</select>
										</div>
									</div>
									<div class="col-lg col-sm-6 col-12">
										<div class="form-group">
											<select class="select">
												<option>Brand</option>
												<option>N/D</option>
											</select>
										</div>
									</div>
									<div class="col-lg col-sm-6 col-12 ">
										<div class="form-group">
											<select class="select">
												<option>Price</option>
												<option>150.00</option>
											</select>
										</div>
									</div>
									<div class="col-lg-1 col-sm-6 col-12">
										<div class="form-group">
											<a class="btn btn-filters ms-auto"><img src="{{ asset('assets/img/icons/search-whites.svg') }}" alt="img"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Filter -->


				<div class="table-responsive">
					<table class="table datanew">
						<thead>
							<tr>
								<th>
									<label class="checkboxs">
										<input type="checkbox" id="select-all">
										<span class="checkmarks"></span>
									</label>
								</th>
								<th>Account Name</th>
								<th>Account Type</th>
								<th>Availble Limit</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($accounts as $account)
								<tr>
									<td>
										<label class="checkboxs">
											<input type="checkbox">
											<span class="checkmarks"></span>
										</label>
									</td>
									<td>{{ $account->name }}</td>
									<td>{{ App\Models\Account::getAccountType()[$account->type] }}</td>
									<td>{{ $account->limit }}</td>
									<td>
										<a class="me-3" href="{{ Route('accounts.edit',$account->id) }}">
											<img src="{{ editIcon() }}" alt="img">
										</a>
										<a class="confirm-text" href="{{ Route('accounts.delete', $account->id) }}">
											<img src="{{ deleteIcon() }}" alt="img">
										</a>
									</td>
								</tr>
							@endforeach
							
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
		airpos_app.deleteItem(".confirm-text");
	});
</script>
@endsection
