@extends('partials.index')

@section('content')
    {{-- cards --}}
    <div class="row mt-4">
        {{-- per month --}}
        <div class="col-xxl-6 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Total Current Month <span>| Finance</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cash"></i>
                        </div>
                        <div class="ps-3">
                            <h6> <b>Rp. </b>{{ $month }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- per year --}}
        <div class="col-xxl-6 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Total All <span>| Finance</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cash"></i>
                        </div>
                        <div class="ps-3">
                            <h6> <b>Rp. </b>{{ $all }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- charts --}}
    <div class="card-body">
        <h5 class="card-title">Total Finance <span>/Year</span></h5>

        <!-- Line Chart -->
        <div id="reportsChart"></div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#reportsChart"), {
                    series: [{
                        name: 'Amount',
                        data: @json($chartData)
                    }],
                    chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                            show: false
                        },
                    },
                    markers: {
                        size: 4
                    },
                    colors: ['#ff771d'],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    xaxis: {
                        type: 'text',
                        categories: @json($chartCategories)
                    },
                    tooltip: {
                        x: {
                            format: 'dd/MM/yy HH:mm'
                        },
                    }
                }).render();
            });
        </script>
        <!-- End Line Chart -->

    </div>
@endsection
