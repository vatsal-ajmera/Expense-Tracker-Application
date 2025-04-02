@extends('layout.mainlayout')
@section('page-css')

    <style>
        .shimmer {
            background: linear-gradient(90deg, #f6f7f8 25%, #edeef1 50%, #f6f7f8 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite linear;
            color: transparent; /* Hide text */
            border-radius: 5px;
            display: flex; /* Keep layout intact */
            align-items: center; /* Center shimmer */
            justify-content: center;
            min-height: 50px; /* Set a fixed height */
            width: 100%;
        }

        /* Prevent height increase */
        .shimmer h5, .shimmer h6 {
            visibility: hidden; /* Hide text instead of removing it */
        }
        .shimmer .dash-widgetimg {
            display: none; /* Hide the icon section */
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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

        <div class="row">
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="dash-widget amount_section">
                    <div class="dash-widgetimg">
                        <span><img src="{{ URL::asset('assets/img/icons/dash1.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>₹<span class="counters" data-count="0.00">₹ 0.00</span></h5>
                        <h6>Gross Debits</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="dash-widget dash1 amount_section">
                    <div class="dash-widgetimg">
                        <span><img src="{{ URL::asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>₹<span class="counters" data-count="0.00">₹ 0.00</span></h5>
                        <h6>Gross Credits</h6>
                    </div>
                </div>
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
                                            <div class="col-lg-3 col-sm-12">
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
                                            <div class="col-lg-3 col-sm-12">
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
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <div class="d-flex align-items-center">
                                                                <div class="input-groupicon flex-grow-1">
                                                                    <input type="text" placeholder="Choose Date" class="datetimepicker form-control" id="date" name="date">
                                                                    <a class="addonset">
                                                                        <img src="{{ calenderIcon() }}" alt="img">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <select class="select" id="trans_type">
                                                                <option value="">Select Any One</option>
                                                                <option value="credit">Credit</option>
                                                                <option value="debit">Debit</option>
                                                            </select>
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
                                                <th>Trans Type</th>
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
                        d.trans_type = $('#trans_type').val();
                        d.date = $('#date').val();
                    },
                    beforeSend: function() {
                        $('#global-loader').show();
                        $('.amount_section').addClass('shimmer')
                    },
                    complete: function() {
                        $('#global-loader').hide();
                    },
                    dataSrc: function(json) {
                        setTimeout(() => {
                            updateSummaryBoxes(json.gross_debits, json.gross_credits);
                            $('.amount_section').removeClass('shimmer')
                        }, 1000);
                        return json.data;
                    }
                },
                search: {
                    regex: true
                },
                lengthMenu: [100, 500, 1000, 2000],
                columns: [
                    { data: 'text', name: 'text', searchable: true },
                    { data: 'account_name', name: 'account_name', orderable: true, searchable: true },
                    { data: 'category_name', name: 'category_name', searchable: true},
                    { data: 'amount', name: 'amount', searchable: true},
                    { data: 'date', name: 'date', searchable: true },
                    { data: 'type', name: 'type', searchable: true },
                ],
                drawCallback: function(settings) {
                    let api = this.api();

                    // Calculate Gross Debits and Gross Credits on the current page
                    let pageDebits = api
                        .rows({ page: 'current' })
                        .data()
                        .filter(row => row.type.includes('Debit'))
                        .pluck('amount')
                        .reduce((a, b) => parseFloat(a) + parseFloat(b), 0);

                    let pageCredits = api
                        .rows({ page: 'current' })
                        .data()
                        .filter(row => row.type.includes('Credit'))
                        .pluck('amount')
                        .reduce((a, b) => parseFloat(a) + parseFloat(b), 0);

                    // Update the summary boxes dynamically
                    updateSummaryBoxes(pageDebits, pageCredits);
                },
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
            $('#trans_type').change(function () {
                table.draw();
            });
            $('#date').on('dp.hide', function(e) {  
                table.draw();
            });

            $('#refresh_search').click(function () {
                let table = $('.yajra-datatable').DataTable();
                table.search('').columns().search('')
                $('#date').val('');
                $('input[type="text"], select').val('');
                $('input, select').trigger('change'); 

                table.draw();
            });

            function updateSummaryBoxes(debits, credits) {
                $('.dash-widgetcontent .counters[data-count]:first').text(`${debits}`);
                $('.dash-widgetcontent .counters[data-count]:last').text(`${credits}`);
            }

	    });    
    </script>

@endsection