@extends('multiauth::layouts.appToSearch')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ ucfirst(config('multiauth.prefix')) }} Dashboard</div>

                <br>
                <div class="form-group col-md-4">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Student"/>
                </div>

                <div class="table-responsive">
                    <h3 align="center">Total Data : <span id="total_records"></span></h3>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Contact</th>
                                <th>Assign</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-3 offset-md-10">

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

        fetch_customer_data();

        function fetch_customer_data(query = '')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('live_search.action') }}",
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
         $(document).on('keyup', '#search', function () {
         var query = $(this).val();
         fetch_customer_data(query);
         });
         */
    });
</script>

@endsection
