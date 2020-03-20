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

                    <form method="POST" action="{{ route('marksupdate') }}">
                        @csrf

                         <div class="form-group row">
                            <label for="ssc" class="col-md-4 col-form-label text-md-right">{{ __('SSC') }}</label>
                            <div class="col-md-6">
                                <input id="ssc" type="text" class="form-control @error('ssc') is-invalid @enderror" name="ssc" 
                                       value="{{ $marks['ssc_hsc']->ssc }}" autocomplete="ssc" autofocus required {{ $freeze[0] }}>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="hsc" class="col-md-4 col-form-label text-md-right">{{ __('HSC') }}</label>
                            <div class="col-md-6">
                                <input id="hsc" type="text" class="form-control @error('HSC') is-invalid @enderror" name="hsc" 
                                       value="{{ $marks['ssc_hsc']->hsc }}" autocomplete="hsc" autofocus {{ $freeze[0] }}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Diploma" class="col-md-4 col-form-label text-md-right">{{ __('Diploma') }}</label>
                            <div class="col-md-6">
                                <input id="diploma" type="text" class="form-control @error('diploma') is-invalid @enderror" name="diploma" 
                                       value="{{ $marks['ssc_hsc']->diploma }}" autocomplete="diploma" autofocus {{ $freeze[0] }}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester1" class="col-md-4 col-form-label text-md-right">{{ __('Semester 1') }}</label>
                            <div class="col-md-6">
                                <input id="semester1" type="text" class="form-control @error('middleName') is-invalid @enderror" name="semester1" 
                                       value="{{ $marks['ug_marks']->semester1 }}" autocomplete="semester1" autofocus {{ $freeze[0] }}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester2" class="col-md-4 col-form-label text-md-right">{{ __('Semester 2') }}</label>
                            <div class="col-md-6">
                                <input id="semester2" type="text" class="form-control @error('middleName') is-invalid @enderror" name="semester2" 
                                       value="{{ $marks['ug_marks']->semester2 }}" autocomplete="semester2" autofocus {{ $freeze[1] }}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester3" class="col-md-4 col-form-label text-md-right">{{ __('Semester 3') }}</label>
                            <div class="col-md-6">
                                <input id="semester3" type="text" class="form-control @error('middleName') is-invalid @enderror" name="semester3" 
                                       value="{{ $marks['ug_marks']->semester3 }}" autocomplete="semester3" autofocus {{ $freeze[2] }}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester4" class="col-md-4 col-form-label text-md-right">{{ __('Semester 4') }}</label>
                            <div class="col-md-6">
                                <input id="semester4" type="text" class="form-control @error('middleName') is-invalid @enderror" name="semester4" 
                                       value="{{ $marks['ug_marks']->semester4 }}" autocomplete="semester4" autofocus {{ $freeze[3] }}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester5" class="col-md-4 col-form-label text-md-right">{{ __('Semester 5') }}</label>
                            <div class="col-md-6">
                                <input id="semester5" type="text" class="form-control @error('middleName') is-invalid @enderror" name="semester5" 
                                       value="{{ $marks['ug_marks']->semester5 }}" autocomplete="semester5" autofocus {{ $freeze[4] }}>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester6" class="col-md-4 col-form-label text-md-right">{{ __('Semester 6') }}</label>
                            <div class="col-md-6">
                                <input id="semester6" type="text" class="form-control @error('middleName') is-invalid @enderror" name="semester6" 
                                       value="{{ $marks['ug_marks']->semester6 }}" autocomplete="semester6" autofocus {{ $freeze[5] }}>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="semester7" class="col-md-4 col-form-label text-md-right">{{ __('Semester 7') }}</label>
                            <div class="col-md-6">
                                <input id="semester7" type="text" class="form-control @error('middleName') is-invalid @enderror" name="semester7" 
                                       value="{{ $marks['ug_marks']->semester7 }}" autocomplete="semester7" autofocus {{ $freeze[6] }}>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="semester8" class="col-md-4 col-form-label text-md-right">{{ __('Semester 8') }}</label>
                            <div class="col-md-6">
                                <input id="semester8" type="text" class="form-control @error('middleName') is-invalid @enderror" name="semester8" 
                                       value="{{ $marks['ug_marks']->semester8 }}" autocomplete="semester8" autofocus {{ $freeze[7] }}>
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
