@extends('admin.layout.appToSearch')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('auth.prefix')) }}: You have <span id="total_records"></span> New Applications</div>
                <br>

                <div class="form-group col-md-3 row">
                    <label for="category" text-md-right">{{ __('From') }}</label>
                    <label for="category" text-md-right">{{ __('To') }}</label>
                </div>
                <div class="form-group col-md-3 row">
                    <select id="from" name="category" class="form-control">

                    </select>

                    <select id="to" name="category" class="form-control">

                    </select>
                </div>


                <div class="table-responsive" id='tableID'>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Form ID</th>
                                <th>Name</th>
                                <th>College</th>
                                <th>Direct-S year</th>
                                <th>Category</th>
                                <th>Gender</th>
                                <th>Current-Year</th>
                                <th>Contact</th>
                                <th>More Details</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div class="form-group row">
                    <div class="col-md-10 offset-md-1">
                        <a href="javascript:history.back()" class="btn btn-primary float-right">Back</a>
                    </div>
                </div>
                <br>

            </div>
        </div>
    </div>

</div>


<script type="text/javascript">

    $(document).ready(function () {

        var currentYear = (new Date).getFullYear();
        var option = '';
        for (var i = 2015; i < currentYear; i++) {
            option += '<option value="' + i + '">' + i + '</option>';
        }
        option += '<option value="' + currentYear + '" selected="">' + currentYear + '</option>';
        $('#from').append(option);
        $('#to').append(option);

        // Call for defualt current year
        fetch_customer_data(currentYear, currentYear);

        // Call for givan year
        function fetch_customer_data(from, to)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('showAllStudentsDetails') }}",
                method: "GET",
                contentType: "application/json; charset=utf-8",
                data: {from: from, to: to},
                dataType: "json",
                success: function (data)
                {
                    $('tbody').html(data.table_data);
                    $('#total_records').text(data.total_data);
                },
                error: function (data) {
                    console.log(data.status + " " + data.statusText);
                }
            });
        }

        $('#from, #to').change(function () {
            var from = $('#from').val();
            var to = $('#to').val();
            //console.log(from + " " + to);
            if (from > to) {
                alert('Enter correct year');
            } else {
                fetch_customer_data(from, to);
            }
        });




        function assignScholarshipFunction(msg)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('assignScholarships') }}",
                method: "GET",
                contentType: "application/json; charset=utf-8",
                data: {query: msg},
                dataType: "json",
                success: function (data)
                {
                    if (data) {
                        var str1 = 'table#tableID tr#';
                        var str = str1.concat(msg);
                        $(str).remove();
                        location.reload(true);
                    } else {
                        console.log('Not saved');
                    }

                },
                error: function (data) {
                    console.log(data.status + " " + data.statusText);
                }
            });
        }

        (function ($) {
            $.fn.assign = function (msg) {
                assignScholarshipFunction(msg);
            };
        })(jQuery);

    });

</script>

@endsection
