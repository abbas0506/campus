@extends('layouts.hod')
@section('page-content')
<h1 class="mt-12">Dashboard</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Data entry progress
    </div>
</div>
<div class="container px-8 mt-12">
    <canvas id="progress_chart" height="300" width="200"></canvas>
</div>
@endsection
@section('script')
<script type="text/javascript">
    var labels = @json($labels);
    var data = @json($data);
    const dataset1 = {
        label: "Count",
        data: data,
        lineTension: 0,
        fill: false,
        borderWidth: 1,
        borderColor: 'rgba(20,100,50,0.6)',
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)', // Bar 1
            'rgba(54, 162, 235, 0.2)', // Bar 2
            'rgba(255, 206, 86, 0.2)', // Bar 3
            'rgba(75, 192, 192, 0.2)', // Bar 4
            'rgba(153, 102, 255, 0.2)', // Bar 5
            'rgba(255, 159, 64, 0.2)' // Bar 6
        ],
    }

    var chartDataset = {
        labels: labels,
        datasets: [dataset1],
    };

    var chartOptions = {
        legend: {
            display: false,
            position: 'top',
            labels: {
                boxWidth: 80,
                fontColor: 'black'
            }
        }
    };

    const config = {
        type: 'bar',
        data: chartDataset,
        options: {
            responsive: true,
            scales: {
                x: {
                    ticks: {
                        display: true
                    }
                }
            },
            borderWidth: 2,
            maintainAspectRatio: false,

        },

    };

    const myChart = new Chart(
        document.getElementById('progress_chart'),
        config
    );
</script>
@endsection