@extends('layouts.app')

@section('title')
{{ $page_title }}
@endsection

@push('stylesheet')
<style>
    .custom-tooltip{
    position: relative;
    display: inline-block;
    padding: 0.8rem 2rem;
    background-color: #f2f2f2;
    font-size: 1.8rem;
    color: black !important;
    opacity: 0.5;
    /* box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.03); */
    border-radius: 0.4rem;
    z-index: 1;
    }
    .custom-tooltip-age{
    position: relative;
    display: inline-block;
    padding: 0.8rem 2rem;
    background-color: #f2f2f2;
    font-size: 1.8rem;
    color: black !important;
    opacity: 0.5;
    /* box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.03); */
    border-radius: 0.4rem;
    z-index: 1;
    }
    .custom-tooltip-diastolic{
    position: relative;
    display: inline-block;
    padding: 0.8rem 2rem;
    background-color: #f2f2f2;
    font-size: 1.8rem;
    color: black !important;
    opacity: 0.5;
    /* box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.03); */
    border-radius: 0.4rem;
    z-index: 1;
    }
    .custom-tooltip-heart, .custom-tooltip-rbg, .custom-tooltip-fbg, .custom-tooltip-hrslasteat{
    position: relative;
    display: inline-block;
    padding: 0.8rem 2rem;
    background-color: #f2f2f2;
    font-size: 1.8rem;
    color: black !important;
    opacity: 0.5;
    /* box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.03); */
    border-radius: 0.4rem;
    z-index: 1;
    }

    .dropdown-menu {
  position: fixed;
  top: 0 !important;
  right: 0 !important;
  left: 0 !important;
  z-index: 1000;
  overflow-y: auto;
  max-height: 155.382px;
  min-height: 155px;
  transform: translate3d(0px, 0px, 0px) !important; /* Remove unnecessary transform */
}
.custom-menu{
    transform: translate3d(-152px, 72px, 0px) !important;
    overflow: hidden;
}
.custom-menu > .dropdown-item{
    padding: 4px 15px;
}
.custom-width{
    width:100% !important;	
}


