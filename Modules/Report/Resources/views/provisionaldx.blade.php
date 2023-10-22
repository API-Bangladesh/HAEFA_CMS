@extends('layouts.app')

@section('title')
{{ $page_title }}
@endsection

@push('stylesheet')

<style>
    {{--        pagination style--}}

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination .active {
        font-weight: bold;
        color: #000;
    }

    .pagination a {
        color: #007bff;
        text-decoration: none;
        padding: 5px 10px;
        border: 1px solid #007bff;
        border-radius: 5px;
    }

    .pagination a:hover {
        background-color: #007bff;
        color: #fff;
    }


    {{--pagination style ends--}}

    #prescription .container {
        background-color: #f2f2f2 !important;
    }

    .header p {
        font-size: 14px;
    }
    .aside {
        width: 400px;
        border-right: 1px solid #ddd;
        min-height: 600px;
        padding-bottom: 20px;
    }

    .signatureImage {
        display: inline-block;
        width: 100px;
        object-fit: contain;
        margin-bottom: 5px;
    }
    .signatureBox {
        position: absolute;
        right: 50px;
        bottom: 30px;
    }
    .footer {
        padding-top: 20px;
        padding-bottom: 20px;
        border-top: 1px solid #ddd;
    }

    .footer p {
        font-size: 14px;
    }
    .apiLogo {
        max-width: 40px;
        transform: translateY(-4px);
        margin-left: 5px;
    }
    .logoText {
        font-size: 14px;
    }
    .nextinfo {
        margin-top: 150px;
    }

    .userImg {
        margin-top: 20px;
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 20px;
        border: 10px solid rgba(122,122,122,.15);
    }

    .dataItem p{
        font-weight: 400;
        font-size: 15px;
    }
    .dataItem span{
        font-weight: 600;
        font-size: 15px;
    }

    @media (max-width: 767px){
        #prescription, .logoText, address p, .header p{
            font-size: 12px !important;
        }
        .header h4{
            font-size: 18px !important;
        }
        .patientageLeftSide {
            width: 100% !important;
            min-height: auto !important;
            border: 0 !important;
        }
        .itemMerge{
            flex-direction: column;
        }
        .patientageLeftSide h5{
            font-size: 18px !important;
        }
        .userImg {
            width: 140px !important;
            height: 140px !important;
            border-width: 5px;
        }
        .patientageRightSide .dataItem p,
        .patientageRightSide .dataItem span,
        .patientageLeftSide p{
            margin-bottom: 0;
            font-size: 14px;
        }
        .patientageRightSide .dataItem h5{
            font-size: 16px !important;
            margin-bottom: 5px !important;
        }
        .patientageRightSide{
            padding: 10px 10px !important;
        }
        .patientageRightSide .dataItem{
            margin-top: 15px !important;
        }

    }
