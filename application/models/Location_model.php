<?php

/**
 * Location_model
 *
 * @author 	Yash Desai
 * @link   	https://github.com/yashdesai87/nearest-places-algorithm
 */
class Location_model extends CI_Model {

	/**
	 * Fetch all the locations
	 *
	 * @param 	NULl
	 * @return  array (Returns all location data)
	 */
	public function get_all_locations()
	{
		return $this->db->get('locations')->result_array();
	}

	/**
	 * Fetch a particular location
	 *
	 * @param  integer $location_id (unique id of the location)
	 * @return  array (Returns data for a specific location)
	 */
	public function get_location_by_id($location_id)
	{
		return $this->db->get_where('locations', array('id' => $location_id))->row_array();
	}

	/**
	 * Add a new location
	 *
	 * @param  string $name (name of the location)
	 *         string $latitude (latitude of the location)
	 *         string $longitude (longitude of the location)
	 *         string $address (complete google address of the entered location)
	 *         
	 * @return  boolean
	 */
	public function add_location($name, $latitude, $longitude, $address)
	{
		$location_data = array(
			'name' => $name,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'address' => $address,
		);

		return $this->db->insert('locations', $location_data);
	}

}