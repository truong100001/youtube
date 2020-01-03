@extends('master')

@section('content')
    @include('components.header_moblie')
    @include('components.header')
    @include('components.menu')
    @include('components.dashboard.content')

@endsection


@section('script')
    <script>
        var date = null;
        var view = null;
        var myChart = null;
        function  chart() {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('#token').attr('content')
                },
                url: "{{ asset('/statistical') }}",
                method: 'post',
                data: {

                },
                success: function(data){

                    date = data.map((element,index,data) => {
                        return element.date;
                    });
                    view = data.map((element,index,data) => {
                        return element.view;
                    });

                    try {
                        //line chart
                        var ctx = document.getElementById("lineChartView");
                        if (ctx) {
                            ctx.height = 150;
                            myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: date,
                                    defaultFontFamily: "Poppins",
                                    datasets: [
                                        {
                                            label: "view",
                                            borderColor: "rgba(0, 123, 255, 0.9)",
                                            borderWidth: "1",
                                            backgroundColor: "rgba(0, 123, 255, 0.5)",
                                            pointHighlightStroke: "rgba(26,179,148,1)",
                                            data: view
                                        }
                                    ]
                                },
                                options: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            fontFamily: 'Poppins'
                                        }

                                    },
                                    responsive: true,
                                    tooltips: {
                                        mode: 'index',
                                        intersect: false
                                    },
                                    hover: {
                                        mode: 'nearest',
                                        intersect: true
                                    },
                                    scales: {
                                        xAxes: [{
                                            ticks: {
                                                fontFamily: "Poppins"

                                            }
                                        }],
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                                fontFamily: "Poppins"
                                            }
                                        }]
                                    }

                                }
                            });
                        }


                    } catch (error) {
                        console.log(error);
                    }
                },
                error: function(error)
                {

                }
            });
        }
        chart();
    </script>


@endsection