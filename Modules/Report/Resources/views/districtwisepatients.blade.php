@extends('layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('stylesheet')


@endpush

@section('content')
    <div class="dt-content">

        <!-- Grid -->
        <div class="row">
            <div class="col-xl-12 pb-3">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="active breadcrumb-item">{{ $sub_title }}</li>
                </ol>
            </div>
            <!-- Grid Item -->
            <div class="col-xl-12">

                <!-- Entry Header -->
                <div class="dt-entry__header">

                    <!-- Entry Heading -->
                    <div class="dt-entry__heading">
                        <h2 class="dt-page__title mb-0 text-primary"><i class="{{ $page_icon }}"></i> {{ $sub_title }}</h2>
                    </div>
                    <!-- /entry heading -->
                    @if (permission('patientage-add'))
                        <button class="btn btn-primary btn-sm" onclick="showFormModal('Add New patientage','Save')">
                            <i class="fas fa-plus-square"></i> Add New
                        </button>
                    @endif


                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body">

                        <form id="form-filter" method="POST" action="{{route('get-districtwise-patients')}}" >
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="name">Date Range</label>
                                    <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Enter Date Range" required>
                                </div>
                                  <div class="form-group col-md-2">
                                    <label for="name">District</label>
                                     <select class="selectpicker" data-live-search="true" name="dc_id" id="dc_id">
                                        <option value="">Select District </option> <!-- Empty option added -->
                                        @foreach($districts as $dc)
                                            <option value="{{$dc->id}}">{{$dc->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="name">Upazilla</label>
                                     <select class="form-control" data-live-search="true" name="up_id" id="up_id"> 
                                         <option value="">Select Upazilla </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="name">Union</label>
                                     <select class="form-control" data-live-search="true" name="un_id" id="un_id">
                                         <option value="">Select Union </option>
                                         <!-- Empty option added -->
                                    </select>
                                </div>
                                <div class="col-md-1 warning-searching invisible" id="warning-searching">
                                    <span class="text-danger" id="warning-message"></span>
                                    <span class="spinner-border text-danger"></span>
                                </div>
                                <div class="form-group col-md-5 pt-24">

                                    <button type="submit"  class="btn btn-primary btn-sm float-right mr-2" id="btn-filter"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Filter Data">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>


                        <table id="dataTable" class="table table-striped table-bordered table-hover">
                            <thead class="bg-primary">
                            <tr>

                                <th>No</th>
                                <th>Patient Name</th>
                                <th>Age</th>
                                <th>District</th>
                                <th>Upazlilla</th>
                                <th>Union</th>

                            </tr>

                            </thead>
                            @if($results ?? '')
                                <tbody>
                                @foreach($results as $result)
                                    <tr>

                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$result->GivenName}} {{$result->FamilyName}}</td>
                                        <td>{{$result->Age}}</td>
                                        <td>{{optional($result->districtAddress)->name}}</td>
                                        <td>{{optional($result->upazillaAddress)->name}}</td>
                                        <td>{{optional($result->unionAddress)->name}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            @endif
                        </table>



                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->

            </div>
            <!-- /grid item -->

        </div>
        <!-- /grid -->

    </div>
@endsection

@push('script')
    <script src="js/dataTables.buttons.min.js"></script>
    <script src="js/buttons.html5.min.js"></script>

   

   
<script>
    var table;
  $(document).ready(function () {

     $('#dc_id').change(function () {
        
        var dcId = $(this).val();
        console.log(dcId);

      if (dcId) {
         
            $.ajax({
                type: 'GET',
                url: '{{ route("get-upazillas", "dcId") }}'.replace('dcId', dcId),
                success: function (data) {
                    console.log(data)
                     
            // Add the default empty option
            $('#up_id').html('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            console.log('gg')
                             $("#up_id").append('<option value="'+ value.id+'">' + value.name +'</option>');
                            // $("#up_id").append('<option value="' + value.id + '" class="selectpicker">' + value.name + '</option>');
                        });
                        $("#up_id").addClass("selectpicker");
                        $("#up_id").selectpicker('refresh');
                }
            });
        } else {
            $('#up_id').empty();
            $('#up_id').append($('<option>', {
                value: '',
                text: 'Select Upazilla'
            }));
        }

    });

       $('#up_id').change(function () {
        var upId = $(this).val();
        console.log(upId);

        if (upId) {
            $.ajax({
                type: 'GET',
                url: '{{ route("get-unions", "upId") }}'.replace('upId', upId),
                success: function (data) {
                    console.log(data)
                     $('#un_id').empty();
                     
            
            // Add the default empty option
            $('#un_id').html('<option value="">Select State</option>');
                        $.each(data, function (key, value) {
                            console.log('gg')
                             $("#un_id").append('<option value="'+ value.id+'">' + value.name + '</option>');
                            // $("#up_id").append('<option value="' + value.id + '" class="selectpicker">' + value.name + '</option>');
                        });
                        //   $("#up_id").addClass("selectpicker");
                        $("#un_id").addClass("selectpicker");
                        $("#un_id").selectpicker('refresh');

    
                }
            });
        } else {
            $('#un_id').empty();
            $('#un_id').append($('<option>', {
                value: '',
                text: 'Select Upazilla'
            }));
        }

    });
  

            $('#dataTable').DataTable({
                pagingType: 'full_numbers',
                dom: 'Bfrtip',
                orderCellsTop: true,
                ordering: false,
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export to Excel',
                        filename: 'Districtwise Patient Report'

                    },
                ],
         
            });
    var start = moment().subtract(29, 'days');
    var end = moment();

     $('input[name="daterange"]').daterangepicker({
        startDate: start,
        endDate: end,
        showDropdowns: true,
        linkedCalendars: false,
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Quarter': [moment().startOf('quarter'), moment().endOf('quarter')],
        'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    });

     $('.daterangepicker').mouseleave(function() {
        $(this).hide();
    });
      $('input[name="daterange"]').click(function() {
        $('.daterangepicker').show();
    });
});

    $('#btn-filter').on('click', function () {
        $('#warning-searching').removeClass('invisible');
     });

</script>
@endpush
