@extends('admin.layout.appToSearch')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('auth.prefix')) }}: There are <span id="total_records">{!! json_encode($data['total_data']) !!}</span> transaction's for this student</div>

                <br>

                <div id='tableID'>
                    <table class="table table-hover" id='mytableID'>
                        <thead class="thead-light">
                            <tr>
                                <th data-field="transactionId">Transaction ID</th>
                                <th data-field="created_at">Date-time</th>
                                <th data-field="amount">Amount</th>
                                <th data-field="amountReceivedForYear">For Year</th>
                                <th data-field="amountReceivedForSemester">For Semester</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="form-group row mb-0">
                    <div class="offset-md-11">
                        <a href="javascript:history.back()" class="btn btn-primary float-right">Back</a>
                    </div>
                </div>
                <br>

            </div>
        </div>
    </div>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        
        var myData = {!! json_encode($data['export_data']) !!}
        for (var i = 0; i < myData.length; i++){
            myData[i].name = myData[i].name + " " + myData[i].middleName + " " + myData[i].surName;
        }
        
        $('#mytableID').bootstrapTable({
            data: myData,
            formatLoadingMessage: function() {
                return '';
            }
        });
    });

</script>

@endsection
