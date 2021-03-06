@extends('accountant.layout.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ucfirst(config('auth.prefix')) }} Dashboard</div>

                <div class="card-body">
                    You are logged in to {{ config('auth.prefix') }} side!
                    @include('message')
                </div>

                <ol class="list-group">
                    <div class="float-right">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <label for="getAmountToBeCredit" class="col-md-6 col-form-label text-md-right">{{ __('Scholarship Credited') }}</label>
                            <a href="{{ route('getAmountToBeCredit') }}" class="btn btn-group-toggle btn-primary mr-3">Sanction</a>
                        </li>
                    </div>

                    <div class="float-right">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <label for="transactionHistory" class="col-md-6 col-form-label text-md-right">{{ __('Transaction History by Accountant') }}</label>
                            <a href="{{ route('transactionHistory') }}" class="btn btn-group-toggle btn-primary mr-3">Show</a>
                        </li>
                    </div>
                </ol>

            </div>
        </div>
    </div>
</div>
@endsection