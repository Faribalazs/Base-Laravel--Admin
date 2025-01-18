<x-admin-app-layout>
    <x-slot name="pageTitle">
        {{ __('app.admin.dashboard') }}
    </x-slot>
    <x-slot name="header">
        {{ __('app.admin.dashboard') }}
    </x-slot>
    <div class="flex mt-10 flex-col">
        <div class="main-container" style="overflow: auto">
            <br>Aktivni korisnici (poslednjih 5 minuta): {{ $active ?? 0}}<br><br>
            Danas prijavljeni radnici: {{ $workers ?? 0 }}<br>
            Radnici prijavljeni u poslednjih 30 dana: {{ $workers_last_30_days ?? 0 }}<br>
            Najviše poseta radnika: @if(isset($max_visit->worker)){{ $max_visit->worker->first_name.' '.$max_visit->worker->last_name }}@else{{ 'null' }}@endif klikovi: {{ $max_visit->hits ?? 0 }}<br><br>
            Ukupna poseta danas: {{ $overall_visit_today ?? 0 }}<br>
            Ukupne posete u poslednjih 30 dana: {{ $overall_visit_last_30_days ?? 0 }}<br><br>
            Danas prijavljeni nalozi sa različitim IP adresama: {{ $diff_ip ?? 0}}<br>
            Različiti IP u poslednjih 30 dana: {{ $diff_ip_last_30_days ?? 0 }}<br><br>
            
            @if ($browserType + $deviceType)
                <div class="container">
                    @if($browserType)
                    <div id="pie-chart-browser" style="width: 900px; height: 500px"></div>
                    @endif
                    @if($deviceType)
                    <div id="pie-chart-device" style="width: 900px; height: 500px"></div>
                    @endif
                </div>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);
            
                    function drawChart() {
                        @if($browserType)
                        var data = google.visualization.arrayToDataTable([
                            ['Browser', 'Count'],    
                            ['Chrome', {{ $chrome }}],
                            ['Firefox', {{ $firefox }}],
                            ['Opera', {{ $opera }}],
                            ['Safari', {{ $safari }}],
                            ['Internet Explorer', {{ $ie }}],
                            ['Microsoft Edge', {{ $edge }}],
                            ['Nepoznat', {{ $unknown_browser }}],
                        ]);
            
                        var options = {
                            title: 'Detalji pretraživača danas (radnici) - Ukupan broj pretraživača: {{ $browserType }}',
                            is3D: true,
                        };
            
                        var chart = new google.visualization.PieChart(document.getElementById('pie-chart-browser'));
            
                        chart.draw(data, options);
                        @endif
                        @if($deviceType)
                        var data_device = google.visualization.arrayToDataTable([
                            ['Device', 'Count'],    
                            ['Desktop', {{ $desktop }}],
                            ['Mobile', {{ $mobile }}],
                            ['Tablet', {{ $tablet }}],
                            ['Bot', {{ $bot }}],
                            ['Nepoznat', {{ $unknown_device }}],
                        ]);
            
                        var options_device = {
                            title: 'Detalji uređaja danas (radnici) - Ukupan broj uređaja: {{ $deviceType }}',
                            is3D: true,
                        };

                        var chart_device = new google.visualization.PieChart(document.getElementById('pie-chart-device'));

                        chart_device.draw(data_device, options_device);
                        @endif
                    }
            
                </script>
            @endif

        </div>
    </div>
</x-admin-app-layout>