@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* Breadcrumb */
    .dashboard-breadcrumb {
        height: 50px;
        display: grid;
        align-items: center;
        grid-template-columns: repeat(2, 1fr);
        margin-bottom: 20px;
    }

    .dashboard-beadcrumb-right {
        margin-left: auto;
    }

    .dashboard-beadcrumb-center {
        margin-left: center;
        display: none;
    }

    .dashboard-beadcrumb-left {
        margin-right: auto;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--gap);
    }

    /* Card */
    .card {
        background-color: var(--bg-dark);
        border-radius: var(--radius);
        padding: var(--padding);
        transition: var(--transition);
    }

    .card:hover{
        box-shadow: var(--shadow);
    }

    .kpi-card {
        display: flex;
        justify-content: space-between;
    }    

    .kpi-card-left{
        display: flex;
        flex-direction: column;
        gap: calc(var(--gap) * 2);
    }
    
    .kpi-card-left i {
        font-size: 1.5rem;
        color: var(--primary);
    }
    
    .kpi-card-right{
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: end;
        color: var(--primary);
    }
    
    .kpi-card-right span:first-child {
        font-size: 1rem;
        font-weight: bold;
    }

    /* Charts */
    .chart-card .chart-header i {
        color: var(--primary);
        font-size: 1.5rem;
        margin-right: calc(var(--margin) / 2);
    }

    .line-chart-card, .column-chart-card {
        grid-column: span 3;
    }

    .pie-chart-card {
        grid-column: span 1;
    }

    .legend-placeholder {
        display: flex;
        justify-content: center;
        gap: var(--gap);
        text-align: center;
    }

    .legend-placeholder .legend-item {
        width: calc(100% / 3.25);
        background-color: var(--primary);
        padding: calc(var(--padding) / 4) calc(var(--padding) / 3);
        border-radius: var(--radius);
        font-size: .75rem;
    }

    .browser-stats-table {
        grid-column: span 1;
        border-collapse: collapse;
    }

    .browser-stats-table tr {
        border-top: 3px solid var(--bg-light);
        border-bottom: 3px solid var(--bg-light);
    }

    .browser-stats-table th,
    .browser-stats-table td {
        text-align: left;
        padding: var(--padding);
    }



    /* Button */
    .btn {
        padding: calc(var(--padding) / 2) calc(var(--padding) / 1.5);
        cursor: pointer;
        outline: none;
        border-radius: 10px;
        border: none;
        font-size: 1rem;
        font-weight: bold;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .primary {
        background-color: var(--primary);
        color: var(--text-white);
    }

    .primary:hover {
        background-color: var(--primary-hover);
    }

    .secondary {
        background-color: var(--secondary);
        color: var(--text-white);
    }

    /* Responsive */
    @media screen and (max-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .chart-card {
            grid-column: span 2;
        }

        .legend-placeholder .legend-item {
            width: calc(100% / 5.25);
        }
    }

    @media screen and (max-width: 600px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .chart-card {
            grid-column: span 1;
        }
    }
</style>
@endpush

@section('content')

    <!-- Breadcrumb -->
    <div class="dashboard-breadcrumb">
        <div class="dashboard-beadcrumb-left">
            <span><i class="fa-solid fa-house"></i> Home</span>
            <span> > </span>
            <span>Dashboard</span>
        </div>
        <div class="dashboard-beadcrumb-center">
            <!-- NA -->
        </div>
        <div class="dashboard-beadcrumb-right">
            <button class="btn primary">7D</button>
            <button class="btn secondary">M</button>
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
        <table class="card chart-card browser-stats-table">
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
                        <i class="fa-brands fa-chrome"></i>
                        <span>Chrome</span>
                    </td>
                    <td>100</td>
                    <td>50%</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa-brands fa-firefox"></i>
                        <span>Firefox</span>
                    </td>
                    <td>50</td>
                    <td>25%</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa-brands fa-safari"></i>
                        <span>Safari</span>
                    </td>
                    <td>50</td>
                    <td>25%</td>
                </tr>
            </tbody>
        </table>


        <!-- Row 2: Line Chart -->

        <!-- Row 2: Pie Chart Section -->
        <!-- <div class="card chart-card">
            <div class="pie-chart-section">
                <div>
                    <div id="piechart"></div>
                </div>
                <div class="legend-placeholder" id="legend-placeholder"></div>
            </div>
        </div> -->

        <!-- Row 3: Column Chart -->
        <!-- <div class="card chart-card income-chart-card">
            <div class="chart-header">
                <div class="chart-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
                <h3 class="chart-title">Income Profit</h3>
            </div>
            <div>
                <div id="columnchart"></div>
            </div>
        </div> -->

        <!-- Row 3: Browser Stats Table -->
        <!-- <div class="card table-card">
            <div class="table-header">
                <h3 class="chart-title">Browser Stats</h3>
            </div>
            <div class="browser-table-wrapper">
                <table class="browser-table">
                    <thead>
                        <tr>
                            <th>Browser</th>
                            <th>Visits</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fa-brands fa-chrome"></i> &nbsp; Chrome</td>
                            <td>50</td>
                            <td>33%</td>
                        </tr>
                        <tr>
                            <td><i class="fa-brands fa-firefox"></i> &nbsp; Firefox</td>
                            <td>50</td>
                            <td>33%</td>
                        </tr>
                        <tr>
                            <td><i class="fa-brands fa-safari"></i> &nbsp; Safari</td>
                            <td>50</td>
                            <td>33%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->
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
            lineChartData = new google.visualization.DataTable();
            lineChartData.addColumn('string', 'Day');
            lineChartData.addColumn('number', 'Orders');   // For the line
            lineChartData.addColumn('number', 'Orders');   // For the points

            lineChartData.addRows([
                ['Mon', 5, 5],
                ['Tue', 6, 6],
                ['Wed', 8, 8],
                ['Thur', 7, 7],
                ['Fri', 9, 9],
                ['Sat', 10, 10],
                ['Sun', 8, 8],
            ]);

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
            columnChartData = google.visualization.arrayToDataTable([
                ['Month', 'Income', 'Expenses'],
                ['Jan', 1100, 450],
                ['Feb', 1250, 520],
                ['Mar', 980, 610],
                ['Apr', 1040, 430],
                ['May', 890, 390],
                ['Jun', 1350, 720],
                ['Jul', 760, 300],
                ['Aug', 970, 510],
                ['Sep', 880, 460],
                ['Oct', 1190, 690],
                ['Nov', 1070, 540],
                ['Dec', 930, 400]
            ]);

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