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
        label: "Department Statistics",
        data: data,
        lineTension: 0,
        fill: false,
        borderColor: 'green',
        backgroundColor: '#A0D8C9',
    }

    var chartDataset = {
        labels: labels,
        datasets: [dataset1],
    };

    var chartOptions = {
        legend: {
            display: true,
            position: 'top',
            labels: {
                boxWidth: 80,
                fontColor: 'black'
            }
        }
    };

    // const data = {
    //     labels: labels,
    //     datasets: [{
    //         label: 'Programs',
    //         backgroundColor: 'rgb(200, 99, 132)',
    //         borderColor: 'rgb(255, 99, 132)',
    //         data: programsCount,
    //     }]
    // };



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