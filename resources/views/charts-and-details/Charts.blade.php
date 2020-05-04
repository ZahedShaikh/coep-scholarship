@extends('admin.layout.appToSearch')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('auth.prefix')) }}</div>
                <br>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="from">From</label>
                        <select id="from" name="category" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="to">To</label>
                        <select id="to" name="category" class="form-control">
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="select-college">Select College</label>
                        <select class="selectpicker" id="select-college" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true">
                            <option value="coep" selected="">College of Engineering Pune</option>   <!-- B.Tech !-->
                            <option value="gcoer" selected="">Government College of Engineering and Research Avasari</option><!-- B.Tech !-->
                            <option value="gcoek" selected="">Government College of Engineering Karad</option><!-- B.Tech !-->
                            <option value="gpp" selected="">Government Polytechnic Pune</option>    <!-- Diploma !-->
                            <option value="gpa" selected="">Government Polytechnic Awasari</option> <!-- Diploma !-->
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="select-category">Select Category</label>
                        <select class="selectpicker" id="select-category" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true">
                            <option value="OPEN" selected="">Open</option>
                            <option value="OBC" selected="">OBC</option>
                            <option value="EWS" selected="">EWS</option>
                            <option value="SC" selected="">SC</option>
                            <option value="ST" selected="">ST</option>
                            <option value="SBC" selected="">SBC</option>
                            <option value="VJ" selected="">VJ</option>
                            <option value="NT-1" selected="">NT-1</option>
                            <option value="NT-2" selected="">NT-2</option>
                            <option value="NT-3" selected="">NT-3</option>
                            <option value="ECBC" selected="">ECBC</option>
                            <option value="OTHER" selected="">Other</option>
                        </select>
                    </div>
                </div>

                <br>

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
        $("#select-college, #select-category").change(function () {
            var selectedCollege = $("#select-college").val();
            var selectedCategory = $("#select-category").val();
            functionCollege(selectedCollege, selectedCategory);
        });

        var currentYear = (new Date).getFullYear();
        var option = '';
        for (var i = 2015; i <= currentYear; i++) {
            option += '<option value="' + i + '">' + i + '</option>';
        }
        $('#from').append(option);
        $('#to').append(option);
        $("#from").val(currentYear - 1);
        $("#to").val(currentYear);
        // Call for defualt current and erlier year
        fetch_customer_data(currentYear - 1, currentYear);

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

                    // check for other filter values as well
                    var selectedCollege = $("#select-college").val();
                    var selectedCategory = $("#select-category").val();
                    functionCollege(selectedCollege, selectedCategory);

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
                $('#to').val(from);
            } else {
                fetch_customer_data(from, to);
            }
        });

        (function ($) {
            $.fn.assign = function (msg) {
                assignScholarshipFunction(msg);
            };
        })(jQuery);

    });

    function functionCollege(selectedCollege, selectedCategory) {

        var filter, table, tr, td, i, txtValue, j, k, tdCategory, txtValueCategory;
        table = document.getElementById("tableID");
        tr = table.getElementsByTagName("tr");

        var flg = false;
        var flg2 = true;
        for (i = 1; i < tr.length; i++) {
            flg = false;
            flg2 = true;

            td = tr[i].getElementsByTagName("td")[2];

            if (td) {
                txtValue = td.textContent || td.innerText;
                for (j = 0; j < selectedCollege.length; j++) {
                    filter = selectedCollege[j].toUpperCase();
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        flg = true;
                        break;
                    }
                }
            }

            tdCategory = tr[i].getElementsByTagName("td")[4];
            if (flg) {
                if (tdCategory) {
                    txtValueCategory = tdCategory.textContent || tdCategory.innerText;
                    for (k = 0; k < selectedCategory.length; k++) {
                        filter = selectedCategory[k].toUpperCase();
                        if (txtValueCategory.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            flg2 = false;
                            break;
                        }
                    }
                }
            }
            if (flg2) {
                tr[i].style.display = "none";
            }
        }
    }
</script>


<script>
    $('.select-college').selectpicker();
</script>

@endsection
