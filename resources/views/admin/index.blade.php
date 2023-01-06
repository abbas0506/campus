@extends('layouts.admin')
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
    var programsCount = @json($programsCount);
    var coursesCount = @json($coursesCount);
    var teachersCount = @json($teachersCount);

    const dataset1 = {
        label: "Programs",
        data: programsCount,
        lineTension: 0.2,
        fill: false,
        borderColor: 'red',
        // backgroundColor: 'rgb(200, 99, 132)',
    }
    const dataset2 = {
        label: "Courses",
        data: coursesCount,
        lineTension: 0.2,
        fill: false,
        borderColor: 'blue'
    }
    const dataset3 = {
        label: "Teachers",
        data: teachersCount,
        lineTension: 0.2,
        fill: false,
        borderColor: 'green'
    }

    var chartDataset = {
        labels: labels,
        datasets: [dataset1, dataset2, dataset3]
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
        type: 'line',
        data: chartDataset,
        options: {
            responsive: true,
            scales: {
                x: {
                    ticks: {
                        display: false
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