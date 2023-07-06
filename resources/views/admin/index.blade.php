@extends('layouts.admin')
@section('page-content')
<div class="flex flex-col justify-center items-center w-full h-full">
    <div class="flex flex-col items-center justify-center w-3/4">

        <h1 class="text-2xl text-blue-900">Welcome Admin</h1>
        <p class="text-center mt-4">Here you can manage departments, their headship, and course types. You can also control user access, lock and unlock the semesters etc.</p>
        <div class="grid grid-cols-3 gap-5 mt-12">
            <a href="{{url('coursetypes')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bi bi-diamond text-xl"></i>
                <div class="mt-3">Course Types</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('semesters')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bi bi-gear text-xl"></i>
                <div class="mt-3">Semester Control</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
            <a href="{{url('user-access')}}" class="flex flex-col justify-center items-center h-32 w-40 rounded-lg bg-sky-200">
                <i class="bi bi-people text-xl"></i>
                <div class="mt-3">Access Control</div>
                <div class="text-sm font-thin text-slate-600 hidden">10</div>
            </a>
        </div>
    </div>


</div>

<!-- <h1>Dashboard</h1>
<div class="flex items-center justify-between flex-wrap">
    <div class="bread-crumb">
        Data entry progress
    </div>
</div>
<div class="container px-8 mt-12">
    <canvas id="progress_chart" height="360" width="200"></canvas>
</div> -->
@endsection
@section('script')
<script type="text/javascript">
    var labels = @json($labels);
    var programs = @json($programs);
    var courses = @json($courses);

    var clases = @json($clases);
    var sections = @json($sections);
    var students = @json($students);

    const dataset1 = {
        label: "Programs",
        data: programs,
        lineTension: 0.2,
        fill: false,
        // borderWidth: 1,
        borderColor: '#DE5FF9',
        backgroundColor: '#F5D9FB',
    }
    const dataset2 = {
        label: "Courses",
        data: courses,
        lineTension: 0.2,
        fill: false,
        borderColor: 'rgba(255, 99, 132, 0.8)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
    }
    // const dataset3 = {
    //     label: "Teachers",
    //     data: teachers,
    //     lineTension: 0.2,
    //     fill: false,
    //     borderColor: 'rgba(213, 176, 59, 0.8)',
    //     backgroundColor: 'rgba(213, 176, 59, 0.2)',
    // }
    const dataset4 = {
        label: "Sections",
        data: sections,
        lineTension: 0.2,
        fill: false,
        borderColor: 'rgba(54, 162, 235, 0.8)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
    }
    const dataset5 = {
        label: "Students",
        data: students,
        lineTension: 0.2,
        fill: false,
        borderColor: 'rgba(58, 199, 176, 0.8)',
        backgroundColor: 'rgba(58, 199, 176, 0.2)',
    }

    var chartDataset = {
        labels: labels,
        datasets: [dataset1, dataset2, dataset4, dataset5]
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