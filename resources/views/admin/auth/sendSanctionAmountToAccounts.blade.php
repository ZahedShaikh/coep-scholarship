@extends('multiauth::layouts.appToSearch')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('multiauth.prefix')) }}: You have <span id="total_records"></span> students to sanction scholarship amount</div>

                <br>
                <div class="form-group col-md-4">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Student"/>
                </div>

                <div class="table-responsive" id='tableID'>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Form ID</th>
                                <th>Name</th>
                                <th>College</th>
                                <th>Contact</th>
                                <th>Amount</th>
                                <th>Accept</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-5 offset-md-7">
                        <a href="{{ route('sanctionAllApplications') }}" class="btn btn-primary success">Sanction Remaining All Applications</a>
                        <a href="javascript:history.back()" class="btn btn-primary">Back</a>

                    </div>
                </div>
                <br>

            </div>
        </div>
    </div>

</div>



<script type="text/javascript">

    $(document).ready(function () {

        /* 
         * Function to retrive/fetch students with sanction amount status
         * 
         */
        fetch_customer_data();

        function fetch_customer_data(query = '')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('showSanctionAmount') }}",
                method: "GET",
                contentType: "application/json; charset=utf-8",
                data: {query: query},
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

        $(document).on('keyup', '#search', function () {
            var query = $(this).val();
            fetch_customer_data(query);
        });


        /* 
         * Function to Sanction Amount
         * 
         */


        function assignScholarshipFunction(msg)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('sendSanctionAmount') }}",
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
