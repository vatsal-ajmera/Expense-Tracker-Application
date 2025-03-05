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
			<form method="post" id='saveExpensesForm' action="{{ Route('expense.save')}}">
				@csrf
				<div class="card-body">
					<div class="row align-items-end">
						<div class="col-lg-3 col-sm-6 col-12">
							<div class="form-group">
								<label>Expense Date</label>
								<div class="d-flex align-items-center">
									<div class="input-groupicon flex-grow-1">
										<input type="text" placeholder="Choose Date" class="datetimepicker form-control" name="expense_date">
										<a class="addonset">
											<img src="{{ URL::asset('/assets/img/icons/calendars.svg')}}" alt="img">
										</a>
									</div>
								</div>
							</div>
						</div>
				
						<div class="col-lg-9 col-sm-6 col-12 d-flex align-items-end justify-content-end">
							<div class="d-flex justify-content-end">
								<button class="btn btn-primary px-3 me-2 add_expense">Add Row</button>
								<button class="btn btn-primary" id="submit_form" type="submit">save</button>
								<button class="btn btn-primary" type="button" id="loaderBtn" disabled style="display: none">
									<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
									Loading...
								</button>
							</div>
						</div>
					</div>
					
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
													<select class="form-select expense_account_group" name="account_name[]">
														<option value="">Choose Account</option>
														@foreach ($accounts as $key => $account)
															<option value="{{ $account->id }}">{{ $account->name }}</option>
														@endforeach
													</select>
												</div>
											</td>
											<td>
												<div class="form-group form-group-margin0">
													<input type="text" placeholder="Expense Note" name="expense_note[]">
												</div>
											</td>
											<td>
												<div class="form-group form-group-margin0">
													<select class="form-select expense_category_group" name="expense_category[]">
														<option value="">Choose Category</option>
														@foreach ($categories as $category)
															<option value="{{ $category->id }}">{{ $category->category_name }}</option>
														@endforeach
													</select>
												</div>
											</td>
											<td>
												<div class="form-group form-group-margin0">
													<input type="text" placeholder="Amount here" name="amount[]">
												</div>
											</td>
											<td>
												<div class="form-group form-group-margin0">
													<select class="form-select" name="status[]">
														<option value="1">Paid</option>
														<option value="2">Unpaid</option>
													</select>
												</div>
											</td>
											<td>
												<a href="javascript:void(0);" class="delete_expense">
													<img src="{{ deleteIcon() }}" alt="svg">
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
	<script>
		$(document).on("click", ".add_expense", function (e) {
            e.preventDefault();
			let lastRow = $("#expenseTableBody tr:last");
			let newRow = lastRow.clone();
			let rowCount = $("#expenseTableBody tr").length + 1;

			newRow.attr("id", "row_" + rowCount);
			newRow.find("td:first").text(rowCount);
			newRow.find("input").val("");
			newRow.find("form-select").val(null).trigger("change");
			$("#expenseTableBody").append(newRow);
    	});

        $(document).on("click", ".delete_expense", function () {
            if ($("#expenseTableBody tr").length > 1) {
                $(this).closest("tr").remove();
                updateRowNumbers();
            }
        });

        function updateRowNumbers() {
            $("#expenseTableBody tr").each(function (index) {
                $(this).attr("id", "row_" + (index + 1));
                $(this).find("td:first").text(index + 1);
            });
        }
	</script>
	
@endsection