</style>
<!-- Include Select2 CSS -->



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
                                    <option value="{{$branch->barcode_prefix}}">{{$branch->healthCenter->HealthCenterName}}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="form-group col-md-3">
                                <label for="name">Age Range</label>
                                <div id="ageRange" class="mt-2"></div>
                            </div>
                      
                         

                            <div class="col-md-1 warning-searching invisible" id="warning-searching">
                                <span class="text-danger" id="warning-message">Searching...Please Wait</span>
                                <span class="spinner-border text-danger"></span>
                            </div>
                            <div class="form-group col-md-2 pt-24">
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
                        <div class="row">
                            
                            <div class="form-group col-md-3">
                                <label for="name">Registration</label>

                                <select class="custom-width"  name="reg_id" id="reg_id">
                                     <option value="">Select Patient</option>
                                    @foreach($regs as $reg)
                                    <option value="{{$reg->RegistrationId}}">{{$reg->RegistrationId}}</option>
                                    @endforeach
                                </select>
                            </div>
                             {{-- <div class="form-group col-md-3">
                                <label for="name">Complain</label>

                                <select class="selectpicker" multiple data-live-search="true"  name="complain_id[]" id="complain_id">
                                     <option value="" disabled>Select Complain</option>
                                    @foreach($complains as $complain)
                                    <option value="{{$complain->CCCode}}">{{$complain->CCCode}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group col-md-3">
                                <label for="name">Complain</label>
                                <select class="custom-width" multiple id="complain_id" name="complain_id[]">
                                    <option value="">Select Complain</option>
                                    @foreach($complains as $complain)
                                    <option value="{{$complain->CCCode}}">{{$complain->CCCode}}</option>
                                    @endforeach
                                </select>
                            </div>
                           <div class="form-group col-md-3">
                                <label for="illness_id">Illnesses</label>
                                <select class="custom-width" multiple  id="illness_id" name="illness_id[]">
                                    <option value="">Select Illness</option>
                                    @foreach($illnesses as $illness)
                                        <option value="{{$illness->IllnessCode}}">{{$illness->IllnessCode}}</option>
                                    @endforeach
                                </select>
                            </div>

                             <div class="form-group col-md-3">
                                <label for="name">Medicine</label>

                                <select class="custom-width" multiple name="medicine_id[]" id="medicine_id">
                                     <option value="">Select Medicines</option>
                                    @foreach($drugs as $drug)
                                    <option value="{{$drug->DrugCode}}">{{$drug->DrugCode}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-3">
                                <label for="name">Systolic Range</label>
                                <div id="systolicRange"></div>
                               
                         </div>
                         <div class="form-group col-md-3">
                                <label for="name">Diastolic Range</label>
                                <div id="diastolicRange"></div>
                               
                         </div>
                          <div class="form-group col-md-3">
                                <label for="name">Heart Rate</label>
                                <div id="heartRate"></div>
                               
                         </div>  
                        </div>
                        <div class="row">
                          <div class="form-group col-md-3">
                                <label for="name">RBG</label>
                                <div id="rbg"></div>
                               
                         </div>
                         <div class="form-group col-md-3">
                                <label for="name">FBG</label>
                                <div id="fbg"></div>
                               
                         </div>
                          <div class="form-group col-md-3">
                                <label for="name">Hours From Last Eat</label>
                                <div id="hrslasteat"></div>
                               
                         </div>  
                        </div>
                        <div class="row">
                             <div class="form-group col-md-3">
                                <label for="name">Provisinal DX</label>

                                <select class="selectpicker" multiple name="prodx_id[]" id="prodx_id">
                                     <option value="">Select Provisional Diagnosis</option>
                                    @foreach($dxs as $dx)
                                    <option value="{{$dx->ProvisionalDiagnosisName}}">{{$dx->ProvisionalDiagnosisName}}</option>
                                    @endforeach
                                </select>
                            </div>
                     
                      </div>
                    </form>

                       <table id="dataTable" class="table table-striped table-bordered table-hover ">
                            <thead class="bg-primary">
                            <tr>
                                <th>PatientID</th>
                                <th>CollectionDate</th>
                                <th>RegistrationID</th>
                                <th>GivenName</th>
                                <th>FamilyName</th>
                                <th>Gender</th>
                                <th>BirthDate</th>
                                <th>Age</th>
                                <th>Mobile</th>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>BMI</th>
                                <th>BPSystolic1</th>
                                <th>BPDiastolic1</th>
                                <th>BPSystolic2</th>
                                <th>BPDiastolic2</th>
                                <th>HeartRate</th>
                                <th>RBG</th>
                                <th>FBG</th>
                                <th>HrsFromLastEat</th>
                                <th>Hemoglobin</th>
                                <th>AnemiaSeverity</th>
                                <th>CoughGreaterThanMonth</th>
                                <th>LGERF</th>
                                <th>NightSweat</th>
                                <th>WeightLoss</th>
                                <th>ChiefComplainWithDuration</th>
                                <th>PhysicalFinding</th>
                                <th>RxDetails</th>
                                <th>PatientIllnessHistory</th>
                                <th>FamilyIllnessHistory</th>
                                <th>Vaccination</th>
                                <th>SocialBehavior</th>                                
                                <th>Gravida</th>
                                <th>StillBirth</th>
                                <th>MisCarriageOrAbortion</th>
                                <th>MR</th>
                                <th>LivingBirth</th>
                                <th>LivingMale</th>
                                <th>LivingFemale</th>
                                <th>ChildMorality0To1</th>
                                <th>ChildMoralityBelow5</th>
                                <th>ChildMoralityOver5</th>
                                <th>LMP</th>
                                <th>ContraceptionMethod</th>
                                <th>OtherContraceptionMethod</th>
                                <th>MenstruationProduct</th>
                                <th>OtherMenstruationProduct</th>
                                <th>MenstruationProductUsageTime</th>
                                <th>OtherMenstruationProductUsageTime</th>
                                <th>ProvisionalDiagnosis</th>
                                <th>TreatmentSuggestion</th>
                                <th>DiagnosticSuggestion</th>
                                <th>PatientIllness</th>
                                <th>FollowUpDate</th>
                               
                                
                               
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- Include Select2 JS -->

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
    var formattedDate = now.getDate().toString().padStart(2, '0') + '_' +
    (now.getMonth() + 1).toString().padStart(2, '0') + '_' +
    now.getFullYear() + '_' +
    now.getHours().toString().padStart(2, '0') + '_' +
    now.getMinutes().toString().padStart(2, '0') + '_' +
    now.getSeconds().toString().padStart(2, '0');
    var filename = 'ProvisionalDiagnosis_PatientCount_AgeWise_' + formattedDate;
    var isFiltering='';

  

    
    $(document).ready(function () {
          $('#complain_id').select2();
          $('#reg_id').select2();
          $('#illness_id').select2();
        //   $('#prodx_id').select2();
          $('#medicine_id').select2();
    table = $('#dataTable').DataTable({
        pagingType: 'full_numbers',
        dom: 'Bfrtip',
        orderCellsTop: true,
        ordering:false,
        columnDefs: [
            { targets: [ 6,7, 5,8, 9, 10, 20, 21, 22, 23, 24, 25 ,27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47,48,49,54], visible: false }, // Hide the columns
        ],
        
         buttons: [
            {
                extend: 'excel',
                text: 'Export to Excel',
                filename: filename,
                title: '',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51,52,53], // Include specific columns in the export
                },
                customize: function(xlsx,resultCount) {
            var sheet = xlsx.xl.worksheets['sheet1.xml'];
            var downrows = 5; // Number of rows to add
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
                v: 'App Name: Nirog Plus'
            }]);

            var r2 = Addrow(2, [{
                k: 'A',
                v: 'Branch:'+healthcenter,
            }]);

            var r3 = Addrow(3, [{
                k: 'A',
                v: 'Collection Date:'+ collectionDate,
            }]);

            var r4 = Addrow(4, [{
                k: 'A',
                v: 'Report Type: Provisional Diagnosis Patient Count Age wise'
            }]);
             var r5 = Addrow(5, [{
                k: 'A',
                v: ''
            }, {
                k: 'B',
                v: ''
            }]);

            sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + r4 + r5 + sheet.childNodes[0].childNodes[1].innerHTML;
            // table.clear().draw();
            // $('#hc_id').val('').selectpicker('refresh');
    },
            },
        ],
    });

  
    // $('#complain_id').on('change', function () {
    //      var selectedValue = $(this).val();

    //         // Use DataTables API to search and filter the table
    //         table.search(selectedValue).draw();
    // });
 
    
    var currentIllnessFilter = [];
    var currentRegIdFilter = '';
    var currentComplainFilter=[];
    var currentMedicineFilter=[];
    var currentProdxFilter=[];
    var currentSystolicMin = 0;
    var currentSystolicMax = 250;
    var currentDiastolicMin = 0;
    var currentDiastolicMax = 250;
    var currentHrateMin = 0;
    var currentHrateMax = 250;

    var currentRBGMin = 0;
    var currentRBGMax = 50;

    var currentFBGMin = 0;
    var currentFBGMax = 50;

    var currentHrslasteatMin = 0;
    var currentHrslasteatMax = 48;
    


// Function to apply all filters
    function applyFilters() {
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var illnessString = data[53]; // Adjust the index as per your table's structure
                var regString = data[2]; // Adjust the index as per your table's structure
                var complainString = data[26]; // Adjust the index as per your table's structure
                var medString = data[51]; // Adjust the index as per your table's structure
                var sysValue = parseFloat(data[12]) || 0;
                var diasValue = parseFloat(data[13]) || 0;
                var hrateValue = parseFloat(data[16]) || 0;
                var rbgValue = parseFloat(data[17]) || 0;
                var fbgValue = parseFloat(data[18]) || 0;
                var hrslasteatValue = parseFloat(data[19]) || 0;
                var prodxString = data[50];
                console.log(prodxString);
            

                // Check illness filter
                var illnessMatch = currentIllnessFilter.every(function(illness) {
                    return illnessString.includes("IllnessCode:" + illness);
                });

                var complainMatch = currentComplainFilter.every(function(complain) {
                    return complainString.includes("Chief Complain:" + complain);
                });

                var medMatch = currentMedicineFilter.every(function(med) {
                    return medString.includes("Drug Name:" + med);
                });

                var prodxMatch = currentProdxFilter.every(function(dx) {
                    return prodxString.includes("Provisional Diagnosis:" + dx);
                });
           
                // Check registration ID filter
                var regIdMatch = !currentRegIdFilter || regString.includes(currentRegIdFilter);

                var systolicMatch = (currentSystolicMin <= sysValue && sysValue <= currentSystolicMax);

                var diastolicMatch = (currentDiastolicMin <= diasValue && diasValue <= currentDiastolicMax);

                var hrateMatch = (currentHrateMin <= hrateValue && hrateValue <= currentHrateMax);

                var rbgMatch = (currentRBGMin <= rbgValue && rbgValue <= currentRBGMax);

                var fbgMatch = (currentFBGMin <= fbgValue && fbgValue <= currentFBGMax);

                var hrslasteatMatch = (currentHrslasteatMin <= hrslasteatValue && hrslasteatValue <= currentHrslasteatMax);

                return illnessMatch && complainMatch && medMatch && regIdMatch && prodxMatch && systolicMatch && diastolicMatch && hrateMatch && rbgMatch && fbgMatch && hrslasteatMatch;
            }
        );

        table.draw();
        $.fn.dataTable.ext.search.pop();
    }

