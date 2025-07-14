@extends('admin.layout.layout')

@section('title', 'Dashboard')

@section('content')

    <!-- Breadcrumb -->
    <div class="dashboard-breadcrumb">
        <div class="dashboard-beadcrumb-left">
            <span><i class="fa-solid fa-house"></i> Home</span>
            <span>&nbsp;>&nbsp;</span>
            <span>Dashboard</span>
        </div>
        <div class="dashboard-beadcrumb-center">
            <!-- NA -->
        </div>
        <div class="dashboard-beadcrumb-right">
            <button class="mode-btn primary">7D</button>
            <button class="mode-btn secondary">M</button>
        </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Row 1: KPI Cards -->
        <div class="card kpi-card">
            <div class="kpi-card-left">
                <i class="fa-solid fa-chart-line"></i>
                <span>Income</span>
            </div>
            <div class="kpi-card-right">
                <span>$ {{ number_format($totalIncome, 2) }}</span>
            </div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-card-left">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Order Count</span>
            </div>
            <div class="kpi-card-right">
                <span>{{ $orderCount }}</span>
            </div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-card-left">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span>Profit</span>
            </div>
            <div class="kpi-card-right">
                <span>$ {{ number_format($totalProfit, 2) }}</span>
            </div>
        </div>

        <div class="card kpi-card">
            <div class="kpi-card-left">
                <i class="fa-solid fa-chart-line"></i>
                <span>Sign Up</span>
            </div>
            <div class="kpi-card-right">
                <span>{{ $signupCount }}</span>
            </div>
        </div>

        <!-- Row 2: Charts -->
        <!-- Order Count Line Chart -->
        <div class="card chart-card line-chart-card">
            <div class="chart-header">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Order Count</span>
            </div>
            <div>
                <div id="linechart"></div>
            </div>
        </div>

        <!-- Device Count Pie Chart -->
         <div class="card chart-card pie-chart-card">
            <div>
                <div id="piechart"></div>
            </div>
            <div class="legend-placeholder" id="legend-placeholder"></div>
        </div>

        <!-- Income Expense Column Chart -->
        <div class="card chart-card column-chart-card">
            <div class="chart-header">
                <div class="chart-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
                <span>Income Expense</span>
            </div>
            <div>
                <div id="columnchart"></div>
            </div>
        </div>

        <!-- Browser Stats Table -->
        <div class="card chart-card">
            <table class="browser-stats-table">
                <thead>
                    <tr>
                        <th>Browser</th>
                        <th>Visits</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ asset('storage/uploads/chrome.png') }}" alt="">
                            <span>Chrome</span>
                        </td>
                        <td>100</td>
                        <td>50%</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('storage/uploads/firefox.png') }}" alt="">
                            <span>Firefox</span>
                        </td>
                        <td>50</td>
                        <td>25%</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('storage/uploads/safari.png') }}" alt="">
                            <span>Safari</span>
                        </td>
                        <td>50</td>
                        <td>25%</td>
                    </tr>
                </tbody>
            </table>
        </div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    let lineChartInstance;
    let lineChartData;
    let lineChartOptions;
    let pieChartInstance;
    let pieChartData;
    let pieChartOptions;
    let columnChartInstance;
    let columnChartData;
    let columnChartOptions;

    google.charts.load('current', {'packages':['corechart']});
    google.charts.load('current', {'packages':['bar']});

    google.charts.setOnLoadCallback(lineChart);
    google.charts.setOnLoadCallback(pieChart);
    google.charts.setOnLoadCallback(columnChart);


    // Line Chart
    function lineChart() {
        const orderChartData = @json($ordersPerDay);

        lineChartData = new google.visualization.DataTable();
        lineChartData.addColumn('string', 'Day');
        lineChartData.addColumn('number', 'Orders');   // For the line
        lineChartData.addColumn('number', 'Orders');   // For the points

        lineChartData.addRows(orderChartData);

        lineChartOptions = {
            backgroundColor: 'transparent',
            legend: 'none',
            hAxis: {
                textStyle: { color: '#ffffff' },
                gridlines: { color: 'grey' }
            },
            vAxis: {
                textStyle: { color: '#ffffff' },
                gridlines: { color: 'grey' }
            },
            series: {
                0: {  // Line only
                    color: 'white',
                    pointSize: 0,
                    lineWidth: 2,
                },
                1: {  // Points only
                    color: 'red',  // Red points
                    lineWidth: 0,
                    pointSize: 8,
                    pointShape: 'circle',
                }
            },
            chartArea: {
                left: '10%',
                top: '10%',
                width: '85%',
                height: '75%'
            },
            tooltip: {
                textStyle: { color: '#000000' },
                showColorCode: true
            }
        };

        lineChartInstance = new google.visualization.LineChart(document.getElementById('linechart'));
        lineChartInstance.draw(lineChartData, lineChartOptions);
    }

    // Pie Chart
    function pieChart() {
    pieChartData = google.visualization.arrayToDataTable([
        ['Devices', 'Count'],
        ['Mobile', 11],
        ['Desktop', 2],
        ['Tablet', 2]
    ]);

    pieChartOptions = {
        backgroundColor: 'transparent',
        titleTextStyle: {
        color: '#14213D',
        fontSize: 18,
        bold: true
        },
        colors: ['#E56763', '#98EC88', '#66C9C7'],
        legend: { position: 'none' },
        pieSliceText: 'percentage',
        pieSliceTextStyle: {
            color: '#fff',
            fontSize: 14,
            bold: true
        },
        chartArea: {
            left: 10,
            top: 10,
            width: '90%',
            height: '90%'
        },
        slices: {
        0: { offset: 0.05 },
        },
        tooltip: {
        text: 'value'
        }
    };

    pieChartInstance = new google.visualization.PieChart(document.getElementById('piechart'));
    pieChartInstance.draw(pieChartData, pieChartOptions);

    generateDynamicLegend(pieChartData, pieChartOptions.colors);
    }

    // Column Chart
    function columnChart() {
        const monthlyChartData = @json($monthlyChartData);

        const data = [['Month', 'Income', 'Expenses'], ...monthlyChartData];

        const columnChartData = google.visualization.arrayToDataTable(data);

        columnChartOptions = {
            backgroundColor: 'transparent',
            legend: {
                position: 'top',
                alignment: 'end',
                textStyle: { color: '#e2e8f0', fontSize: 12 }
            },
            colors: ['#3b82f6', '#f59e0b'],
            chartArea: {
                left: '10%',
                top: '15%',
                width: '85%',
                height: '70%'
            },
            hAxis: {
                textStyle: { color: '#e2e8f0', fontSize: 12 },
                gridlines: { color: '#334155' }
            },
            vAxis: {
                textStyle: { color: '#e2e8f0', fontSize: 12 },
                gridlines: { color: '#334155' },
                baselineColor: '#64748b'
            },
            bar: { groupWidth: '60%' },
            tooltip: {
                textStyle: { color: '#000000' },
                showColorCode: true
            }
        };

        columnChartInstance = new google.visualization.ColumnChart(document.getElementById('columnchart'));
        columnChartInstance.draw(columnChartData, columnChartOptions);
    }

    // Generate dynamic legend
    function generateDynamicLegend(data, colors) {
        var legendContainer = document.getElementById('legend-placeholder');
        legendContainer.innerHTML = '';
        
        // Create legend items dynamically
        for (var i = 0; i < data.getNumberOfRows(); i++) {
            var label = data.getValue(i, 0);
            var value = data.getValue(i, 1);
            
            // Create legend item element
            var legendItem = document.createElement('div');
            legendItem.className = 'legend-item';
            legendItem.setAttribute('data-slice', i);
            
            legendItem.innerHTML = `
                    <span class="legend-value">${value}</span>
                    <br>
                    <span class="legend-text">${label}</span>
            `;
            
            legendContainer.appendChild(legendItem);
        }
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (pieChartInstance && pieChartData && pieChartOptions) {
                pieChartInstance.draw(pieChartData, pieChartOptions);
            }

            if (lineChartInstance && lineChartData && lineChartOptions) {
                lineChartInstance.draw(lineChartData, lineChartOptions);
            }

            if (columnChartInstance && columnChartData && columnChartOptions) {
                columnChartInstance.draw(columnChartData, columnChartOptions);
            }

            location.reload();

        }, 500);
    });
</script>
@endpush