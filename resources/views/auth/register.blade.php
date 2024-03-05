<x-guest-layout>
    <div class="card-body">
        <div class="pt-4 pb-2">
            <p class="text-center small">Register your account credintials.</p>
        </div>
        <x-alert/>
        <form action="{{route('register')}}" method="POST" class="row g-3 needs-validation" novalidate="">
            @csrf
            <div class="col-12">
                <label for="yourUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <input type="text" name="name" class="form-control" id="yourUsername" placeholder="Username" required>
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>
            </div>
            <div class="col-12">
                <label for="yourUsername" class="form-label">Email</label>
                <div class="input-group has-validation">
                    <input type="email" name="email" class="form-control" id="yourUsername" placeholder="user@campany.com" required>
                    <div class="invalid-feedback">Please enter your email.</div>
                </div>
            </div>
            <div class="col-12">
                <label for="yourUsername" class="form-label">Phone</label>
                <div class="input-group has-validation">
                    <input type="tel" name="phone" class="form-control" id="yourUsername" placeholder="+263783540959" required>
                    <div class="invalid-feedback">Please enter your phone.</div>
                </div>
            </div>
            <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="yourPassword" placeholder="Password" required>
                <div class="invalid-feedback">Please enter your password!</div>
            </div>
            <div class="col-12">
                <label for="yourPassword" class="form-label">Password Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" id="yourPassword" placeholder="Confim password" required>
                <div class="invalid-feedback">Please enter your password confirmation!</div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Register</button>
            </div>
            <div class="col-12">
                <p class="small mb-0">Already have an account? <a href="{{route('login')}}">Login</a></p>
            </div>
        </form>
    </div>
</x-guest-layout>
