@extends('partials.index')

@section('content')
    {{-- data --}}
    <div class="col-12">
        <div class="card top-selling overflow-auto">

            <div class="card-body pb-0">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title">Tracker Order <span>| user</span></h5>
                    </div>
                    <div class="col text-end">
                        @if (Cache::get('status'))
                            <button type="button" class="btn btn-dark mt-3" data-bs-toggle="modal"
                                data-bs-target="#paymentModal">Add new</button>
                        @endif
                    </div>
                </div>

                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">User Id</th>
                            <th scope="col">Image</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $data['user_id'] }}</td>
                                <td>
                                    <img src="{{ $data['image'] }}" alt="" style="width: 100px">
                                </td>
                                <td>{{ \Carbon\Carbon::parse($data['created_at'])->format('j F Y') }}</td>
                                <td>
                                    <form action="{{ route('confirm') }}" method="post">
                                        @csrf
                                        <input type="text" value="{{ $data['id'] }}" name="id" hidden>
                                        <button type="submit" class="btn btn-primary">Comfirm</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>
@endsection
