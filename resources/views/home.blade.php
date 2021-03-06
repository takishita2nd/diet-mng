@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <weight-dashboard-component></weight-dashboard-component>
                    <p></p>
                    <eating-dashboard-component></eating-dashboard-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
