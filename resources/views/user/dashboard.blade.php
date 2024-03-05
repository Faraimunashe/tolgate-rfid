<x-app-layout>
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            @foreach ($vehicles as $vehicle)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $vehicle->make }} {{ $vehicle->model }}</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">REG#: <code>{{ $vehicle->regnum }}</code></li>
                                <li class="list-group-item">BALANCE: ${{ $vehicle->balance }}</li>
                                <li class="list-group-item">TOL CLASS: {{ get_tolclass($vehicle->type_id) }}</li>
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-primary btn-sm" style="float: right" data-bs-toggle="modal" data-bs-target="#addTopup{{$vehicle->id}}">
                                        Topup
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="addTopup{{$vehicle->id}}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('transactions.store') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Topup Vehicle Balance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}" required>
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Amount:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="amount" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Ecocash/OneMoney:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="phone" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($vehicles->isEmpty())
                <div class="alert alert-info" role="alert">
                    You have no registered vehicles at the moment!
                </div>
            @endif
        </div>
    </section>
    <section class="section mt-3">
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addVehicle">
                    <i class="bi bi-truck"></i>
                    Register Vehicle
                </button>
            </div>
        </div>
    </section>
    <div class="modal fade" id="addVehicle" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('vehicle.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Make:</label>
                            <div class="col-sm-10">
                                <input type="text" name="make" class="form-control" placeholder="e.g Toyota" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Model:</label>
                            <div class="col-sm-10">
                                <input type="text" name="model" class="form-control" placeholder="e.g Hilux GD6" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Reg#:</label>
                            <div class="col-sm-10">
                                <input type="text" name="regnum" class="form-control" placeholder="ACB 1234" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Tol Class:</label>
                            <div class="col-sm-10">
                                <select name="type_id" class="form-control" required>
                                    <option selected disabled>Select Tol Class</option>
                                    @foreach (\App\Models\Type::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Scan Plate:</label>
                            <div class="col-sm-10">
                                <input type="text" name="code" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
