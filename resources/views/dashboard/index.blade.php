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
                                <h5><span class="counters" data-count="20100.0">{{ $period_income }}</span></h5>
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
                                <h5><span class="counters" data-count="29000.0">{{ $period_expenses }}</span></h5>
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
                                <h5>$<span class="counters" data-count="20100.0">{{ $period_expenses }}</span></h5>
                                <h6>Lowest Expense Category</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash3">
                            <div class="dash-widgetimg">
                                <span><img src="{{ URL::asset('assets/img/icons/dash4.svg') }}" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5>$<span class="counters" data-count="20100.00">400.00</span></h5>
                                <h6>Higest Expense Category</h6>
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
							</div>
							<div class="card-body">
								<div class="table-responsive dataview">
									<table class="table datatable ">
										<thead>
											<tr>
												<th>Sno</th>
												<th>Account</th>
												<th>Category</th>
												<th>Amount</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Apple Earpods</td>
												<td>category</td>
												<td>$891.2</td>
											</tr>
											<tr>
												<td>2</td>
												<td>Apple Earpods</td>
												<td>category</td>
												<td>$891.2</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Apple Earpods</td>
												<td>category</td>
												<td>$891.2</td>
											</tr>
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
        if($('#category_view').length > 0 ){
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
            
    		legend: {show: false},
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
    </script>
@endsection
