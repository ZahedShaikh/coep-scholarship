@extends('accountant.layout.appToSearch')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('auth.prefix')) }}: You have <span id="total_records"></span> students to sanction scholarship amount</div>
                <br>

                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label class="font-weight-bold" for="from">Search by ID</label>
                        <input type="text" name="SearchByID" id="SearchByID" class="form-control" placeholder="Search by ID"/>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="font-weight-bold" for="from">Search by Name</label>
                        <input type="text" name="SearchByName" id="SearchByName" class="form-control" placeholder="Search by Name"/>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="font-weight-bold" for="select-college">Search by College</label>
                        <select class="selectpicker" id="select-college" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true">
                            <option value="coep">College of Engineering Pune</option>   <!-- B.Tech !-->
                            <option value="gcoer">Government College of Engineering and Research Avasari</option><!-- B.Tech !-->
                            <option value="gcoek">Government College of Engineering Karad</option><!-- B.Tech !-->
                            <option value="gpp">Government Polytechnic Pune</option>    <!-- Diploma !-->
                            <option value="gpa">Government Polytechnic Awasari</option> <!-- Diploma !-->
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
                    <div class="offset-md-8">


                        <button type="submit" id="sanctionAll" class="btn btn-primary">
                            {{ __('Sanction Remaining All Applications') }}
                        </button>

                        <a href="javascript:history.back()" class="btn btn-primary">Back</a>

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
        /* 
         * Function to retrive/fetch students with sanction amount status
         * 
         */
        fetch_customer_data();

        var myData;
        function fetch_customer_data(query = '')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('showAmountToBeCredit') }}",
                method: "GET",
                contentType: "application/json; charset=utf-8",
                data: {query: query},
                dataType: "json",
                success: function (data)
                {
                    $('tbody').html(data.table_data);
                    $('#total_records').text(data.total_data);
                    myData = data.export_data;
                },
                error: function (data) {
                    console.log(data.status + " " + data.statusText);
                }
            });
        }

        /*
         * @param {type} This function will filter the data by query
         */

        $("#SearchByID").keyup(function () {
            var searchID = $("#SearchByID").val();
            $("#SearchByName").val('');
            $("#select-college").val('');
            functionID(searchID);
        });
        $("#SearchByName").keyup(function () {
            var searchStudent = $("#SearchByName").val();
            $("#SearchByID").val('');
            $("#select-college").val('');
            functionName(searchStudent);
        });
        $("#select-college").change(function () {
            var selectedCollege = $("#select-college").val();
            $("#SearchByName").val('');
            $("#SearchByID").val('');
            functionCollege(selectedCollege);
        });

        function functionID(searchID) {
            var table, tr, td, i, txtValue;
            table = document.getElementById("tableID");
            tr = table.getElementsByTagName("tr");

            if (searchID) {
                for (i = 1; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue === searchID) {
                            tr[i].style.display = "";
                        } else {
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

        function functionName(searchStudent) {
            var table, tr, td, i, txtValue;
            table = document.getElementById("tableID");
            tr = table.getElementsByTagName("tr");

            if (searchStudent) {
                for (i = 1; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(searchStudent.toUpperCase()) > -1) {
                            tr[i].style.display = "";
                        } else {
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

        function functionCollege(selectedCollege) {
            var filter, table, tr, td, i, txtValue;
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


        $("#btn_export").click(function (e) {

//            var myFilteredData = [];
//            var selectedCollege = $("#select-college").val();
//            var selectedCategory = $("#select-category").val();
//            for (var j = 0; j < myData.length; j++) {
//                for (var p = 0; p < selectedCollege.length; p++) {
//                    if ((myData[j])['college'] === selectedCollege[p]) {
//                        for (var q = 0; q < selectedCategory.length; q++) {
//                            if ((myData[j])['category'] === selectedCategory[q]) {
//                                myFilteredData.push(myData[j]);
//                            }
//                        }
//                    }
//                }
//            }
            //console.log(myFilteredData);
            let binaryWS = XLSX.utils.json_to_sheet(myData);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, binaryWS, 'Binary values');
            XLSX.writeFile(wb, 'EWL.xlsx');
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
                url: "{{ route('creditAmountToBank') }}",
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

        $("#sanctionAll").click(function (e) {
            //console.log('okay presssed'); 
            var table = document.getElementById("tableID");
            var tr = table.getElementsByTagName("tr");
            var SanctionAlldataIds = [];
            var i, td, txtValue;

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    SanctionAlldataIds.push(txtValue);
                }
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
//            
//            $.ajax("sanctionAllApplications", {
//                type: 'GET',
//                data: {SanctionAlldataIds: SanctionAlldataIds}
//            });
//            

            $.ajax({
                url: "{{ route('creditEveryoneAmountToBank') }}",
                method: "GET",
                contentType: "application/json; charset=utf-8",
                data: {SanctionAlldataIds: SanctionAlldataIds},
                dataType: "json",
                success: function ()
                {
                    location.reload(true);
                },
                error: function (data) {
                    console.log(data.status + " " + data.statusText);
                }
            });



        });

        (function ($) {

            $.fn.assign = function (msg) {
                assignScholarshipFunction(msg);
            };
        })(jQuery);

    });

</script>

@endsection