// Event listener for illness filter
    $('#illness_id').on('change', function () {
        currentIllnessFilter = $(this).val() || [];
        applyFilters();
    });

    // Event listener for registration ID filter
    $('#reg_id').on('change', function () {
        currentRegIdFilter = $(this).val();
        applyFilters();
    });
     $('#complain_id').on('change', function () {
        currentComplainFilter = $(this).val() || [];
        applyFilters();
    });
    $('#medicine_id').on('change', function () {
        currentMedicineFilter = $(this).val() || [];
        applyFilters();
    });
     $('#prodx_id').on('change', function () {
        currentProdxFilter = $(this).val() || [];
        applyFilters();
    });



    $("#ageRange").slider({
        range: true,
        min: 0,
        max: 150,
        values: [0, 150],
        slide: function (event, ui) {
            // Update tooltips
            updateTooltipsAge(ui.values[0], ui.values[1]);
            
        }
    });

    // Function to update tooltips for age slider
    function updateTooltipsAge(start, end) {
    // Update tooltips for both handles
    $("#ageRange .ui-slider-handle").each(function (index) {
        // Check if custom-tooltip div already exists
        var tooltipDiv = $(this).find(".custom-tooltip-age");
        if (tooltipDiv.length === 0) {
            // Append a new custom-tooltip div
            $(this).append("<div class='custom-tooltip-age'></div>");
        }

        // Update the text content of the custom-tooltip
        tooltipDiv.text(index === 0 ? start : end);

        // Position the tooltip
        positionTooltipAge(index);
    });
}

    // Function to position tooltips
    function positionTooltipAge(index) {
        $(".custom-tooltip-age").eq(index).position({
            my: "center bottom",
            at: "center top",
            of: $("#ageRange .ui-slider-handle").eq(index)
        });
    }

    // Initial tooltips setup
    updateTooltips($("#ageRange").slider("values", 0), $("#ageRange").slider("values", 1));
    // Add event listener for keyup on the input fields

