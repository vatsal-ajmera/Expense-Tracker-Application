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
			<div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                

                                <div class="table-top">
                                    <div class="search-set">
                                        <div class="search-path">
                                            <a class="btn btn-filter" id="filter_search">
                                                <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
                                                <span>
                                                    <img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img">
                                                </span>
                                            </a>
                                        </div>
                                        <div class="search-input">
                                            <a class="btn btn-searchset">
                                                <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="wordset">
                                        <button class="btn btn-block btn-outline-primary" id="refresh_search"><i data-feather="refresh-ccw" class="feather-14"></i></button>
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
                                                <div class="row">
                                                    <div class="col-lg col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <div class="d-flex align-items-center">
                                                                <div class="input-groupicon flex-grow-1">
                                                                    <input type="text" placeholder="Choose Date" class="datetimepicker form-control" id="expense_date" name="expense_date">
                                                                    <a class="addonset">
                                                                        <img src="{{ calenderIcon() }}" alt="img">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Filter -->


                                <div class="table-responsive">
                                    <table class="table yajra-datatable">
                                        <thead>
                                            <tr>
                                                <th>Expense Note</th>
                                                <th>Account</th>
                                                <th>Category</th>
                                                <th>Amount</th>
                                                <th>Expense date</th>
                                                <th>Status</th>
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
                    url: "{{ route('transaction.get-records') }}",
                    data: function (d) {
                        d.account_id = $('#account_id').val();
                        d.category_id = $('#category_id').val();
                        d.expense_date = $('#expense_date').val();
                    },
                    beforeSend: function() {
                        $('#global-loader').show();
                    },
                    complete: function() {
                        $('#global-loader').hide();
                    }
                },
                search: {
                    regex: true
                },
                lengthMenu: [10, 20, 50, 100],
                columns: [
                    { data: 'text', name: 'text', searchable: true },
                    { data: 'account_name', name: 'account_name', orderable: true, searchable: true },
                    { data: 'category_name', name: 'category_name', searchable: true},
                    { data: 'amount', name: 'amount', searchable: true},
                    { data: 'expense_date', name: 'expense_date', searchable: true },
                    { data: 'status', name: 'status', searchable: true },
                ],
                dom: "<'row'<'col-sm-6'><'col-sm-6'f>>" +
                "<'table-responsive'tr>" +
                "<'row'<'col-sm-6'l><'col-sm-6'p>>",
            });

            $('#account_id').change(function () {
                table.draw();
            });
            $('#category_id').change(function () {
                table.draw();
            });
            $('#expense_date').on('dp.hide', function(e) {  
                table.draw();
            });

            $('#refresh_search').click(function () {
                let table = $('.yajra-datatable').DataTable();
                table.search('').columns().search('')
                $('#expense_date').val('');
                $('input[type="text"], select').val('');
                $('input, select').trigger('change'); 

                table.draw();
            });



	    });    
    </script>

@endsection