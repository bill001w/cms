<?php namespace App\Services\models;

class IpModel extends Model {
	
	public function get_primary_key() {
		return $this->primary_key = 'id';
	}
	
}