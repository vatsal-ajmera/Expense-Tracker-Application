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

                    <section class="comp-section">
                        <div class="col-md-12">
                            <div class="card bg-white">
                                <div class="card-header">
                                    <h5 class="card-title">Spend Analytics</h5>
                                </div>
                                
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                                        <li class="nav-item"><a class="nav-link active" href="#solid-rounded-justified-tab1" data-bs-toggle="tab">Analytics</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab2" data-bs-toggle="tab">Expenses</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="solid-rounded-justified-tab1">

                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 col-12 d-flex">
                                                    <div class="card flex-fill">
                                                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                                            <h4 class="card-title mb-0">Day wise Expenses</h4>
                                                            
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="expense-chart" class="chart-set"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="tab-pane" id="solid-rounded-justified-tab2">
                                            
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12 col-12 d-flex">
                                                    <div class="card flex-fill">
                                                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                                            <h4 class="card-title mb-0">Account Transaction</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive dataview">
                                                                <table class="table datatable ">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Sno</th>
                                                                            <th>Account</th>
                                                                            <th>Spend</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($account_expense as $key => $account)
                                                                            <tr>
                                                                                <td>{{ $key+1 }}</td>
                                                                                <td>{{ $account['name'] }}</td>
                                                                                <td>₹ {{ $account['total_amount'] }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-12 d-flex">
                                                    <div class="card flex-fill">
                                                        <div class="card-header">
                                                            <h5 class="card-title">Category wise Breakdown</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="category-bar-chart" class="chart-set"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                </div>
			</div>
		</div>

	</div>
</div>
@endsection


@section('page-js')

    <script>
        if ($('#expense-chart').length > 0) {
            var sColStacked = {
                chart: {
                    height: 350,
                    type: 'bar',
                    stacked: true,
                    toolbar: {
                        show: false,
                    }
                },
                // colors: ['#4361ee', '#888ea8', '#e3e4eb', '#d3d3d3'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                    },
                },
                series: {!! $series !!},
                xaxis: {
                    type: 'datetime',
                    categories: {!! $dates !!},
                },
                legend: {
                    position: 'right',
                    offsetY: 40
                },
                fill: {
                    opacity: 1
                },
            }

            var chart = new ApexCharts(
                document.querySelector("#expense-chart"),
                sColStacked
            );

            chart.render();
        }
        
        if ($('#category-bar-chart').length > 0) {
            var sBar = {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    }
                },
                // colors: ['#4361ee'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: "Total Expense",
                    data: {!! $category_expense !!}
                }],
                xaxis: {
                    categories: {!! $categories !!},
                }
            }

            var chart = new ApexCharts(
                document.querySelector("#category-bar-chart"),
                sBar
            );

            chart.render();
        }
    </script>

@endsection