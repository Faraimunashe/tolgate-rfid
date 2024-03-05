<x-guest-layout>
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Tolgate System</h5>
            <p class="text-center small">Enter your username &amp; password to login</p>
        </div>
        <x-alert/>
        <form action="{{route('login')}}" method="POST" class="row g-3 needs-validation" novalidate="">
            @csrf
            <div class="col-12">
                <label for="yourUsername" class="form-label">Email</label>
                <div class="input-group has-validation">
                    <input type="text" name="email" class="form-control" id="yourUsername" required>
                    <div class="invalid-feedback">Please enter your email.</div>
                </div>
            </div>
            <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="yourPassword" required>
                <div class="invalid-feedback">Please enter your password!</div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </div>
            <div class="col-12">
                <p class="small mb-0">Don't have account? <a href="{{route('register')}}">Create an account</a></p>
            </div>
        </form>
    </div>
</x-guest-layout>
