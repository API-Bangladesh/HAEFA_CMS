<?php

namespace Modules\Upazila\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Patient\Entities\District;
use Modules\Upazila\Entities\Upazila;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Upazila\Http\Requests\UpazilaFormRequest;
use Illuminate\Support\Str;
use DB;

class UpazilaController extends BaseController
{
    protected $model;
    public function __construct(Upazila $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('upazila-access')){
            $this->setPageData('Upazila','Upazila','fas fa-th-list');
            $districts = District::get();
            return view('upazila::index',compact('districts'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    /**
     * Show data table data
     * @return $data
     */
    public function get_datatable_data(Request $request){
        if(permission('upazila-access')){
            if($request->ajax()){

                if (!empty($request->name)) {
                    $this->model->setName($request->name);
                }

                $this->set_datatable_default_property($request);
                $list = $this->model->getDatatableList();

                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';

                    if(permission('upazila-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('upazila-view')){
                       // $action .= ' <a class="dropdown-item view_data" data-id="' . $value->Id . '"><i class="fas fa-eye text-success"></i> View</a>';
                    }
                    if(permission('upazila-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->id . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }

                    $row = [];

                    if(permission('upazila-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }

                    $row[] = $no;
                    $row[] = $value->name;
                    $row[] = $value->district->name;
//                    $row[] = $value->bn_name;
                    // $row[] = permission('upazila-edit') ? change_status($value->Id,$value->Status,'refdepartment') : STATUS_LABEL[$value->Status];
                    $row[] = action_button($action);
                    $data[] = $row;
                }
                return $this->datatable_draw($request->input('draw'),$this->model->count_all(),
                 $this->model->count_filtered(), $data);
            }else{
                $output = $this->access_blocked();
            }

            return response()->json($output);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function store_or_update_data(UpazilaFormRequest $request)
    {
        if($request->ajax()){
            if(permission('upazila-add') || permission('upazila-edit')){
                try{
                    $collection = collect($request->validated());
                    if(isset($request->id) && !empty($request->id)){

                    $collection = collect($request->all());
                    //track_data from base controller to merge created_by and created_at merge with request data
                    $collection = $this->track_data_tables($request->id,$collection);
                    $result = $this->model->where('id', $request->id)->update($collection->all());

                    $output = $this->store_message($result,$request->id);
                    return response()->json($output);
                }
                else{

                    $collection = collect($request->all());
                    //track_data from base controller to merge created_by and created_at merge with request data
                    $collection = $this->track_data_tables($request->id,$collection);
                    //update existing index value
                    $result = $this->model->create($collection->all());
                    $output = $this->store_message($result,$request->id);
                    return response()->json($output);
                }

                }catch(\Exception $e){
                     return response()->json(['status'=>'error','message'=>$e->getMessage()]);
//                    return response()->json(['status'=>'error','message'=>'Something went wrong !']);
                }

            }else{
                $output = $this->access_blocked();
                return response()->json($output);
            }

        }else{
           return response()->json($this->access_blocked());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete(Request $request)
    {
        if($request->ajax()){
            if (permission('upazila-delete')) {
                $result = $this->model->where('id',$request->id)->delete();
                $output = $this->store_message($result,$request->Id);
                return response()->json($output);
            }else{
                return response()->json($this->access_blocked());
            }
        }else{
           return response()->json(['status'=>'error','message'=>'Something went wrong !']);
        }
    }

    /**
     * Status update
     * @return success or fail message
     */

     public function change_status(Request $request)
    {
        try{
            if($request->ajax()){
                if (permission('upazila-edit')) {
                       $result = $this->update_change_status($request);
                    if($result){
                        return response()->json(['status'=>'success','message'=>'Status Changed Successfully']);
                    }else{
                        return response()->json(['status'=>'error','message'=>'Something went wrong!']);
                    }
                }else{
                    $output = $this->access_blocked();
                    return response()->json($output);
                }
            }else{
                return response()->json(['status'=>'error','message'=>'Something went wrong!']);
            }
        }catch(\Exception $e){
            // return response()->json(['status'=>'error','message'=>'Something went wrong!']);
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function update_change_status(Request $request)
    {
        return $this->model->where('id',$request->Id)->update(['Status'=>$request->Status]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request)
    {
        if(permission('upazila-view')){
            if($request->ajax()){
                if (permission('upazila-view')) {
                    $Upazilas= DB::table('Upazila')->where('id','=',$request->id)->first();
                }
            }
            return view('upazila::details',compact('Upazilas'))->render();

        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request)
    {
      
         if($request->ajax()){
            if(permission('refvaccineadult-edit')){
               $output = Upazila::where('id',$request->id)->first();
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            try{
                if(permission('upazila-bulk-delete')){
                    $result = $this->model->whereIn('id',$request->ids)->delete();
                    $output = $this->bulk_delete_message($result);
                }else{
                    $output = $this->access_blocked();
                }
                return response()->json($output);
            }
            catch(\Exception $e){
                return response()->json(['status'=>'error','message'=>'Something went wrong !']);
            }
        }else{
            return response()->json($this->access_blocked());
        }
    }
}


