<?php

namespace Modules\ProductionAPI\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Http\Controllers\BaseController;
use Modules\ProductionAPI\Entities\ApiPatientList;
use Modules\ProductionAPI\Entities\ApiBsTrigView;
use Modules\ProductionAPI\Entities\ApiMedicineTrigView;

use Modules\ProductionAPI\Entities\PatientRegistration;
use Modules\ProductionAPI\Entities\RefApiFacility;
use App\Helpers\ApiHelper;

class PatientMedicineController extends BaseController
{
    protected $model;
    public function __construct(ApiMedicineTrigView $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

           if(permission('patient-medicine-access')){
            $facilities=RefApiFacility::get();
            $this->setPageData('Patient Medicine API','Patient Medicine API','fas fa-th-list');
            return view('productionapi::patient-medicine',compact('facilities'));
        }else{
                    return $this->unauthorized_access_blocked();
        }
     

    }

    public function register(Request $request)
    {
        // Authenticate and get the access token
        $identifier=$request->identifier;
        $sending_patient=intval($request->send_patient);



        $authData = ApiHelper::authenticate();

        if (isset($authData['error'])) {
            // Handle authentication error
            return response()->json(['error' => $authData['error']], 401);
        }

        $accessToken = $authData['access_token'];

        $responses = ApiHelper::SendMedicinePayload($accessToken, $identifier, $sending_patient);
        $successResponses= $responses['successResponses'];
        $errorResponses= $responses['errorResponses'];



        // Handle successful registration
        return response()->json([
            'success' => $successResponses,
            'error' => $errorResponses
        ]);
    }
    public function GetCount(Request $request)
    {
        $identifier=$request->identifier;
        $unsent = ApiMedicineTrigView::where('identifier',$identifier)->count();

        return response()->json([
        'unsent'=>$unsent
    ]);


    }
}
