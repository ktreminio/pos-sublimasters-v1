<div>
    <!doctype html>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ __(ucfirst(str_replace('-', ' ', Request::path()))) }} - {{ config('app.name', 'Laravel') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">
    </head>
    <body>
        <main class="main-content">
            <div class="admin" style="background-image:url({{ asset('assets/img/admin-bg-light.png') }});">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-8">
                            <div class="my-5">
                                <div class="edit-profile__logos">
                                    <img class="dark" src="{{ asset('assets/img/logo-dark.png') }}" alt="">
                                    <img class="light" src="{{ asset('assets/img/logo-white.png') }}" alt="">
                                </div>
                                <div class="card border-0">
                                    <div class="card-header">
                                        <div class="edit-profile__title">
                                            <h6>Sign in HexaDash</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form wire:submit.prevent="login">
                                            <div class="edit-profile__body">
                                                <div class="form-group mb-20">
                                                    <label for="email">Email Address</label>
                                                    <input wire:model.lazy="email" type="email" class="form-control" id="email" name="email" placeholder="Email address" />
                                                    @error('email')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-15">
                                                    <label for="password-field">Password</label>
                                                    <div class="position-relative">
                                                        <input wire:model.lazy="password" id="password-field" type="password" class="form-control" name="password" placeholder="Password" />
                                                        <span toggle="#password-field" class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2"></span>
                                                    </div>
                                                    @error('password')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="admin-condition">
                                                    <div class="checkbox-theme-default custom-checkbox ">
                                                        <input wire:model="remember_me" class="checkbox" type="checkbox" id="remember_me">
                                                        <label for="remember_me">
                                                            <span class="checkbox-text">Keep me logged in</span>
                                                        </label>
                                                    </div>
                                                    <a href="{{ route('forget_password') }}">forget password?</a>
                                                </div>
                                                <div class="admin__button-group button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                    <button type="submit" class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal px-50 signIn-createBtn ">
                                                        sign in
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div id="overlayer">
            <div class="loader-overlay">
                <div class="dm-spin-dots spin-lg">
                    <span class="spin-dot badge-dot dot-primary"></span>
                    <span class="spin-dot badge-dot dot-primary"></span>
                    <span class="spin-dot badge-dot dot-primary"></span>
                    <span class="spin-dot badge-dot dot-primary"></span>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.min.js') }}"></script>
    </body>
    </html>
</div>
