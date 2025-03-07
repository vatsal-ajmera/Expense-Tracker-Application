@extends('layout.mainlayout')
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
			<form method="post" id='saveIncomeForm' action="{{ Route('income.save')}}">
				@csrf
				<div class="card-body">
					<div class="row">
						@if (!empty($income->id))
							<input type="hidden" name="edit_id" value="{{ $income->id }}">
                        @endif
						<div class="col-lg-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Income Note</label>
								<input type="text" name="notes" placeholder="Account name here" value='{{ $income->notes ?? '' }}'>
							</div>
						</div>

						<div class="col-lg-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Expense Account</label>
								<select class="form-select" name="account_id">
									<option value="">Choose account</option>
									@foreach ($accounts as $account)
										<option value="{{ $account->id }}" {{ (!empty($income) && $account->id == $income->account_id) ? 'selected' : ''}}>{{ $account->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-lg-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Expense Date</label>
								<div class="d-flex align-items-center">
									<div class="input-groupicon flex-grow-1">
										<input type="text" placeholder="Choose Date" class="datetimepicker form-control"  name="date" 
											value="{{ old('date', isset($income) ? \Carbon\Carbon::parse($income->date)->format('d-m-Y') : '') }}">
										<a class="addonset">
											<img src="{{ calenderIcon() }}" alt="img">
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Income Amount</label>
								<input type="text" name="amount" placeholder="Account name here" value='{{ $income->amount ?? '' }}'>
							</div>
						</div>

						<div class="form-group">
							<label>Product Image</label>
							<div class="image-upload">
								<input type="file" id="fileInput" name="attachment" value="{{ $income->attachment ?? '' }}">
								<div class="image-uploads">
									<img src="{{ URL::asset('assets/img/icons/upload.svg') }}" alt="img">
									<h4>Drag and drop a file to upload</h4>
								</div>
							</div>
						</div>
						
						<div class="col-12">
							<div class="product-list">
								<ul class="row" id="fileList">
									@if (!empty($income->attachment) && $income->attachment)
										<li>
											<div class="productviews">
												
												<div class="productviewscontent">
													<div class="productviewsname">
														<h2>{{ $income->attachment }}</h2>
													</div>
													<a href="javascript:void(0);" class="hideset">x</a>
												</div>
											</div>
										</li>
									@endif
								</ul>
							</div>
						</div>

						<div class="col-lg-12">
							<button class="btn btn-submit me-2" id="submit_form" type="submit">save</button>
							<a class="btn btn-cancel" href="{{ Route('income.list') }}">Cancel</a>
							<button class="btn btn-submit me-2" type="button" id="loaderBtn" disabled style="display: none">
								<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
								Loading...
							</button>
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
    document.getElementById('fileInput').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let fileName = file.name;

            let fileEntry = `
                <li>
                    <div class="productviews">
                        <div class="productviewscontent">
                            <div class="productviewsname">
                                <h2>${fileName}</h2>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="hideset" onclick="removeFile(this)">x</a>
                    </div>
                </li>
            `;
            document.getElementById('fileList').innerHTML = fileEntry;
        }
    });

    function removeFile(element) {
        element.closest('li').remove(); // Removes the clicked file entry
    }
</script>
@endsection
