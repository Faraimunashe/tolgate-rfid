<x-guest-layout>
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Tolgate System</h5>
            <p class="text-center small">Here is where you can scan your RFID here..</p>
        </div>
        <x-alert/>
        <form action="{{route('tolgate')}}" method="POST" class="row g-3 needs-validation" novalidate="">
            @csrf
            <div class="col-12">
                <label for="code" class="form-label">Scan here</label>
                <div class="input-group has-validation">
                    <input type="text" name="code" class="form-control" id="code" autofocus required>
                    <div class="invalid-feedback">Please enter your rfid.</div>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
