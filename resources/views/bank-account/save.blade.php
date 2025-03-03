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
			<form method="post" id='saveAccountForm' action="{{ Route('accounts.save')}}">
				<div class="card-body">
					<div class="row">
						@if (!empty($account->id))
							<input type="hidden" name="edit_id" value="{{ $account->id }}">
                        @endif
						<div class="col-lg-12">
							<div class="form-group">
								<label>Account Name</label>
								<input type="text" name="name" placeholder="Account name here" value='{{ $account->name ?? '' }}'>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Account Number</label>
								<input type="text" name='number' placeholder="Account numbner here" value="{{ $account->number }}">
							</div>
						</div>

						<div class="col-lg-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Account Type</label>
								<select class="form-select" required aria-label="select example" name='type'>
									<option value="">Select Account type</option>
									@foreach ($account_types as $key => $type)
										<option value="{{ $key }}" {{ (!empty($account->type) && $account->type == $key) ? 'selected' : '' }}>{{ $type }}</option>
									@endforeach
								</select>
								<div class="invalid-feedback">Example invalid select feedback</div>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 col-12">
							<div class="form-group">
								<label>Account Limit</label>
								<input type="text" name='limit' placeholder="100000" value="{{ $account->limit ?? '' }}">
							</div>
						</div>

						<div class="col-lg-12">
							<button class="btn btn-submit me-2" id="submit_form" type="submit">save</button>
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

@endsection
