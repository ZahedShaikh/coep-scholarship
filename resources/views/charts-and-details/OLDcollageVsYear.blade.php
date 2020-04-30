@extends('multiauth::layouts.app') 
@section('content')


{!! $chart->container() !!}
<script src="{{ $chart->cdn() }}"></script>
{!! $chart->script() !!}



