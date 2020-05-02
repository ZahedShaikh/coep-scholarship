@extends('admin.layout.appToSearch')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

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

                <div class="form-group col-md-3 row">
                    <label for="category" text-md-right">{{ __('Select College') }}</label>

                    <select class="selectpicker" id="my-select" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true">
<!--                    <select class="selectpicker" multiple data-live-search="true" id="my-select">-->
                        <option value="coep">coep</option>
                        <option value="gpp">gpp</option>
                    </select>
                </div>

                <br><br><br><br><br><br>


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

        //  Dynamic selection of college
        $("#my-select").change(function () {
            var selectedValue = $(this).val();
            myFunction(selectedValue);
        });

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

    function myFunction(selectedValue) {
        var filter, table, tr, td, i, txtValue, j;
        table = document.getElementById("tableID");
        tr = table.getElementsByTagName("tr");

        var flg = true;
        for (i = 1; i < tr.length; i++) {
            flg = true;
            td = tr[i].getElementsByTagName("td")[2];
            if (td) {
                txtValue = td.textContent || td.innerText;
                for (j = 0; j < selectedValue.length; j++) {
                    filter = selectedValue[j].toUpperCase();
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        flg = false;
                        break;
                    }
                }

                if (flg) {
                    tr[i].style.display = "none";
                }
            }
        }
    }

</script>


<script>
    $('.my-select').selectpicker();
</script>

@endsection
