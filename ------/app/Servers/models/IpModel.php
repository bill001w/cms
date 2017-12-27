<?php namespace App\Servers\models;

class IpModel extends Model {
	
	public function get_primary_key() {
		return $this->primary_key = 'id';
	}
	
}