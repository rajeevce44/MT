@extends('app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Stock Quotes for Symbol: {{ $symbol }}</h1>

        @if (!empty($quotes))
            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Open</th>
                            <th>High</th>
                            <th>Low</th>
                            <th>Close</th>
                            <th>Volume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotes as $quote)
                            <tr>
                                <td>{{ $quote['date'] }}</td>
                                <td>{{ $quote['open'] }}</td>
                                <td>{{ $quote['high'] }}</td>
                                <td>{{ $quote['low'] }}</td>
                                <td>{{ $quote['close'] }}</td>
                                <td>{{ $quote['volume'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <p class="mb-0">No quotes available for the specified symbol.</p>
            </div>
        @endif
    </div>
@endsection
