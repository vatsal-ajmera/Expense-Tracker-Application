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
			<form method="post" id='saveCategoryForm' action="{{ Route('category.save')}}">
				<div class="card-body">
					<div class="row">
						@if (!empty($category->id))
							<input type="hidden" name="edit_id" value="{{ $category->id }}">
                        @endif
						<div class="col-lg-12">
							<div class="form-group">
								<label>Category Name</label>
								<input type="text" name="category_name" placeholder="Account name here" value='{{ $category->category_name ?? '' }}'>
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
