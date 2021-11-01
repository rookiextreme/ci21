<?php
namespace App\Models\Penilaian\Setting\Measuringlvl;

use Illuminate\Database\Eloquent\Model;

class DictBankMeasuringlvl extends Model{
	protected $table = 'dict_bank_measuring_lvls';

	public function dictColMeasuringLvls(){
        return $this->hasOne('App\Models\Collection\Setting\Measuringlvl\DictColMeasuringlvl', 'id', 'dict_col_measuring_lvls_id');
    }
}
