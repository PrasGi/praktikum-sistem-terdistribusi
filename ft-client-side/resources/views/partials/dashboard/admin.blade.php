@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="row p-4 text-center">
    <div class="col-md">
        <div class="card mb-2 mt-2">
            <div class="card-header bg-warning text-dark">
                Total masukan user hari ini
            </div>
            <div class="card-body">
                <h5 class="card-title fs-3">{{ $data['totalInputUserToday'] }}</h5>
                <p class="card-text">Total input <svg class="mb-1" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg> hari ini</p>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card mb-2 mt-2">
            <div class="card-header bg-info text-dark">
                Total memasukan user
            </div>
            <div class="card-body">
                <h5 class="card-title fs-3">{{ $data['totalInputUser'] }}</h5>
                <p class="card-text">Total memasukan <svg class="mb-1" xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg></p>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card mb-2 mt-2">
            <div class="card-header bg-success text-light">
                Masukan follow up hari ini
            </div>
            <div class="card-body">
                <h5 class="card-title fs-3">{{ $data['totalFollowUpToday'] }}</h5>
                <p class="card-text">Total follow up <svg class="mb-1" xmlns="http://www.w3.org/2000/svg"
                        width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                    </svg> hari ini</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <p class="card-title">
            <b>Marketing Chart</b> (buyer)
        </p>

        <!-- Bar Chart -->
        <div id="barChart"></div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#barChart"), {
                    series: [{
                        data: {!! json_encode($users) !!}
                    }],
                    chart: {
                        type: 'bar',
                        height: 250
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: true,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: {!! json_encode($xaxis->pluck('full_name')) !!}
                    }
                }).render();
            });
        </script>

        <!-- End Bar Chart -->

    </div>
</div>

{{-- <div class="row justify-content-center mt-5">
    <div class="col-5">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ auth()->user()->username }}</h5>
                        <p class="card-text">{{ auth()->user()->role->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
