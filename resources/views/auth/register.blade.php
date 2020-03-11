@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('Middle Name') }}</label>
                            <div class="col-md-6">
                                <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ old('middleName') }}" autocomplete="middleName" autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="surName" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>
                            <div class="col-md-6">
                                <input id="surName" type="text" class="form-control @error('name') is-invalid @enderror" name="surName" value="{{ old('surname') }}" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                            <div class="col-md-6">
                                <select id="category" name="category" class="form-control">
                                    <option disabled=""></option>
                                    <option value="OPEN">Open</option>
                                    <option value="OBC">OBC</option>
                                    <option value="eWS">EWS</option>
                                    <option value="SC">SC</option>
                                    <option value="ST">ST</option>
                                    <option value="SBC">SBC</option>
                                    <option value="VJ">VJ</option>
                                    <option value="NT-1">NT-1</option>
                                    <option value="NT-2">NT-2</option>
                                    <option value="NT-3">NT-3</option>
                                    <option value="ECBC">ECBC</option>
                                    <option value="OTHER">Other</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                            <div class="col-md-6">
                                <select id="gender" name="gender" class="form-control" required autofocus>
                                    <option disabled="" selected=""></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="college" class="col-md-4 col-form-label text-md-right">{{ __('College Name') }}</label>
                            <div class="col-md-6">
                                <select id="college" name="college" class="form-control" required autofocus>
                                    <option disabled="" selected=""></option>

                                    <option value="coep">College of Engineering Pune</option>
                                    <option value="gpp">Government Polytechnic Pune</option>
                                    <option value="gcoer">government college of engineering and research avasari</option>
                                    <option value="gcoek">government college of engineering karad</option>
                                    <option value="gpa">government polytechnic awasari</option>

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="collegeEnrollmentNo" class="col-md-4 col-form-label text-md-right">{{ __('College Enrollment No') }}</label>
                            <div class="col-md-6">
                                <input id="collegeEnrollmentNo" type="text" class="form-control @error('collegeEnrollmentNo') is-invalid @enderror" name="collegeEnrollmentNo" value="{{ old('collegeEnrollmentNo') }}" required autocomplete="collegeEnrollmentNo" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="yearOfAdmission" class="col-md-4 col-form-label text-md-right">{{ __('Year of admission') }}</label>
                            <div class="col-md-6 input-group date" data-provide="datepicker">
                                <input id="yearOfAdmission" name="yearOfAdmission" type="text" class="form-control">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact" class="col-md-4 col-form-label text-md-right">{{ __('Contact') }}</label>
                            <div class="col-md-6">
                                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection