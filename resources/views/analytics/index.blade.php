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
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-6 d-flex">
                                            <h4 class="card-title">Spend Analytics</h4>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-6 d-flex">
                                            <div class="graph-sets">
                                                <div class="row">
                                                    <!-- Year Dropdown -->
                                                    <div class="col-lg-4 col-sm-4 col-4 d-flex">
                                                        <div class="dropdown">
                                                            <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="yearDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                                2025
                                                                <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="yearDropdown">
                                                                <li><a href="javascript:void(0);" class="dropdown-item year-option" data-year="2025">2025</a></li>
                                                                <li><a href="javascript:void(0);" class="dropdown-item year-option" data-year="2024">2024</a></li>
                                                                <li><a href="javascript:void(0);" class="dropdown-item year-option" data-year="2023">2023</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                            
                                                    <!-- Month Dropdown -->
                                                    <div class="col-lg-4 col-sm-4 col-4 d-flex">
                                                        <div class="dropdown">
                                                            <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="monthDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                                {{ \Carbon\Carbon::now()->format('M') }}
                                                                <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="monthDropdown">
                                                                @php
                                                                    $months = collect(range(1, 12))->map(function ($month) {
                                                                        return \Carbon\Carbon::create()->month($month)->format('M');
                                                                    });
                                                                @endphp
                                                                @foreach ($months as $index => $month)
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="dropdown-item month-option" data-month="{{ $index + 1 }}">{{ $month }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                            
                                                    <!-- Apply Button -->
                                                    <div class="col-lg-4 col-sm-4 col-4 d-flex">
                                                        <button class="btn btn-primary btn-sm" id="apply_chart_filter">Apply</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

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
                                                                <table class="table datatable " id="account_expense_table">
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
                                                                                <td>{{ $key + 1 }}</td>
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
        var expenseChart;
        var categoryBarChart;
        $(document).ready(function () {
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

                expenseChart = new ApexCharts(
                    document.querySelector("#expense-chart"),
                    sColStacked
                );

                expenseChart.render();
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

                var categoryBarChart = new ApexCharts(
                    document.querySelector("#category-bar-chart"),
                    sBar
                );

                categoryBarChart.render();
            }

            // Update chart data
            let selectedYear = 2025; // Default year
            let selectedMonth = "{{ \Carbon\Carbon::now()->month }}"; // Default current month
            $(".year-option").click(function () {
                selectedYear = $(this).data("year");
                $("#yearDropdown").html(selectedYear + ' <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">');
            });

            $(".month-option").click(function () {
                selectedMonth = $(this).data("month");
                let monthText = $(this).text();
                $("#monthDropdown").html(monthText + ' <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">');
            });

            // Apply filter button
            $("#apply_chart_filter").click(function () {

                $.ajax({
                    url: "{{ route('analytics.filter') }}",
                    method: "GET",
                    data: { year: selectedYear, month: selectedMonth },
                    beforeSend: function() {
                        $('#global-loader').show();
                        $('.amount_section').addClass('shimmer')
                    },
                    complete: function() {
                        $('#global-loader').hide();
                    },
                    success: function (response) {
                        if (expenseChart) {
                            let newDates = JSON.parse(response.dates);
                            let newSeries = JSON.parse(response.series);

                            expenseChart.updateOptions({
                                xaxis: {
                                    categories: newDates
                                },
                                series: newSeries
                            });
                        } else {
                            console.error("Chart instance not found!");
                        }

                        if (categoryBarChart) {
                            let categories = JSON.parse(response.categories); 
                            let category_expense = JSON.parse(response.category_expense);
                            let account_expense = response.account_expense;

                            categoryBarChart.updateOptions({
                                xaxis: {
                                    categories: categories
                                },
                                series: [{
                                    name: "Total Expense",
                                    data: category_expense
                                }],
                            });
                            
                            $('#account_expense_table').html(account_expense)
                        } else {
                            console.error("Chart Category instance not found!");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            });
        });

    </script>

@endsection