$("#systolicRange").slider({
    range: true,
    min: 0,
    max: 250,
    values: [0, 250],
    slide: function (event, ui) {
        // Update global variables for systolic range
        currentSystolicMin = ui.values[0];
        currentSystolicMax = ui.values[1];

        // Update tooltips
        updateTooltips(ui.values[0], ui.values[1]);

        // Apply combined filters
        applyFilters();
    }
});

$("#diastolicRange").slider({
    range: true,
    min: 0,
    max: 250,
    values: [0, 250],
    slide: function (event, ui) {
        // Update global variables for systolic range
        currentDiastolicMin = ui.values[0];
        currentDiastolicMax = ui.values[1];

        // Update tooltips
        updateTooltipsDiastolic(ui.values[0], ui.values[1]);

        // Apply combined filters
        applyFilters();
    }
});

$("#heartRate").slider({
    range: true,
    min: 0,
    max: 200,
    values: [0, 200],
    slide: function (event, ui) {
        // Update global variables for systolic range
        currentHrateMin = ui.values[0];
        currentHrateMax = ui.values[1];

        // Update tooltips
        updateTooltipsHeart(ui.values[0], ui.values[1]);

        // Apply combined filters
        applyFilters();
    }
});

$("#rbg").slider({
    range: true,
    min: 0,
    max: 50,
    values: [0, 50],
    slide: function (event, ui) {
        // Update global variables for systolic range
        currentRBGMin = ui.values[0];
        currentRBGMax = ui.values[1];

        // Update tooltips
        updateTooltipsRBG(ui.values[0], ui.values[1]);

        // Apply combined filters
        applyFilters();
    }
});

