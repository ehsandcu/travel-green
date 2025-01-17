@extends('layouts.main')
@section('content')
    <div class="hero hero-inner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mx-auto text-center">
                    <div class="intro-wrap">
                        <h1 class="mb-0">CO2 Emission</h1>
                        <p class="text-white">Curious about your carbon footprint? You’ve come to the right place! Our CO2 Emission page is here to help you understand the environmental impact of your daily commute. By calculating the carbon dioxide emissions from your travel, you can see how your choices affect the planet and explore greener alternatives. It’s simple, insightful, and designed to inspire change. Take the first step toward reducing your emissions and join us in creating a more sustainable future!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="untree_co-section">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-6 col-lg-12">
                    <div class="card shadow rounded">
                        <div class="card-body" id="carbon-emission-report" data-route="{{ route('all.campuses_graph.data') }}">
                            <div id="campuses_chart" class="custom-chart text-center"></div>
                        </div>
                    </div>  
                </div>                
            </div>
        </div>
    </div>
@stop
@section('script')
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>

    <script>        
        var emissionSelector = "#campuses_chart";
        
        $(document).ready(function() {
            emissionGraph();
        });
        
        function emissionGraph() {
            $.ajax({
                url: $("#carbon-emission-report").attr("data-route"),
                type: "POST",
                cache: false,
                data: {},
                success: function (result) {
                    $(emissionSelector).html(''); //remove old divs before chart    

                    if (result.success) {
                        var graphData = result.data;
                        var monthList = result.month_list;
                        var currentYear = result.year;

                        console.log(result);
                        var options = {
                            series: graphData,
                            chart: {
                                height: 450,
                                type: 'line',
                                zoom: {
                                    enabled: false
                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                width: [5, 7, 5],
                                curve: 'straight',
                                dashArray: [0, 8, 5]
                            },
                            title: {
                                text: 'CO2 Emission: '+ currentYear,
                                align: 'left'
                            },
                            legend: {
                                tooltipHoverFormatter: function(val, opts) {
                                    return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
                                }
                            },
                            markers: {
                                size: 0,
                            hover: {
                                sizeOffset: 6
                            }
                            },
                            xaxis: {
                                categories: monthList,
                            },
                            grid: {
                                borderColor: '#f1f1f1',
                            }
                        };
    
                        var chart = new ApexCharts(document.querySelector(emissionSelector), options);
                        chart.render();
                        
                    } else {
                        console.log(result);
                        $(emissionSelector).html('<img class="h-280" src="../images/icon/statistic-transparent.png">');
                    }
                }
            });
        }
    </script>
@stop