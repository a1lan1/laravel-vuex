@extends('layouts.app')

@section('content')
    @role('admin')
    <users-list :route="'{{ route('api.users') }}'"></users-list>
    @else
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Main Page</div>

                    <div class="card-body">
                        <h3>Hello, {{ auth()->user()->name }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole
@endsection
