@extends('layout.mainlayout')
@section('content')
    <div class="main-wrapper">

        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash1">
                            <div class="dash-widgetimg">
                                <span><img src="{{ URL::asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>₹ <span class="counters" data-count="{{ $period_income }}">{{ $period_income }}</span></h5>
                                <h6>Total Period Income</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget">
                            <div class="dash-widgetimg">
                                <span><img src="{{ URL::asset('assets/img/icons/dash1.svg') }}" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>₹ <span class="counters" data-count="{{ $period_expenses }}">{{ $period_expenses }}</span></h5>
                                <h6>Total Period Expenses</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash2">
                            <div class="dash-widgetimg">
                                <span><img src="{{ URL::asset('assets/img/icons/dash3.svg') }}" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>₹ <span class="counters" data-count="{{ $lowest_category_amount }}">{{ $lowest_category_amount }}</span></h5>
                                <h6>{{ $lowest_category_name }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash3">
                            <div class="dash-widgetimg">
                                <span><img src="{{ URL::asset('assets/img/icons/dash4.svg') }}" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>₹ <span class="counters" data-count="{{ $highest_category_amount }}">{{ $highest_category_amount }}</span></h5>
                                <h6>{{ $highest_category_name }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button trigger modal -->

                <div class="row">
                    <div class="col-lg-7 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
							<div class="card-header pb-0 d-flex justify-content-between align-items-center">
								<h4 class="card-title mb-0">Recent Transactions</h4>
                                <div class="graph-sets">
									<div class="dropdown">
                                        <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="trans-filter" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span id="selected-filter">Today</span> 
                                            <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="trans-filter">
                                            <li><a href="javascript:void(0);" class="dropdown-item filter-option" data-filter="today">Today</a></li>
                                            <li><a href="javascript:void(0);" class="dropdown-item filter-option" data-filter="yesterday">Yesterday</a></li>
                                        </ul>
                                    </div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive dataview">
									<table class="table datatable " id="transactions-table">
										<thead>
											<tr>
												<th>Sno</th>
												<th>Account</th>
												<th>Category</th>
												<th>Amount</th>
											</tr>
										</thead>
										<tbody>
                                            @foreach ($recent_transations as $key => $transaction)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $transaction->account->name }}</td>
                                                    <td>{{ $transaction->category->category_name }}</td>
                                                    <td>{{ $transaction->amount }}</td>
                                                </tr>
                                            @endforeach
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-lg-5 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Monthly Expenses Breakdown</h4>
                                
                            </div>
                            <div class="card-body">
                                <div id="category_view" class="chart-set"></div>
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
        if ($('#category_view').length > 0) {
            var pieCtx = document.getElementById("category_view"),
                pieConfig = {
                    // colors: ['#7638ff', '#ff737b', '#fda600', '#1ec1b0'],
                    series: {!! $category_total !!},
                    chart: {
                        height: 350,
                        type: 'donut',
                        toolbar: {
                            show: false,
                        }
                    },
                    labels: {!! $category_expenses !!},

                    legend: { show: false },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
            var pieChart = new ApexCharts(pieCtx, pieConfig);
            pieChart.render();
        }

        $(".counters").each(function () {
            var $this = $(this),
                countTo = parseFloat($this.attr("data-count")); // Ensure it's treated as a float

            $({ countNum: 0 }).animate(
                {
                    countNum: countTo,
                },
                {
                    duration: 2000,
                    easing: "linear",
                    step: function () {
                        $this.text(this.countNum.toLocaleString('en-US', { 
                            minimumFractionDigits: 2, 
                            maximumFractionDigits: 2 
                        })); // Display with decimals
                    },
                    complete: function () {
                        $this.text(countTo.toLocaleString('en-US', { 
                            minimumFractionDigits: 2, 
                            maximumFractionDigits: 2 
                        }));
                    },
                }
            );
        });

    
        $('.filter-option').click(function() {
            let filterValue = $(this).data('filter');
            $('#selected-filter').text($(this).text());
            $.ajax({
                url: "/get-transactions",
                type: "GET",
                data: { filter: filterValue },
                success: function(response) {
                    $('#transactions-table').html(response.data);
                },
                error: function(xhr) {
                    console.error("Error fetching transactions", xhr);
                }
            });
        });
    </script>
@endsection
