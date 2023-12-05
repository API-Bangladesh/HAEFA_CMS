<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">

      <!-- Modal Content -->
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-primary">
          <h3 class="modal-title text-white" id="model-1"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <!-- /modal header -->
        <form id="store_or_update_form" method="post">
          @csrf
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="HealthCenterId" value="" id="HealthCenterId"/>
                        <x-form.textbox labelName="Health Center Name" name="HealthCenterName" required="required" id="HealthCenterName" col="col-md-12" placeholder="Enter Health Center Name"/>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <x-form.textbox labelName="Health Center Code" name="HealthCenterCode" id="HealthCenterCode" required="required" col="col-md-12" placeholder="Enter Health Center Code"/>
                    </div>

                </div>

            </div>
            <!-- /modal body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm" id="save-btn"></button>
            </div>
            <!-- /modal footer -->
        </form>
      </div>
      <!-- /modal content -->

    </div>
  </div>