</style>
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

                    <form id="form-filter" method="POST" action="" >
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="daterange">Date Range</label>
                                <input type="text" class="form-control daterangepicker-start" id="daterange" name="daterange" >
                            </div>

                            <div class="form-group col-md-3">
                                <label for="name">Branches</label>

                                <select class="selectpicker" data-live-search="true" name="hc_id" id="hc_id">
                                    <option value="">Select Branch</option> <!-- Empty option added -->
                                    @foreach($branches as $branch)
                                    <option value="{{$branch->barcode_prefix}}">{{$branch->HealthCenterName}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 warning-searching invisible" id="warning-searching">
                                <span class="text-danger" id="warning-message">Searching...Please Wait</span>
                                <span class="spinner-border text-danger"></span>
                            </div>
                            <div class="form-group col-md-4 pt-24">
                                    <button type="button" class="btn btn-danger btn-sm float-right" id="btn-reset"
                                    data-toggle="tooltip" data-placement="top" data-original-title="Reset Data">
                                    <i class="fas fa-redo-alt"></i>
                                    </button>

                                <button type="button"  class="btn btn-primary btn-sm float-right mr-2" id="search"
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
                                <th>RegistrationID</th>
                                <th>GivenName</th>
                                <th>FamilyName</th>
                                <th>Gender</th>
                                <th>BirthDate</th>
                                <th>Age</th>
                                <th>Mobile</th>
                                <th>Provisional DX</th>
                            </tr>

                            </thead>
                    
                         
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

// disease rate by date range start




// disease rate by date range end

    var start = moment().subtract(29, 'days');
    var end = moment();


    function cb(start, end) {
        console.log("Selected Date Range: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
       
    }

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
            // 'This Quarter': [moment().startOf('quarter'), moment().endOf('quarter')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            // Add more custom ranges here...
        }
    }, cb);

    cb(start, end);
    $('.daterangepicker').mouseleave(function() {
        $(this).hide();
    });
    $('.daterangepicker-start').click(function() {
        $('.daterangepicker').show();
    });


    var table;
    var healthcenter='';
    var collectionDate='';
    var patients;
    var now = new Date();
    var formattedDate = now.getDate().toString().padStart(2, '0') + '_' + (now.getMonth() + 1).toString().padStart(2, '0') + '_' + now.getFullYear();
    var filename = 'ProvisionalDiagnosis_' + formattedDate;

  

    
    $(document).ready(function () {
    table = $('#dataTable').DataTable({
        pagingType: 'full_numbers',
        dom: 'Bfrtip',
        orderCellsTop: true,
        buttons: [
            {
                extend: 'excel',
                text: 'Export to Excel',
                filename: filename,
                title: '',
                customize: function(xlsx,resultCount) {
            var sheet = xlsx.xl.worksheets['sheet1.xml'];
            var downrows = 7; // Number of rows to add
            var clRow = $('row', sheet);

            // Update Row
            clRow.each(function() {
                var attr = $(this).attr('r');
                var ind = parseInt(attr);
                ind = ind + downrows;
                $(this).attr("r", ind);
            });

            // Update row > c
            $('row c', sheet).each(function() {
                var attr = $(this).attr('r');
                var pre = attr.substring(0, 1);
                var ind = parseInt(attr.substring(1, attr.length));
                ind = ind + downrows;
                $(this).attr("r", pre + ind);
            });
         

            function Addrow(index, data) {
                var msg = '<row r="' + index + '">';
                for (var i = 0; i < data.length; i++) {
                    var key = data[i].k;
                    var value = data[i].v;
                    msg += '<c t="inlineStr" r="' + key + index + '">';
                    msg += '<is>';
                    msg += '<t>' + value + '</t>';
                    msg += '</is>';
                    msg += '</c>';
                }
                msg += '</row>';
                return msg;
            }

            var r1 = Addrow(1, [{
                k: 'A',
                v: 'App Name:'
            }, {
                k: 'B',
                v: 'Nirog Plus'
            }]);

            var r2 = Addrow(2, [{
                k: 'A',
                v: 'Branch: '
            }, {
                k: 'B',
                v: healthcenter, // Replace '6' with actual count
            }]);

            var r3 = Addrow(3, [{
                k: 'A',
                v: 'Collection Date:'
            }, {
                k: 'B',
                v: collectionDate, // Replace '4' with actual count
            }]);

            var r4 = Addrow(4, [{
                k: 'A',
                v: 'Report Type:',
            }, {
                k: 'B',
                v:  'ProvisionalDiagnosis',
            }]);
             var r5 = Addrow(5, [{
                k: 'A',
                v: ''
            }, {
                k: 'B',
                v: ''
            }]);
              var r6 = Addrow(6, [{
                k: 'A',
                v: 'Total Patients',
            }, {
                k: 'B',
                v: patients,
            }]);
               var r7 = Addrow(7, [{
                k: 'A',
                v: '',
            }, {
                k: 'B',
                v: '',
            }]);
            

            sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + r6 + r7 + sheet.childNodes[0].childNodes[1].innerHTML;
            table.clear().draw();
            $('#hc_id').val('').selectpicker('refresh');
    },
            },
        ],
    });

     $('#search').click(function () {
        var daterange = $('#daterange').val();
        var hc_id = $('#hc_id').val();
        const parts = daterange.split(" - ");
        const fdate = parts[0];
        const ldate = parts[1];

        $.ajax({
            type: "GET",
            url: "{{ url('patient-wise-dx') }}",
            data: { hc_id: hc_id, fdate: fdate, ldate: ldate },
            beforeSend: function () {
                $('#warning-searching').removeClass('invisible');
            },
            complete: function () {
                $('#warning-searching').addClass('invisible');
            },
            success: function (response) {
                var results = response.results;
                healthcenter = response.healthcenter;
                var firstDate = new Date(response.first_date);
                var lastDate = new Date(response.last_date);

                    var formatDate = function (date) {
                    var day = date.getDate().toString().padStart(2, '0');
                    var monthNames = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    var monthName = monthNames[date.getMonth()];
                    var year = date.getFullYear();
                    return day + "-" + monthName + "-" + year;
                };

                collectionDate = formatDate(firstDate) + "_To_" + formatDate(lastDate);
               
                patients=response.resultCount;
            
                var tableBody = $('#dataTable tbody')

                // Clear the existing table rows
                table.clear().draw();

                if (results.length > 0) {
                    $.each(results, function (index, result) {
                        var newRow = [
                            (index + 1),
                            result.RegistrationId,
                            (result.GivenName || ""),
                            (result.FamilyName || ""),
                            (result.GenderCode || ""),
                            (result.BirthDate || ""),
                            (result.Age || ""),
                            (result.CellNumber || ""),
                            (result.ProvisionalDiagnosis || ""),
                           
                      
                        ];

                        // Add a new row to the table
                        table.row.add(newRow).draw();
                    });
                } else {
                    // Handle the case where there are no results (optional)
                    tableBody.html('<tr><td colspan="9">No results found</td></tr>');
                }
            },
        });
    });

    });
      $('#btn-reset').click(function () {
       
        table.clear().draw();
        $('#hc_id').val('').selectpicker('refresh');
        
    });

    $('#btn-filter').on('click', function (event) {
        $('#warning-searching').removeClass('invisible');
    });

    

</script>
@endpush
