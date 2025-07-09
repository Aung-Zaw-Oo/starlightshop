@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
    <style>
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

        /* Breadcrumb Bar */
        .breadcrumb-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .breadcrumb-left span {
            color: var(--color-8);
            font-weight: 500;
            margin-right: 5px;
        }

        .breadcrumb-left span:last-child {
            margin-right: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--btn-primary) 0%, #8b5cf6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: .5fr 1fr 1fr;
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

        /* KPI Cards */
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

        /* Chart Cards - New Grid Layout */
        .line-chart-card,
        .income-chart-card {
            grid-column: span 3;
        }

        .pie-chart-card,
        .browser-table-card {
            grid-column: span 1;
        }

        .pie-chart-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .pie-chart-section .pie-placeholder {
            height: 200px;
        }

        .browser-table-card .table-placeholder {
            height: 200px;
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
            background: rgba(59, 130, 246, 0.2);
            border-radius: 4px;
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

        .pie-chart-section {
            display: grid;
            grid-template-columns: auto;
            gap: 20px;
        }

        .pie-placeholder {
            background: rgba(245, 158, 11, 0.1);
            border-radius: 8px;
            border: 2px dashed rgba(245, 158, 11, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f59e0b;
            font-size: 14px;
        }

        .legend-placeholder {
            display: flex;
            /* flex-direction: column; */
            gap: 12px;
            justify-content: center;
        }

        .legend-item {
            /* height: 24px; */
            background: rgba(139, 92, 246, 0.1);
            border-radius: 4px;
            border: 1px dashed rgba(139, 92, 246, 0.3);
        }

        /* Bar Chart and Table */
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

        /* Responsive Layouts */
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
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .legend-placeholder {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .breadcrumb-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
                margin-bottom: 20px;
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
                display: flex;
                flex-direction: column;
                gap: 15px;
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
            .pie-placeholder,
            .bar-chart-placeholder,
            .table-placeholder {
                height: 150px;
                font-size: 12px;
            }

            .legend-placeholder {
                flex-direction: column;
            }
        }

        rect {
            fill: none;
            display: none;
        }
    </style>
@endpush

@section('content')

    <!-- Breadcrumb Bar -->
    <div class="breadcrumb-bar">
        <div class="breadcrumb-left">
            <span><i class="fa-solid fa-house"></i> Home</span>
            <span> > </span>
            <span>Dashboard</span>
        </div>
        
        <div class="user-info">
            <div class="user-avatar">7D</div>
            <span>M</span>
        </div>
    </div>

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
                <div class="chart-icon"></div>
                <h3 class="chart-title">Order Count</h3>
            </div>
            <div class="chart-placeholder">
                Line Chart Area - Add your chart component here
            </div>
        </div>

        <!-- Row 2: Pie Chart Section -->
        <div class="card chart-card">
            <div class="pie-chart-section">
                <div>
                    <div class="pie-placeholder">
                            <div id="piechart"></div>
                    </div>
                </div>
                <div class="legend-placeholder">
                    <div class="legend-item">
                        Box 1
                    </div>
                    <div class="legend-item">
                        Box 2
                    </div>
                    <div class="legend-item">
                        Box 3
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Bar Chart -->
        <div class="card chart-card income-chart-card">
            <div class="chart-header">
                <div class="chart-icon"></div>
                <h3 class="chart-title">Income Profit</h3>
            </div>
            <div class="bar-chart-placeholder">
                Bar Chart Area - Add your chart component here
            </div>
        </div>

        <!-- Row 3: Browser Stats Table -->
        <div class="card table-card">
            <div class="table-header">
                <h3 class="chart-title">Browser Stats</h3>
            </div>
            <div class="table-placeholder">
                Table Area - Add your table component here
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Devices', 'Count'],
          ['Mobile', {{11}}],
          ['Desktop', 2],
          ['Tablet', 2]
        ]);

        var options = {
        //   title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
@endpush