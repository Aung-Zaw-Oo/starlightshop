@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* ================================
       Root Variables
    ================================= */
    :root {
        --color-1: #0f172a;
        --color-2: #1e293b;
        --color-3: #334155;
        --color-4: #475569;
        --color-5: #64748b;
        --color-6: #94a3b8;
        --color-7: #cbd5e1;
        --color-8: #e2e8f0;

        --btn-primary: #3b82f6;
        --btn-primary-hover: #2563eb;

        --success-bg: #065f46;
        --success-text: #d1fae5;
        --success-border: #059669;

        --error-bg: #7f1d1d;
        --error-text: #fecaca;
        --error-border: #dc2626;

        --info-bg: #1e3a8a;
        --info-text: #dbeafe;
        --info-border: #3b82f6;
    }

    /* ================================
       Dashboard Grid & Cards
    ================================= */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: 0.5fr 1fr 1fr;
        gap: 20px;
        margin: 0 auto;
        height: 100vh;
    }
    .card {
        background: var(--color-2);
        border-radius: 8px;
        padding: 24px;
        border: 1px solid var(--color-8);
        transition: background-color 0.2s ease;
    }
    .clickable-card {
        cursor: pointer;
    }
    .clickable-card:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    /* ================================
       KPI Cards
    ================================= */
    .kpi-card {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .kpi-icon.income {
        background: rgba(59, 130, 246, 0.2);
        color: var(--btn-primary);
    }
    .kpi-icon.orders {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
    }
    .kpi-icon.profit {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
    }
    .kpi-icon.signup {
        background: rgba(139, 92, 246, 0.2);
        color: #8b5cf6;
    }
    .kpi-content h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--btn-primary);
    }
    .kpi-content p {
        color: var(--color-6);
        font-size: 14px;
    }

    /* ================================
       Chart Cards
    ================================= */
    .chart-card {
        display: flex;
        flex-direction: column;
    }
    .chart-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }
    .chart-icon {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--btn-primary);
        font-size: 1.25rem;
    }
    .chart-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--color-8);
    }
    .chart-placeholder {
        height: 200px;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 8px;
        border: 2px dashed rgba(59, 130, 246, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--btn-primary);
        font-size: 14px;
    }
    .bar-chart-placeholder {
        height: 250px;
        background: rgba(16, 185, 129, 0.1);
        border-radius: 8px;
        border: 2px dashed rgba(16, 185, 129, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 14px;
    }

    /* ================================
       Table Section
    ================================= */
    .table-card {
        grid-column: span 1;
    }
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--color-8);
    }
    .table-placeholder {
        height: 250px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: 8px;
        border: 2px dashed rgba(239, 68, 68, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        font-size: 14px;
    }

    /* ================================
       Pie Chart Section
    ================================= */
    .pie-chart-section {
        display: grid;
        grid-template-columns: auto;
        gap: 20px;
    }
    #piechart,
    #linechart {
        width: 100%;
        margin: 0 auto;
    }
    #piechart {
        max-width: 300px;
        height: 250px;
    }
    #linechart {
        max-width: 100%;
        height: 300px;
    }
    #linechart > div {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: hidden;
        margin: 0 auto;
    }
    #piechart div,
    #linechart div {
        display: flex;
        justify-content: center;
    }
    .legend-placeholder {
        display: flex;
        gap: 10px;
        justify-content: center;
    }
    .legend-item {
        width: 70px;
    }

    /* ================================
       Chart Grid Layouts
    ================================= */
    .line-chart-card,
    .income-chart-card {
        grid-column: span 3;
    }
    .pie-chart-card,
    .browser-table-card {
        grid-column: span 1;
    }

    /* ================================
       Browser Table Styling
    ================================= */
    .browser-table-wrapper {
        overflow-x: auto;
    }
    .browser-table {
        width: 100%;
        border-collapse: collapse;
        color: var(--color-8);
        font-size: 14px;
    }
    .browser-table th,
    .browser-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid var(--color-4);
    }
    .browser-table th {
        background-color: var(--color-2);
        color: var(--color-6);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .browser-table tr:hover {
        background-color: rgba(255, 255, 255, 0.03);
    }
    .browser-table i {
        color: var(--btn-primary);
    }

    /* ================================
       Responsive Layout
    ================================= */
    @media (max-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: auto;
        }
        .line-chart-card,
        .income-chart-card,
        .chart-card,
        .table-card {
            grid-column: span 2;
        }
        .pie-chart-section {
            grid-template-columns: 1fr;
        }
        .legend-placeholder {
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: 15px;
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .line-chart-card,
        .income-chart-card,
        .chart-card,
        .table-card {
            grid-column: span 1;
        }

        .pie-chart-section {
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .card {
            padding: 16px;
        }

        .kpi-content h3 {
            font-size: 20px;
        }

        .kpi-icon {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
        }

        .chart-placeholder,
        .bar-chart-placeholder,
        .table-placeholder {
            height: 150px;
            font-size: 12px;
        }
        
        .legend-placeholder {
            flex-direction: row;
        }
    }
</style>
@endpush

@section('content')
    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
        <!-- Row 1: KPI Cards -->
        <div class="card kpi-card clickable-card">
            <div class="kpi-icon income">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div class="kpi-content">
                <h3>{{ number_format($totalIncome, 2) }}</h3>
                <p>Income</p>
            </div>
        </div>

        <div class="card kpi-card clickable-card">
            <div class="kpi-icon orders">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div class="kpi-content">
                <h3>{{ $orderCount }}</h3>
                <p>Order Count</p>
            </div>
        </div>

        <div class="card kpi-card clickable-card">
            <div class="kpi-icon profit">
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>
            <div class="kpi-content">
                <h3>{{ number_format($totalProfit, 2) }}</h3>
                <p>Profit</p>
            </div>
        </div>

        <div class="card kpi-card clickable-card">
            <div class="kpi-icon signup">
                <i class="fa-solid fa-file-pen"></i>
            </div>
            <div class="kpi-content">
                <h3>{{ $signupCount }}</h3>
                <p>Sign Up</p>
            </div>
        </div>

        <!-- Row 2: Line Chart -->
        <div class="card chart-card line-chart-card">
            <div class="chart-header">
                <div class="chart-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                <h3 class="chart-title">Order Count</h3>
            </div>
            <div>
                <div id="linechart"></div>
            </div>
        </div>

        <!-- Row 2: Pie Chart Section -->
        <div class="card chart-card">
            <div class="pie-chart-section">
                <div>
                    <div id="piechart"></div>
                </div>
                <div class="legend-placeholder" id="legend-placeholder"></div>
            </div>
        </div>

        <!-- Row 3: Column Chart -->
        <div class="card chart-card income-chart-card">
            <div class="chart-header">
                <div class="chart-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
                <h3 class="chart-title">Income Profit</h3>
            </div>
            <div>
                <div id="columnchart"></div>
            </div>
        </div>

        <!-- Row 3: Browser Stats Table -->
        <div class="card table-card">
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
                var color = colors[i];
                
                // Create legend item element
                var legendItem = document.createElement('div');
                legendItem.className = 'legend-item';
                legendItem.setAttribute('data-slice', i);
                
                legendItem.innerHTML = `
                    <div 
                        style="text-align:center; 
                        background-color: ${color}; 
                        border-radius: 10px; 
                        padding: 5px; 
                        max-width: 100px;
                        font-weight: bold;"
                    >
                        <span class="legend-value">${value}</span>
                        <br>
                        <span class="legend-text">${label}</span>
                    </div>
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
            }, 200);
        });
    </script>
@endpush