$("#fbg").slider({
    range: true,
    min: 0,
    max: 50,
    values: [0, 50],
    slide: function (event, ui) {
        // Update global variables for systolic range
        currentFBGMin = ui.values[0];
        currentFBGMax = ui.values[1];

        // Update tooltips
        updateTooltipsFBG(ui.values[0], ui.values[1]);

        // Apply combined filters
        applyFilters();
    }
});

$("#hrslasteat").slider({
    range: true,
    min: 0,
    max: 48,
    values: [0, 48],
    slide: function (event, ui) {
        // Update global variables for systolic range
        currentHrslasteatMin = ui.values[0];
        currentHrslasteatMax = ui.values[1];

        // Update tooltips
        updateTooltipsHrslasteat(ui.values[0], ui.values[1]);

        // Apply combined filters
        applyFilters();
    }
});

function updateTooltipsDiastolic(start, end) {
    // Update tooltips for both handles
    $("#diastolicRange .ui-slider-handle").each(function (index) {
        // Check if custom-tooltip div already exists
        var tooltipDiv = $(this).find(".custom-tooltip-diastolic");
        if (tooltipDiv.length === 0) {
            // Append a new custom-tooltip div
            $(this).append("<div class='custom-tooltip-diastolic'></div>");
        }

        // Update the text content of the custom-tooltip
        tooltipDiv.text(index === 0 ? start : end);

        // Position the tooltip
        positionTooltipDiastolic(index);
    });
}

function updateTooltipsHeart(start, end) {
    // Update tooltips for both handles
    $("#heartRate .ui-slider-handle").each(function (index) {
        // Check if custom-tooltip div already exists
        var tooltipDiv = $(this).find(".custom-tooltip-heart");
        if (tooltipDiv.length === 0) {
            // Append a new custom-tooltip div
            $(this).append("<div class='custom-tooltip-heart'></div>");
        }

        // Update the text content of the custom-tooltip
        tooltipDiv.text(index === 0 ? start : end);

        // Position the tooltip
        positionTooltipHeart(index);
    });
}

function updateTooltipsRBG(start, end) {
    // Update tooltips for both handles
    $("#rbg .ui-slider-handle").each(function (index) {
        // Check if custom-tooltip div already exists
        var tooltipDiv = $(this).find(".custom-tooltip-rbg");
        if (tooltipDiv.length === 0) {
            // Append a new custom-tooltip div
            $(this).append("<div class='custom-tooltip-rbg'></div>");
        }

        // Update the text content of the custom-tooltip
        tooltipDiv.text(index === 0 ? start : end);

        // Position the tooltip
        positionTooltipRBG(index);
    });
}

function updateTooltipsFBG(start, end) {
    // Update tooltips for both handles
    $("#fbg .ui-slider-handle").each(function (index) {
        // Check if custom-tooltip div already exists
        var tooltipDiv = $(this).find(".custom-tooltip-fbg");
        if (tooltipDiv.length === 0) {
            // Append a new custom-tooltip div
            $(this).append("<div class='custom-tooltip-fbg'></div>");
        }

        // Update the text content of the custom-tooltip
        tooltipDiv.text(index === 0 ? start : end);

        // Position the tooltip
        positionTooltipFBG(index);
    });
}

