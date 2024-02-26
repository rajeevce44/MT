@extends('app')

@section('content')
    <div class="container">
        <h1 class="mt-5 mb-4">Stock Quotes Submission Form</h1>

        <form action="{{ route('submitForm') }}" method="post" id="myForm">
            @csrf

            <!-- Symbol Dropdown -->
            <div class="form-group">
                <label for="symbol">Company Symbol:</label>
                <select class="form-control @error('symbol') is-invalid @enderror" name="symbol" id="symbol" required>
                    <!-- Options will be dynamically added here -->
                </select>
                @error('symbol') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <!-- Start Date -->
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="text" class="form-control datepicker @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{ old('start_date') }}" autocomplete="off" required>
                @error('start_date') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <!-- End Date -->
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="text" class="form-control datepicker @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ old('end_date') }}" autocomplete="off" required>
                @error('end_date') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" autocomplete="off" required>
                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
        $(function () {
            // Fetch symbols from the provided URL
            $.getJSON('https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json', function (data) {
                var symbolDropdown = $('#symbol');
                symbolDropdown.append('<option value="">--Select--</option>');
                $.each(data, function (index, company) {
                    symbolDropdown.append('<option value="' + company.Symbol + '">' + company.Symbol + '</option>');
                });
            });

            // Enable datepicker on the specified input fields
            $(".datepicker").datepicker({
                beforeShowDay: function (date) {
                    var endDate = $("#end_date").datepicker("getDate");
                    var currentDate = new Date();

                    // Disable dates in the future
                    return [date <= currentDate];
                },
                maxDate: 0  // Set maxDate to disable selecting future dates
            });

            // Add custom validation using jQuery
            $("#myForm").submit(function (event) {
                var startDate = $("#start_date").datepicker("getDate");
                var endDate = $("#end_date").datepicker("getDate");
                var currentDate = new Date();

                // Validate Start Date
                if (!startDate || startDate > currentDate || startDate > endDate) {
                    alert("Start date should be less than or equal to the end date and less than or equal to the current date");
                    event.preventDefault();
                    return;
                }

                // Validate End Date
                if (!endDate || endDate > currentDate || endDate < startDate) {
                    alert("End date should be greater than or equal to the start date and less than or equal to the current date.");
                    event.preventDefault();
                    return;
                }
            });
        });
    </script>
@endsection
