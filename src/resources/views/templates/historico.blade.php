@extends('layouts.main')

@section('content')

    <section class="col-md-10 col-md-offset-1">

        <table class="table table-striped table-hover">

            <thead>
                <tr>
                    <tr>Id.</tr>
                </tr>
            </thead>

            <tbody>
                @foreach ($historicos as $h)
                    <tr>
                        <td>{{ $h->id }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </section>

@endsection