function updateTooltipsHrslasteat(start, end) {
    // Update tooltips for both handles
    $("#hrslasteat .ui-slider-handle").each(function (index) {
        // Check if custom-tooltip div already exists
        var tooltipDiv = $(this).find(".custom-tooltip-hrslasteat");
        if (tooltipDiv.length === 0) {
            // Append a new custom-tooltip div
            $(this).append("<div class='custom-tooltip-hrslasteat'></div>");
        }

        // Update the text content of the custom-tooltip
        tooltipDiv.text(index === 0 ? start : end);

        // Position the tooltip
        positionTooltipHrslasteat(index);
    });
}

    // Function to position tooltips
function positionTooltipDiastolic(index) {
        $(".custom-tooltip-diastolic").eq(index).position({
            my: "center bottom",
            at: "center top",
            of: $("#diastolicRange .ui-slider-handle").eq(index)
        });
}
function positionTooltipHeart(index) {
        $(".custom-tooltip-heart").eq(index).position({
            my: "center bottom",
            at: "center top",
            of: $("#heartRate .ui-slider-handle").eq(index)
        });
}

function positionTooltipRBG(index) {
        $(".custom-tooltip-rbg").eq(index).position({
            my: "center bottom",
            at: "center top",
            of: $("#rbg .ui-slider-handle").eq(index)
        });
}

function positionTooltipFBG(index) {
        $(".custom-tooltip-fbg").eq(index).position({
            my: "center bottom",
            at: "center top",
            of: $("#fbg .ui-slider-handle").eq(index)
        });
}

function positionTooltipHrslasteat(index) {
        $(".custom-tooltip-hrslasteat").eq(index).position({
            my: "center bottom",
            at: "center top",
            of: $("#hrslasteat .ui-slider-handle").eq(index)
        });
}

    // Initial tooltips setup
    updateTooltips($("#diastolicRange").slider("values", 0), $("#diastolicRange").slider("values", 1));


    updateTooltips($("#heartRate").slider("values", 0), $("#heartRate").slider("values", 1));

    updateTooltips($("#rbg").slider("values", 0), $("#rbg").slider("values", 1));

    updateTooltips($("#fbg").slider("values", 0), $("#fbg").slider("values", 1));

    updateTooltips($("#hrslasteat").slider("values", 0), $("#hrslasteat").slider("values", 1));







    // Function to update tooltips
