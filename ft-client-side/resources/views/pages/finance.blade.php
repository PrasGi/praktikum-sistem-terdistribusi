@extends('partials.index')

@section('content')
    @if (!Cache::get('status'))
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
            <div class="row justify-content-between">
                <div class="col">
                    <p class="mt-2">
                        You can't use this feature yet because you haven't paid yet
                    </p>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-outline-light" data-bs-toggle="modal"
                        data-bs-target="#paymentModal">Pay
                        now</button>
                </div>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @error('failed')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @enderror

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

    {{-- data --}}
    <div class="col-12">
        <div class="card top-selling overflow-auto">

            <div class="card-body pb-0">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">Tracking Finance <span>| now</span></h5>
                    </div>
                    <div class="col text-end">
                        @if (Cache::get('status'))
                            <button type="button" class="btn btn-dark mt-3" data-bs-toggle="modal"
                                data-bs-target="#financeModal">Add new</button>
                        @endif
                    </div>
                </div>

                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Needed</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas['datas'] as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $data['needed'] }}</td>
                                <td>Rp. {{ $data['amount'] }}</td>
                                <td>
                                    <form action="{{ route('finance.delete', $data['id']) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="{{ route('pay') }}">
                        @csrf
                        <div class="mb-3">
                            <p><b for="cvv" class="form-label">Receipt</b> Uplode image of the receipt</p>
                            <input type="file" class="form-control" id="cvv" placeholder="CVV" name="image"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- finance modal --}}
    <div class="modal fade" id="financeModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Add New Finance Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('finance.add') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="needed" class="form-label">Needed</label>
                            <input type="text" class="form-control" id="needed" name="needed" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-body')
@endsection
