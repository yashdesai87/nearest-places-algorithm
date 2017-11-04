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
	 * Check if a location is valid
	 *
	 * @param  integer $location_id (unique id of the location)
	 * @return  boolean
	 */
	public function check_if_location_is_valid($location_id)
	{
		$this->db->select('id');
		$location = $this->db->get_where('locations', array('id' => $location_id))->row_array();

		if(isset($location['id']))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add a new location
	 *
	 * @param  string $name (name of the location)
	 *         string $latitude (latitude of the location)
	 *         string $longitude (longitude of the location)
	 *         string $address (complete google address of the entered location)
	 *         array  $other_data (optional details about the location)
	 *         
	 * @return  boolean
	 */
	public function add_location($name, $latitude, $longitude, $address, $other_data = array())
	{
		$location_data = array(
			'name' => $name,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'address' => $address,
		);

		if(isset($other_data['google_place_name']))
			$location_data['google_place_name'] = $other_data['google_place_name'];

		if(isset($other_data['google_place_address']))
			$location_data['google_place_address'] = $other_data['google_place_address'];

		return $this->db->insert('locations', $location_data);
	}

	/**
	 * Edit an existing location
	 *
	 * @param  integer $location_id (unique id of the location)
	 * 		   string $name (name of the location)
	 *         string $latitude (latitude of the location)
	 *         string $longitude (longitude of the location)
	 *         string $address (complete google address of the entered location)
	 *         array  $other_data (optional details about the location)
	 *         
	 * @return  boolean
	 */
	public function edit_location($location_id, $name, $latitude, $longitude, $address, $other_data = array())
	{
		$location_data = array(
			'name' => $name,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'address' => $address,
		);

		if(isset($other_data['google_place_name']))
			$location_data['google_place_name'] = $other_data['google_place_name'];

		if(isset($other_data['google_place_address']))
			$location_data['google_place_address'] = $other_data['google_place_address'];

		return $this->db->update('locations', $location_data, array('id' => $location_id));
	}

	/**
	 * Delete an existing location
	 *
	 * @param  integer $location_id (unique id of the location)
	 * @return  boolean
	 */
	public function delete_location($location_id)
	{
		return $this->db->delete('locations', array('id' => $location_id));
	}

}