function updateTooltips(start, end) {
    // Update tooltips for both handles
    $("#systolicRange .ui-slider-handle").each(function (index) {
        // Check if custom-tooltip div already exists
        var tooltipDiv = $(this).find(".custom-tooltip");
        if (tooltipDiv.length === 0) {
            // Append a new custom-tooltip div
            $(this).append("<div class='custom-tooltip'></div>");
        }

        // Update the text content of the custom-tooltip
        tooltipDiv.text(index === 0 ? start : end);

        // Position the tooltip
        positionTooltip(index);
    });
}



    // Function to position tooltips
    function positionTooltip(index) {
        $(".custom-tooltip").eq(index).position({
            my: "center bottom",
            at: "center top",
            of: $("#systolicRange .ui-slider-handle").eq(index)
        });
    }

    // Initial tooltips setup
    updateTooltips($("#systolicRange").slider("values", 0), $("#systolicRange").slider("values", 1));
   


   

     $('#search').click(function () {
        var daterange = $('#daterange').val();
        var hc_id = $('#hc_id').val();
        const parts = daterange.split(" - ");
        const fdate = parts[0];
        const ldate = parts[1];
      
        var starting_age = $("#ageRange").slider("values", 0);
        var ending_age = $("#ageRange").slider("values", 1);
    

        $.ajax({
            type: "GET",
            url: "{{ url('hcanalysis-report') }}",
            data: { hc_id: hc_id, fdate: fdate, ldate: ldate, starting_age:starting_age, ending_age: ending_age},
            beforeSend: function () {
                $('#warning-searching').removeClass('invisible');
            },
            complete: function () {
                $('#warning-searching').addClass('invisible');
            },
        success: function (response) {
         
                var data = response.data_dump;
                 console.log(data);
                healthcenter = response?.healthcenter?.HealthCenterName || 'ALL';
  
              
                // healthcenter = response.healthcenter;
                collectionDate=fdate+"_To_"+ldate;
                // patients=response.resultCount;
                var tableBody = $('#dataTable tbody');

                // Clear the existing table rows
                table.clear().draw();

            if (data.length > 0) {
                  table.buttons(0).enable();
                $.each(data, function (index, result) {
                    var newRow = [
                        result.PatientId || '-',
                        result.CollectionDates || '-',
                        result.RegistrationId || '-',
                        result.GivenName || '-',
                        result.FamilyName || '-',
                        result.Gender || '-',
                        result.BirthDate || '-',
                        result.Age || '-',
                        result.MobileNo || '-',
                        result.Height || "-", // Handle missing data
                        result.Weight || "-", // Handle missing data
                        result.BMI || "-", // Handle missing data
                        result.BPSystolic1 || "-", // Handle missing data
                        result.BPDiastolic1 || "-", // Handle missing data
                        result.BPSystolic2 || "-", // Handle missing data
                        result.BPDiastolic2 || "-", // Handle missing data
                        result.HeartRate || "-", // Handle missing data
                        result.RBG || "-", // Handle missing data
                        result.FBG || "-", // Handle missing data
                        result.HrsFromLastEat || "-", // Handle missing data
                        result.Hemoglobin || "-", // Handle missing data
                        result.AnemiaSeverity || "-", // Handle missing data
                        result.CoughGreaterThanMonth || "-", // Handle missing data
                        result.LGERF || "-", // Handle missing data
                        result.NightSweat || "-", // Handle missing data
                        result.WeightLoss || "-", // Handle missing data
                        result.ChiefComplainWithDuration || "-", // Handle missing data
                        result.PhysicalFinding || "-", // Handle missing data
                        result.RxDetails || "-", // Handle missing data
                        result.Illnesses || "-", // Handle missing data
                        result.Diseases || "-", // Handle missing data
                        result.Vaccines || "-", // Handle missing data
                        result.SocialBehaviorCode || "-", // Handle missing data
                        result.Gravida || "-", // Handle missing data
                        result.StillBirth || "-", // Handle missing data
                        result.MisCarriageOrAbortion || "-", // Handle missing data
                        result.MR || "-", // Handle missing data
                        result.LivingBirth || "-", // Handle missing data
                        result.LivingMale || "-", // Handle missing data
                        result.LivingFemale || "-", // Handle missing data
                        result.ChildMorality0To1 || "-", // Handle missing data
                        result.ChildMoralityBelow5 || "-", // Handle missing data
                        result.ChildMoralityOver5 || "-", // Handle missing data
                        result.LMP || "-", // Handle missing data
                        result.ContraceptionMethod || "-", // Handle missing data
                        result.OtherContraceptionMethod || "-", // Handle missing data
                        result.MenstruationProduct || "-", // Handle missing data
                        result.OtherMenstruationProduct || "-", // Handle missing data
                        result.MenstruationProductUsageTime || "-", // Handle missing data
                        result.OtherMenstruationProductUsageTime || "-", // Handle missing data
                        result.ProvisionalDiagnosis || "-", // Handle missing data
                        result.PrescribedDrugs || "-", // Handle missing data
                        result.DiagnosticSuggestion || "-", // Handle missing data
                        result.PatientIllness || "-", // Handle missing data
                        result.FollowUpdate || "-", // Handle missing data


                       
                    ];

                    // Add a new row to the table
                    table.row.add(newRow).draw();
                });
                } else {
                    // Handle the case where there are no results (optional)
                    tableBody.html('<tr><td colspan="46">No results found</td></tr>');
                }
            },
        });
    });

    });
      $('#btn-reset').click(function () {
       
        table.clear().draw();
        $('#hc_id').val('').selectpicker('refresh');
        $('#starting_age').val('');
        $('#ending_age').val('');
        
    });

    $('#btn-filter').on('click', function (event) {
        $('#warning-searching').removeClass('invisible');
    });

    

</script>
@endpush
