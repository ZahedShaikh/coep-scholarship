@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update / Edit banks </div>

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



                    <form method="POST" action="{{ route('bankupdate') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="bank_Name" class="col-md-4 col-form-label text-md-right">{{ __('Bank Name') }}</label>
                            <div class="col-md-6">
                                <input id="bank_Name" type="text" class="form-control @error('middleName') is-invalid @enderror" name="bank_Name" 
                                       value="{{ $banks->bank_Name }}" autocomplete="bank_Name" autofocus>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="account_No" class="col-md-4 col-form-label text-md-right">{{ __('Account No') }}</label>
                            <div class="col-md-6">
                                <input id="account_No" type="text" class="form-control @error('middleName') is-invalid @enderror" name="account_No" 
                                       value="{{ $banks->account_No }}" autocomplete="account_No" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="IFSC_Code" class="col-md-4 col-form-label text-md-right">{{ __('IFSC Code') }}</label>
                            <div class="col-md-6">
                                <input id="IFSC_Code" type="text" class="form-control @error('middleName') is-invalid @enderror" name="IFSC_Code" 
                                       value="{{ $banks->IFSC_Code }}" autocomplete="IFSC_Code" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="branch" class="col-md-4 col-form-label text-md-right">{{ __('Branch') }}</label>
                            <div class="col-md-6">
                                <input id="branch" type="text" class="form-control @error('middleName') is-invalid @enderror" name="branch" 
                                       value="{{ $banks->branch }}" autocomplete="branch" autofocus>
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
