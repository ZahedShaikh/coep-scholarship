@extends('multiauth::layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(config('multiauth.prefix')) }} Dashboard</div>

                <div class="card-body">
                    You are logged in to {{ config('multiauth.prefix') }} side!
                    @include('multiauth::message')
                </div>

                <ol class="list-group">

                    <div class="float-right">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <label for="getNewApplications" class="col-md-6 col-form-label text-md-right">{{ __('Sanction New Applications') }}</label>
                            <a href="{{ route('getNewApplications') }}" class="btn btn-group-toggle btn-primary mr-3">Sanction</a>
                        </li>
                    </div>

                    <div class="float-right">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <label for="getSanctionAmount" class="col-md-6 col-form-label text-md-right">{{ __('Sanction Scholarship Amount') }}</label>
                            <a href="{{ route('getSanctionAmount') }}" class="btn btn-group-toggle btn-primary mr-3">Sanction</a>
                        </li>
                    </div>
 
                    <div class="float-right">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <label for="displayStudentDetails" class="col-md-6 col-form-label text-md-right">{{ __('Display All Student Details') }}</label>
                            <a href="{{ route('getAllStudentsDetails') }}" class="btn btn-group-toggle btn-primary mr-3">Show</a>
                        </li>
                    </div>
                    
                    
                    <div class="float-right">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <label for="displayAll" class="col-md-6 col-form-label text-md-right">{{ __('Display All') }}</label>
                            <a href="{{ route('chart') }}" class="btn btn-group-toggle btn-primary mr-3">Show</a>
                        </li>
                    </div>
                    
                    

                </ol>

            </div>
        </div>
    </div>
</div>
@endsection