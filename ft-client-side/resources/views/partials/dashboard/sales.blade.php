@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="row p-4 text-center">
    <div class="col-md">
        <div class="card mb-1 mt-3">
            <div class="card-header bg-warning text-dark">
                Total memasukan user hari ini
            </div>
            <div class="card-body">
                <h5 class="card-title fs-3">{{ $data['totalInputUserToday'] }}</h5>
                <p class="card-text">Total memasukan user hari ini</p>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card mb-1 mt-3">
            <div class="card-header bg-info text-dark">
                Total memasukan user
            </div>
            <div class="card-body">
                <h5 class="card-title fs-3">{{ $data['totalInputUser'] }}</h5>
                <p class="card-text">Total memasukan user</p>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card mb-1 mt-3">
            <div class="card-header bg-success text-light">
                Masukan followup hari ini
            </div>
            <div class="card-body">
                <h5 class="card-title fs-3">{{ $data['totalFollowUpToday'] }}</h5>
                <p class="card-text">Total follow up user hari ini</p>
            </div>
        </div>
    </div>
</div>

<div class="p-4">
    <div class="card text-center">
        <div class="card-header">
            {{ auth()->user()->email }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ auth()->user()->full_name }}</h5>
            <p class="card-text">{{ auth()->user()->address }}</p>
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <svg class="mb-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg> Edit me
            </button>
        </div>
        <div class="card-footer text-muted">
            {{ auth()->user()->role->name }}
        </div>
    </div>
</div>

<!-- Modal Edit me -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit me</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateMe', auth()->user()->id) }}" method="post">
                    @csrf
                    <div class="mb-3 shadow-sm">
                        @error('username')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" required value="{{ auth()->user()->username }}">
                    </div>
                    <div class="mb-3 shadow-sm">
                        @error('email')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" required value="{{ auth()->user()->email }}">
                    </div>
                    <div class="mb-3 shadow-sm">
                        @error('phone_number')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" required value="{{ auth()->user()->phone_number }}">
                    </div>
                    <div class="mb-3 shadow-sm">
                        @error('address')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <label for="exampleInputEmail1" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" required value="{{ auth()->user()->address }}">
                    </div>
                    <div class="mb-3 shadow-sm">
                        @error('full_name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <label for="exampleInputEmail1" class="form-label">Fullname</label>
                        <input type="text" name="full_name" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" required value="{{ auth()->user()->full_name }}">
                    </div>
                    <div class="mb-3 shadow-sm">
                        @error('password')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <label for="exampleInputPassword1" class="form-label">New password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-dark">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- end Modal add --}}
