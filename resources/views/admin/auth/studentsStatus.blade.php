@extends('admin.layout.appToSearch')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" >{{ ucfirst(config('auth.prefix')) }}: There are <span id="total_records">{!! json_encode($data['total_data']) !!}</span> students have not updated their data for this semester</div>

                <br>
                <div class="form-group col-md-4">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Student"/>
                </div>

                <div class="table-responsive" id='tableID'>
                    <table class="table table-striped table-bordered" id='mytableID'>
                        <thead>
                            <tr>
                                <th data-field="id">Form ID</th>
                                <th data-field="name">name</th>
                                <th>College</th>
                                <th>Direct-S year</th>
                                <th>Category</th>
                                <th>Gender</th>
                                <th>Current-Year</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                    </table>
                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-8">
                        <a href="javascript:history.back()" class="btn btn-primary">Back</a>
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
        $('#mytableID').bootstrapTable({
            data: {!! json_encode($data['export_data']) !!},
            formatLoadingMessage: function() {
                return '';
            }
        });
    });

</script>

@endsection
