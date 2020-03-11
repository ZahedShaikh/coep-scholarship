@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    @include('message')
                   
                    <ol class="list-group">

                        <div class="float-right">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <label for="updateuserinfo" class="col-md-6 col-form-label text-md-right">{{ __('Update Your Details') }}</label>
                                <a href="{{ route('updateuserinfo') }}" class="btn btn-group-toggle btn-primary mr-3">Edit</a>
                            </li>
                        </div>


                        <div class="float-right">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <label for="semester" class="col-md-6 col-form-label text-md-right">{{ __('Update Semester Marks') }}</label>
                                <a href="{{ route('marks') }}" class="btn btn-group-toggle btn-primary mr-3">Edit</a>
                            </li>
                        </div>


                        <div class="float-right">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <label for="banks" class="col-md-6 col-form-label text-md-right">{{ __('Update Bank Details') }}</label>
                                <a href="{{ route('banks') }}" class="btn btn-group-toggle btn-primary mr-3">Edit</a>
                            </li>
                        </div>


                        <div class="float-right">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <label for="semester" class="col-md-6 col-form-label text-md-right">{{ __('') }}</label>
                                <a href="{{ route('profileprint') }}" class="btn btn-group-toggle btn-primary mr-3">Print Your Application</a>
                            </li>
                        </div>

                    </ol>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
