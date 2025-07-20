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
            <button class="mode-btn primary" id="weekly-btn">7D</button>
            <button class="mode-btn secondary" id="monthly-btn">M</button>
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
                @if ($totalIncome >= 100000)
                    <span>$ {{ number_format($totalIncome / 1000, 2) }}K</span>
                @else
                    <span>$ {{ number_format($totalIncome, 2) }}</span>
                @endif    
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
                @if ($totalProfit >= 100000)
                    <span>$ {{ number_format($totalProfit / 1000, 2) }}K</span>
                @else
                    <span>$ {{ number_format($totalProfit, 2) }}</span>
                @endif
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
                <div id="monthlyOrderChart" style="display: none;"></div>
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
                        <td>{{ $chromeCount }}</td>
                        <td>
                            @php
                                $totalVisits = $chromeCount + $firefoxCount + $safariCount + $otherCount;
                                $percentage = ($chromeCount / $totalVisits) * 100;
                                echo number_format($percentage, 2) . '%';
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('storage/uploads/firefox.png') }}" alt="">
                            <span>Firefox</span>
                        </td>
                        <td>{{ $firefoxCount }}</td>
                        <td>
                            @php
                                $totalVisits = $chromeCount + $firefoxCount + $safariCount + $otherCount;
                                $percentage = ($firefoxCount / $totalVisits) * 100;
                                echo number_format($percentage, 2) . '%';
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('storage/uploads/safari.png') }}" alt="">
                            <span>Safari</span>
                        </td>
                        <td>{{ $safariCount }}</td>
                        <td>
                            @php
                                $totalVisits = $chromeCount + $firefoxCount + $safariCount + $otherCount;
                                $percentage = ($safariCount / $totalVisits) * 100;
                                echo number_format($percentage, 2) . '%';
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="{{ asset('storage/uploads/web.png') }}" alt="">
                            <span>Other</span>
                        </td>
                        <td>{{ $otherCount }}</td>
                        <td>
                            @php
                                $totalVisits = $chromeCount + $firefoxCount + $safariCount + $otherCount;
                                $percentage = ($otherCount / $totalVisits) * 100;
                                echo number_format($percentage, 2) . '%';
                            @endphp
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

    const weeklyBtn = document.getElementById('weekly-btn');
    const monthlyBtn = document.getElementById('monthly-btn');

    weeklyBtn.addEventListener('click', function() {
        weeklyBtn.classList.add('primary');
        weeklyBtn.classList.remove('secondary');
        monthlyBtn.classList.add('secondary');
        monthlyBtn.classList.remove('primary');
        document.getElementById('linechart').style.display = 'block';
        document.getElementById('monthlyOrderChart').style.display = 'none';
        drawAllCharts();
    })

    weeklyBtn.addEventListener('click', function() {
        weeklyBtn.classList.add('primary');
        weeklyBtn.classList.remove('secondary');
        monthlyBtn.classList.add('secondary');
        monthlyBtn.classList.remove('primary');
        document.getElementById('linechart').style.display = 'block';
        document.getElementById('monthlyOrderChart').style.display = 'none';
        drawAllCharts();
    });

    monthlyBtn.addEventListener('click', function() {
        monthlyBtn.classList.add('primary');
        monthlyBtn.classList.remove('secondary');
        weeklyBtn.classList.add('secondary');
        weeklyBtn.classList.remove('primary');
        document.getElementById('linechart').style.display = 'none';
        document.getElementById('monthlyOrderChart').style.display = 'block';
        drawAllCharts();
    })

    monthlyBtn.addEventListener('click', function() {
        monthlyBtn.classList.add('primary');
        monthlyBtn.classList.remove('secondary');
        weeklyBtn.classList.add('secondary');
        weeklyBtn.classList.remove('primary');
        document.getElementById('linechart').style.display = 'none';
        document.getElementById('monthlyOrderChart').style.display = 'block';

        setTimeout(() => {
            if (monthOrderChartInstance) {
                monthOrderChartInstance.draw(monthOrderChartData, monthOrderChartOptions);
            }
        }, 100);
    });

    let lineChartInstance;
    let lineChartData;
    let lineChartOptions;
    let monthOrderChartInstance
    let monthOrderChartData;
    let monthOrderChartOptions;
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
    google.charts.setOnLoadCallback(monthlyOrderChart);


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

    function monthlyOrderChart() {
        const chartData = @json($ordersPerMonthChartData);

        monthOrderChartData = new google.visualization.DataTable();
        monthOrderChartData.addColumn('string', 'Month');
        monthOrderChartData.addColumn('number', 'Orders');
        monthOrderChartData.addColumn('number', 'Orders');

        const modifiedRows = chartData.map(row => [row[0], row[1], row[1]]);
        monthOrderChartData.addRows(modifiedRows);

        monthOrderChartOptions = {
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
                0: {
                    color: 'white',
                    pointSize: 0,
                    lineWidth: 2
                },
                1: {
                    color: 'red',
                    lineWidth: 0,
                    pointSize: 8,
                    pointShape: 'circle'
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

        monthOrderChartInstance = new google.visualization.LineChart(document.getElementById('monthlyOrderChart'));
        monthOrderChartInstance.draw(monthOrderChartData, monthOrderChartOptions);
    }


    // Pie Chart
    const mobileCount = @json($mobileCount);
    const desktopCount = @json($desktopCount);
    const tabletCount = @json($tabletCount);
    function pieChart() {
        pieChartData = google.visualization.arrayToDataTable([
            ['Devices', 'Count'],
            ['Mobile', mobileCount],
            ['Desktop', desktopCount],
            ['Tablet', tabletCount]
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

            columnChartData = google.visualization.arrayToDataTable(data);

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

    function drawAllCharts() {
        if (lineChartInstance) {
            lineChartInstance.draw(lineChartData, lineChartOptions);
        }
        if (monthOrderChartInstance) {
            monthOrderChartInstance.draw(monthOrderChartData, monthOrderChartOptions);
        }
        if (columnChartInstance) {
            columnChartInstance.draw(columnChartData, columnChartOptions);
        }
        if (pieChartInstance) {
            pieChartInstance.draw(pieChartData, pieChartOptions);
        }
    }

    let resizeTimer;
    let hasReloaded = false;

    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            drawAllCharts();

            const screenWidth = window.innerWidth;
            if (screenWidth <= 768 && !hasReloaded) {
                hasReloaded = true;
                location.reload();
            }
        }, 300);
    });

</script>
@endpush