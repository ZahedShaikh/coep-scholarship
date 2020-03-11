@extends('multiauth::layouts.app') 
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('multiauth.prefix')) }}</div>

                
                {!! $chart->container() !!}
                <script src="{{ $chart->cdn() }}"></script>
                {{ $chart->script() }}


                <div class="form-group row mb-0">
                    <div class="col-md-5 offset-md-10">
                        <a href="javascript:history.back()" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <br>

            </div>
        </div>
    </div>

</div>
@endsection