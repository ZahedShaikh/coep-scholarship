@extends('admin.layout.appToSearch')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script src="{{ asset('/js/bootstrap-datepicker.min.js') }}" defer></script>
<link href="{{ asset('/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('auth.prefix')) }}</div>
                <br>

                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label class="font-weight-bold" for="from">From</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input id="from" name="from" type="text" class="form-control">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="font-weight-bold" for="to">to</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input id="to" name="to" type="text" class="form-control">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="font-weight-bold">Get Transaction</label>
                        <button type="submit" id="getTrans" class="btn btn-primary">
                            {{ __('Get Transaction') }}
                        </button>
                    </div>


                    <div class="form-group col-md-1">

                    </div>


                    <div class="form-group col-md-3">
                        <label class="font-weight-bold" for="select-college">Select College</label>
                        <select class="selectpicker" id="select-college" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true">
                            <option value="coep" selected="">College of Engineering Pune</option>   <!-- B.Tech !-->
                            <option value="gcoer" selected="">Government College of Engineering and Research Avasari</option><!-- B.Tech !-->
                            <option value="gcoek" selected="">Government College of Engineering Karad</option><!-- B.Tech !-->
                            <option value="gpp" selected="">Government Polytechnic Pune</option>    <!-- Diploma !-->
                            <option value="gpa" selected="">Government Polytechnic Awasari</option> <!-- Diploma !-->
                        </select>
                    </div>

                    <div class="form-group col-md-2">
                        <label class="font-weight-bold">Download</label>
                        <button type="submit" id="btn_export" class="btn btn-primary">
                            {{ __('Download Data') }}
                        </button>
                    </div>

                </div>

                <br>

                <div id='tableID'>
                    <table class="table table-hover" id='mytableID'>
                        <thead class="thead-light">
                            <tr><th>T.ID</th>
                                <th>Full Name</th>
                                <th>College</th>
                                <th>Contact</th>
                                <th>Amount Received for Year</th>
                                <th>Transaction date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

                <div class="form-group row">
                    <div class="offset-md-11">
                        <a href="javascript:history.back()" class="btn btn-primary float-right">Back</a>
                    </div>
                </div>
                <br>

            </div>
        </div>
    </div>

</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/shim.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.0/xlsx.mini.min.js"></script>

<script type="text/javascript">

    $(document).ready(function () {

        //  Dynamic selection of college
        $("#select-college").change(function () {
            var selectedCollege = $("#select-college").val();
            functionCollege(selectedCollege);
        });
        function functionCollege(selectedCollege) {
            var filter, table, tr, td, i, j, txtValue;
            table = document.getElementById("tableID");
            tr = table.getElementsByTagName("tr");
            var FLG = true;
            if (typeof selectedCollege !== 'undefined' && selectedCollege.length > 0) {
                for (i = 1; i < tr.length; i++) {
                    FLG = true;
                    td = tr[i].getElementsByTagName("td")[2];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        for (j = 0; j < selectedCollege.length; j++) {
                            filter = selectedCollege[j].toUpperCase();
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                                FLG = false;
                                break;
                            }
                        }
                        if (FLG) {
                            tr[i].style.display = "none";
                        }
                    }
                }
            } else {
                for (i = 1; i < tr.length; i++) {
                    tr[i].style.display = "";
                }
            }
        }

        var today = new Date;
        var currentDate = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        $("#from").val(currentDate);
        $("#to").val(currentDate);
        // Call for defualt current and erlier year
        fetch_customer_data(currentDate, currentDate);
        // Call for givan year
        var myData;
        function fetch_customer_data(from, to)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('showHistory') }}",
                method: "GET",
                contentType: "application/json; charset=utf-8",
                data: {from: from, to: to},
                dataType: "json",
                success: function (data)
                {
                    $('tbody').html(data.table_data);
                    $('#total_records').text(data.total_data);
                    myData = data.export_data;
                    // check for other filter values as well
                    var selectedCollege = $("#select-college").val();
                    functionCollege(selectedCollege);

                },
                error: function (data) {
                    console.log(data.status + " " + data.statusText);
                }
            });
        }

        $("#btn_export").click(function (e) {
            var myFilteredData = [];
            var selectedCollege = $("#select-college").val();
            for (var j = 0; j < myData.length; j++) {
                for (var p = 0; p < selectedCollege.length; p++) {
                    if ((myData[j])['college'] === selectedCollege[p]) {
                        myFilteredData.push(myData[j]);
                    }
                }
            }
            //console.log(myFilteredData);
            let binaryWS = XLSX.utils.json_to_sheet(myFilteredData);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, binaryWS, 'Binary values');
            XLSX.writeFile(wb, 'EWL.xlsx');
        });



        $("#getTrans").click(function (e) {
            var from = $('#from').val();
            var to = $('#to').val();
            fetch_customer_data(from, to);
        });


        (function ($) {
            $.fn.assign = function (msg) {
                assignScholarshipFunction(msg);
            };
        })(jQuery);
    });</script>


<script>
    $('.select-college').selectpicker();
</script>

@endsection
