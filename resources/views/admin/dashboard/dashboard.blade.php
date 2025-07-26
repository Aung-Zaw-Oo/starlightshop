@extends('admin.layout.layout')

@section('title', 'Dashboard')

@push('styles')

@endpush

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
        <!-- Income -->
        <div class="card kpi-card">
            <div class="kpi-card-left">
                <i class="fa-solid fa-chart-line"></i>
                <span>Income</span>
            </div>
            <!-- Total Income -->
            <div class="kpi-card-right" id="total-income" style="display: none;">
                @if ($totalIncome >= 1000000)
                    <span>$ {{ number_format($totalIncome / 1000000, 2) }}M</span>
                @elseif ($totalIncome >= 1000)
                    <span>$ {{ number_format($totalIncome / 1000, 2) }}K</span>
                @else
                    <span>$ {{ number_format($totalIncome, 2) }}</span>
                @endif    
            </div>
            <!-- This Week -->
            <div class="kpi-card-right" id="income-this-week" style="display: flex;">
                @if ($incomeThisWeek >= 1000000)
                    <span>$ {{ number_format($incomeThisWeek / 1000000, 2) }}M</span>
                @elseif ($incomeThisWeek >= 1000)
                    <span>$ {{ number_format($incomeThisWeek / 1000, 2) }}K</span>
                @else
                    <span>$ {{ number_format($incomeThisWeek, 2) }}</span>
                @endif    
            </div>
        </div>

        <!-- Order Count -->
        <div class="card kpi-card">
            <div class="kpi-card-left">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Order Count</span>
            </div>
            <div class="kpi-card-right">
                <span id="total-order" style="display: none;">{{ $totalOrder }}</span>
                <span id="order-this-week" style="display: flex;">{{ $orderThisWeek }}</span>
            </div>
        </div>

        <!-- Profit -->
        <div class="card kpi-card">
            <div class="kpi-card-left">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span>Profit</span>
            </div>
            <!-- Total -->
            <div class="kpi-card-right" id="total-profit" style="display: none;">
                @if ($totalProfit >= 1000000)
                    <span>$ {{ number_format($totalProfit / 1000000, 2) }}M</span>
                @elseif ($totalProfit >= 1000)
                    <span>$ {{ number_format($totalProfit / 1000, 2) }}K</span>
                @else
                    <span>$ {{ number_format($totalProfit, 2) }}</span>
                @endif    
            </div>
            <!-- This Week -->
            <div class="kpi-card-right" id="profit-this-week" style="display: flex;">
                @if ($profitThisWeek >= 1000000)
                    <span>$ {{ number_format($profitThisWeek / 1000000, 2) }}M</span>
                @elseif ($profitThisWeek >= 1000)
                    <span>$ {{ number_format($profitThisWeek / 1000, 2) }}K</span>
                @else
                    <span>$ {{ number_format($profitThisWeek, 2) }}</span>
                @endif    
            </div>
        </div>

        <!-- Sign Up -->
        <div class="card kpi-card">
            <div class="kpi-card-left">
                <i class="fa-solid fa-chart-line"></i>
                <span>Sign Up</span>
            </div>
            <div class="kpi-card-right">
                <span style="display: none;" id="total-signup">{{ $totalSignup }}</span>
                <span style="display: flex;" id="signup-this-week">{{ $signupThisWeek }}</span>
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
                <div id="weeklyColumnchart"></div>
                <div id="monthlyColumnchart" style="display: none;"></div>
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

        // Line charts
        document.getElementById('linechart').style.display = 'flex';
        document.getElementById('monthlyOrderChart').style.display = 'none';

        // Column charts
        document.getElementById('weeklyColumnchart').style.display = 'flex';
        document.getElementById('monthlyColumnchart').style.display = 'none';

        // KPI cards
        document.getElementById('total-income').style.display = 'none';
        document.getElementById('income-this-week').style.display = 'flex';

        document.getElementById('total-order').style.display = 'none';
        document.getElementById('order-this-week').style.display = 'flex';

        document.getElementById('total-profit').style.display = 'none';
        document.getElementById('profit-this-week').style.display = 'flex';
        
        document.getElementById('total-signup').style.display = 'none';
        document.getElementById('signup-this-week').style.display = 'flex';

        // Fade effects
        fadeInChart('linechart');
        fadeOutChart('monthlyOrderChart');
        fadeInChart('weeklyColumnchart');
        fadeOutChart('monthlyColumnchart');
        
        weeklyColumnChart();
        lineChart();
    });

    monthlyBtn.addEventListener('click', function () {
        // Button UI toggle
        monthlyBtn.classList.add('primary');
        monthlyBtn.classList.remove('secondary');
        weeklyBtn.classList.add('secondary');
        weeklyBtn.classList.remove('primary');

        // Chart visibility
        document.getElementById('linechart').style.display = 'none';
        document.getElementById('monthlyOrderChart').style.display = 'flex';
        document.getElementById('weeklyColumnchart').style.display = 'none';
        document.getElementById('monthlyColumnchart').style.display = 'flex';

        // KPI cards
        document.getElementById('total-income').style.display = 'flex';
        document.getElementById('income-this-week').style.display = 'none';
        document.getElementById('total-order').style.display = 'flex';
        document.getElementById('order-this-week').style.display = 'none';
        document.getElementById('total-profit').style.display = 'flex';
        document.getElementById('profit-this-week').style.display = 'none';
        document.getElementById('total-signup').style.display = 'flex';
        document.getElementById('signup-this-week').style.display = 'none';

        // Fade
        fadeOutChart('linechart');
        fadeInChart('monthlyOrderChart');
        fadeOutChart('weeklyColumnchart');
        fadeInChart('monthlyColumnchart');

        monthlyColumnChart();
        monthlyOrderChart();
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
    let weeklyColumnChartInstance;
    let weeklyColumnChartData;
    let weeklyColumnChartOptions;
    let monthlyColumnChartInstance;
    let monthlyColumnChartData;
    let monthlyColumnChartOptions;

    google.charts.load('current', {'packages':['corechart']});
    google.charts.load('current', {'packages':['bar']});

    google.charts.setOnLoadCallback(lineChart);
    google.charts.setOnLoadCallback(pieChart);
    google.charts.setOnLoadCallback(weeklyColumnChart);

    // Line Chart
    function lineChart() {
        const orderChartData = @json($ordersPerDay);

        lineChartData = new google.visualization.DataTable();
        lineChartData.addColumn('string', 'Day');
        lineChartData.addColumn('number', 'Orders');
        lineChartData.addColumn('number', 'Orders');

        lineChartData.addRows(orderChartData);

        lineChartOptions = {
            animation: {
                startup: true,
                duration: 1200,
                easing: 'inAndOut'
            },

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
            animation: {
                startup: true,
                duration: 1200,
                easing: 'inAndOut'
            },
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
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            },
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

    // Weekly Column Chart
    function weeklyColumnChart() {
        const weeklyChartData = @json($weeklyChartData);

        const data = [['Day', 'Income', 'Expenses'], ...weeklyChartData];

        weeklyColumnChartData = google.visualization.arrayToDataTable(data);

        weeklyColumnChartOptions = {
            animation: {
                startup: true,
                duration: 1200,
                easing: 'inAndOut'
            },
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

        weeklyColumnChartInstance = new google.visualization.ColumnChart(document.getElementById('weeklyColumnchart'));
        weeklyColumnChartInstance.draw(weeklyColumnChartData, weeklyColumnChartOptions);
    }

    // Monthly Column Chart
    function monthlyColumnChart() {
        const monthlyChartData = @json($monthlyChartData);

        const data = [['Month', 'Income', 'Expenses'], ...monthlyChartData];

        monthlyColumnChartData = google.visualization.arrayToDataTable(data);

        monthlyColumnChartOptions = {
            animation: {
                startup: true,
                duration: 1200,
                easing: 'inAndOut'
            },
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

        monthlyColumnChartInstance = new google.visualization.ColumnChart(document.getElementById('monthlyColumnchart'));
        monthlyColumnChartInstance.draw(monthlyColumnChartData, monthlyColumnChartOptions);
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

    function drawAllCharts() 
    {
        if (lineChartInstance && document.getElementById('linechart').style.display !== 'none') {
            lineChartInstance.draw(lineChartData, lineChartOptions);
        }

        if (monthOrderChartInstance && document.getElementById('monthlyOrderChart').style.display !== 'none') {
            monthOrderChartInstance.draw(monthOrderChartData, monthOrderChartOptions);
        }

        if (weeklyColumnChartInstance && document.getElementById('weeklyColumnchart').style.display !== 'none') {
            weeklyColumnChartInstance.draw(weeklyColumnChartData, weeklyColumnChartOptions);
        }

        if (monthlyColumnChartInstance && document.getElementById('monthlyColumnchart').style.display !== 'none') {
            monthlyColumnChartInstance.draw(monthlyColumnChartData, monthlyColumnChartOptions);
        }

        if (pieChartInstance && document.getElementById('piechart').style.display !== 'none') {
            pieChartInstance.draw(pieChartData, pieChartOptions);
        }
    }


    let resizeTimer;

    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            drawAllCharts();

            const screenWidth = window.innerWidth;
            const hasReloaded = sessionStorage.getItem('hasReloaded');

            if (screenWidth <= 768 && hasReloaded !== 'true') {
                sessionStorage.setItem('hasReloaded', 'true');
                location.reload();
            }
        }, 0);
    });

    const resizeObserver = new ResizeObserver(() => {
        drawAllCharts();
    });

    resizeObserver.observe(mainContent);

    function fadeInChart(id) {
        const el = document.getElementById(id);
        el.style.opacity = 0;
        el.style.display = 'block';
        setTimeout(() => {
            el.style.transition = 'opacity 0.6s ease-in-out';
            el.style.opacity = 1;
        }, 50);
    }

    function fadeOutChart(id) {
        const el = document.getElementById(id);
        el.style.transition = 'opacity 0.3s ease-in-out';
        el.style.opacity = 0;
        setTimeout(() => {
            el.style.display = 'none';
        }, 300);
    }
</script>
@endpush