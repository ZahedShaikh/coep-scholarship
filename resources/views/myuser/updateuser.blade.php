@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update / Edit marks </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif


                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('myuserupdate') }}">
                        @csrf


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                                       value="{{ $info->name }}" autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('middleName') }}</label>
                            <div class="col-md-6">
                                <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" 
                                       value="{{ $info->middleName }}" autocomplete="middleName" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surName" class="col-md-4 col-form-label text-md-right">{{ __('surName') }}</label>
                            <div class="col-md-6">
                                <input id="surName" type="text" class="form-control @error('surName') is-invalid @enderror" name="surName" 
                                       value="{{ $info->surName }}" autocomplete="surName" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                            <div class="col-md-6">
                                <select id="category" name="category" class="form-control">
                                    <option value="OPEN"  {{ ( $info->category == "OEPN" ) ? 'selected' : '' }} >Open</option>
                                    <option value="OBC"  {{ ( $info->category == "OBC" ) ? 'selected' : '' }} >OBC</option>
                                    <option value="EWS"  {{ ( $info->category == "EWS" ) ? 'selected' : '' }} >EWS</option>
                                    <option value="SC"  {{ ( $info->category == "SC" ) ? 'selected' : '' }} >SC</option>
                                    <option value="ST"  {{ ( $info->category == "ST" ) ? 'selected' : '' }} >ST</option>
                                    <option value="SBC"  {{ ( $info->category == "SBC" ) ? 'selected' : '' }} >SBC</option>
                                    <option value="VJ"  {{ ( $info->category == "VJ" ) ? 'selected' : '' }} >VJ</option>
                                    <option value="NT-1"  {{ ( $info->category == "NT-1" ) ? 'selected' : '' }} >NT-1</option>
                                    <option value="NT-2"  {{ ( $info->category == "NT-2" ) ? 'selected' : '' }} >NT-2</option>
                                    <option value="NT-3"  {{ ( $info->category == "NT-3" ) ? 'selected' : '' }} >NT-3</option>
                                    <option value="ECBC"  {{ ( $info->category == "ECBC" ) ? 'selected' : '' }} >ECBC</option>
                                    <option value="OTHER"  {{ ( $info->category == "OTHER" ) ? 'selected' : '' }} >Other</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>
                            <div class="col-md-6">
                                <select id="gender" name="gender" class="form-control" required autofocus>
                                    <option value="male"  {{ ( $info->gender == "male" ) ? 'selected' : '' }} >Male</option>
                                    <option value="female"  {{ ( $info->gender == "female" ) ? 'selected' : '' }} >Female</option>
                                    <option value="other"  {{ ( $info->gender == "other" ) ? 'selected' : '' }} >Other</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="college" class="col-md-4 col-form-label text-md-right">{{ __('College Name') }}</label>
                            <div class="col-md-6">
                                <select id="college" name="college" class="form-control" required autofocus>

                                    <option value="coep" {{ ( $info->college == "coep" ) ? 'selected' : '' }} >College of Engineering Pune</option>
                                    <option value="gpp" {{ ( $info->college == "gpp" ) ? 'selected' : '' }} >Government Polytechnic Pune</option>
                                    <option value="gcoer" {{ ( $info->college == "gcoer" ) ? 'selected' : '' }} >government college of engineering and research avasari</option>
                                    <option value="gcoek" {{ ( $info->college == "gcoek" ) ? 'selected' : '' }} >government college of engineering karad</option>
                                    <option value="gpa" {{ ( $info->college == "gpa" ) ? 'selected' : '' }} >government polytechnic awasari</option>

                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="contact" class="col-md-4 col-form-label text-md-right">{{ __('contact') }}</label>
                            <div class="col-md-6">
                                <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" 
                                       value="{{ $info->contact }}" autocomplete="contact" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                                <a href="javascript:history.back()" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
