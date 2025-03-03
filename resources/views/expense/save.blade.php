@extends('layout.mainlayout')
@section('page-css')
	<style>
		.form-group-margin0{
			margin-bottom: 0px !important;
		}
	</style>

@endsection
@section('content')
<div class="page-wrapper">
	<div class="content">
		<div class="page-header">
			<div class="page-title">
				<h4>{{ $meta_data['title'] }}</h4>
				<h6>{{ $meta_data['description'] }}</h6>
			</div>
		</div>
		<div class="card">
			<form method="post" id='saveCategoryForm' action="{{ Route('category.save')}}">
				<div class="card-body">
					<div class="row align-items-end">
						
						<div class="col-lg-3 col-sm-6 col-12">
							<div class="form-group">
								<label>Expense Date</label>
								<div class="d-flex align-items-center">
									<div class="input-groupicon flex-grow-1">
										<input type="text" placeholder="Choose Date" class="datetimepicker form-control">
										<a class="addonset">
											<img src="{{ URL::asset('/assets/img/icons/calendars.svg')}}" alt="img">
										</a>
									</div>
								</div>
							</div>
						</div>
				
						<div class="col-lg-6 col-sm-6 col-12"></div>
				
						<div class="col-lg-3 col-sm-6 col-12 d-flex align-items-end justify-content-end">
							<button class="btn btn-primary h-100 px-3">Add Row</button>
						</div>
					</div>
				
					<!-- Table Section -->
					<div class="row mt-3">
						<div class="table-responsive mb-3">
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>Account Type</th>
										<th>Expense Note</th>
										<th>Category</th>
										<th>Amount</th>
										<th>Status</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="expenseTableBody">
									<tr id="row_1">
										<td>1</td>
										<td>
											<div class="form-group form-group-margin0">
												<select class="select">
													<option>Choose Account</option>
													<option>Account Name</option>
												</select>
											</div>
										</td>
										<td>
											<div class="form-group form-group-margin0">
												<input type="text" placeholder="Expense Note">
											</div>
										</td>
										<td>
											<div class="form-group form-group-margin0">
												<select class="select">
													<option>Choose Category</option>
													<option>Category Name</option>
												</select>
											</div>
										</td>
										<td>
											<div class="form-group form-group-margin0">
												<input type="text" placeholder="Amount here">
											</div>
										</td>
										<td>
											<div class="form-group form-group-margin0">
												<select class="select">
													<option>Paid</option>
													<option>Unpaid</option>
												</select>
											</div>
										</td>
										<td>
											<a href="javascript:void(0);" class="delete-set">
												<img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="svg">
											</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>				
				
			</form>
		</div>
	</div>
</div>
@endsection

@section('page-js')

@endsection
