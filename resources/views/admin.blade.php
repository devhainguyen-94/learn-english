@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{ session('token') }}
                        </div>
                </div>
{{--                @vite(['resources/js/app.js'])--}}
            </div>
        </div>
    </div>
</div>
    <script>
        alert( '<?php echo  session('token'); ?>');
    </script>
@endsection
