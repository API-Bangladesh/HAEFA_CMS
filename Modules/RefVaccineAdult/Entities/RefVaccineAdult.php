<?php

namespace Modules\RefVaccineAdult\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Base\Entities\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefVaccineAdult extends BaseModel
{
    protected $table = 'RefVaccineAdult';
    public $timestamps = false;

    protected $fillable = ['VaccineId','VaccineCode','Description','Instruction','VaccineDoseGroupId',
        'VaccineDoseType','VaccineDoseNumber','VaccineProviderType','SortOrder','Status','CreateUser','CreateDate',
        'UpdateUser','UpdateDate','OrgId'];

    protected $order = ['CreateDate'=>'desc'];

    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    private function get_datatable_query()
    {
        if(permission('refvaccine-bulk-delete')){
            //datatable display data from the below fields
            $this->column_order = [null,'VaccineCode','VaccineDoseNumber',null];
        }else{
            $this->column_order = ['VaccineCode','VaccineDoseNumber',null];
        }

        $query = self::toBase();

        /*****************
         * *Search Data **
         ******************/
        //
        if (!empty($this->name)) {
            $query->where('VaccineCode','like', '%'.$this->name.'%');
        }

        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } else if (isset($this->order)) {
            $query->orderBy(key($this->order), $this->order[key($this->order)]);
        }
        return $query;
    }

    public function getDatatableList()
    {
        $query = $this->get_datatable_query();
        if ($this->lengthVlaue != -1) {
            $query->offset($this->startVlaue)->limit($this->lengthVlaue);
        }
        return $query->get();
    }

    public function count_filtered()
    {
        $query = $this->get_datatable_query();
        return $query->get()->count();
    }

    public function count_all()
    {
        return self::toBase()->get()->count();
    }
}
