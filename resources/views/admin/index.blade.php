@extends('layouts.admin')
@section('page-content')
<h1 class="mt-12">Dashboard</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Data entry progress
    </div>
</div>
<div class="container px-8 mt-12">
    <canvas id="progress_chart" height="360" width="200"></canvas>
</div>
@endsection
@section('script')
<script type="text/javascript">
    var labels = @json($labels);
    var programsCount = @json($programsCount);
    var coursesCount = @json($coursesCount);
    var teachersCount = @json($teachersCount);
    var sectionsCount = @json($sectionsCount);;

    const dataset1 = {
        label: "Programs",
        data: programsCount,
        lineTension: 0.2,
        fill: false,
        // borderWidth: 1,
        borderColor: '#DE5FF9',
        backgroundColor: '#F5D9FB',
    }
    const dataset2 = {
        label: "Courses",
        data: coursesCount,
        lineTension: 0.2,
        fill: false,
        borderColor: 'rgba(255, 99, 132, 0.8)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
    }
    const dataset3 = {
        label: "Teachers",
        data: teachersCount,
        lineTension: 0.2,
        fill: false,
        borderColor: '#03C2D8',
        backgroundColor: '#B9EFDB',
    }
    const dataset4 = {
        label: "Sections",
        data: sectionsCount,
        lineTension: 0.2,
        fill: false,
        borderColor: 'rgba(54, 162, 235, 0.8)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
    }

    var chartDataset = {
        labels: labels,
        datasets: [dataset1, dataset2, dataset3, dataset4]
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
            indexAxis: 'y',
            borderWidth: 1,
            maintainAspectRatio: false,

        },

    };

    const myChart = new Chart(
        document.getElementById('progress_chart'),
        config
    );
</script>
@endsection