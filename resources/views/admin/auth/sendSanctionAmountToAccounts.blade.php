@extends('admin.layout.appToSearch')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('auth.prefix')) }}: You have <span id="total_records"></span> students to sanction scholarship amount</div>

                <br>
                <div class="form-group col-md-4">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Student"/>
                </div>

                <div id='tableID' align='center'>
                    <table class="table table-hover table-responsive"  id='mytableID'>
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>College</th>
                                <th>Contact</th>
                                <th style="width:  35%">Status</th>
                                <th>Amount (INR)</th>
                                <th>Accept</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div class="form-group row mb-0">
                    <div class="offset-md-9">
                        <a href="{{ route('sanctionAllApplications') }}" class="btn btn-primary success">Sanction All Applications</a>
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
        function assignScholarshipFunction(msg, amount, for_Sem)
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
                data: {query_id: msg, query_amount: amount, query_for_Sem:for_Sem},
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
                console.log(msg);
                var currentRow = $(this).closest("tr");
                var amount = currentRow.find("td:eq(5)").text();
                var for_Sem = currentRow.find("td:eq(4)").text();
                //alert(for_Sem);
                assignScholarshipFunction(msg, amount, for_Sem);
            };
        })(jQuery);
    });

</script>

@endsection
