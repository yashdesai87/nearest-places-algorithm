<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location
 *
 * @author 	Yash Desai
 * @link   	https://github.com/yashdesai87/nearest-places-algorithm
 */
class Location extends CI_Controller {

	/**
	 * Init
	 *
	 * @param 	NULL
	 * @return 	NULL
	 */
	public function __construct()
	{
		parent::__construct();

		// load the Location_model
		$this->load->model('Location_model');
	}

    /**
	 * Lists all the locations
	 *
	 * @param 	NULL
	 * @return 	NULL
	 */
	public function index()
	{
		// set validation rules
		$this->form_validation->set_rules('address', 'Location', 'required');
		$this->form_validation->set_rules('latitude', 'Latitude', 'validate_latitude');
		$this->form_validation->set_rules('longitude', 'Longitude', 'validate_longitude');

		// set error messages for form validation
		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('validate_latitude', 'Latitude is invalid');
		$this->form_validation->set_message('validate_longitude', 'Longitude is invalid');

		// set error delimiters
		$this->form_validation->set_error_delimiters('<span>', '</span>');

		// set submit to true
		// if form submitted
		if($this->input->post())
		{
			$data['submit'] = true;
		}
		else
		{
			$data['submit'] = false;
		}

		// check if form is valid
		if($this->form_validation->run())
		{
			// set filter to true
			$data['filter'] = true;

			// build the start location array
			$data['from_location'] = array(
				'name' => 'Start Point',
				'latitude' => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude'),
				'address' => $this->input->post('address'),
				'marker_color' => 'yellow',
				'marker_label' => 'S',
			);

			$search_data = array(
				'from_latitude' => $this->input->post('latitude'),
				'from_longitude' => $this->input->post('longitude'),
				'radius' => $this->input->post('radius')
			);

			// get filtered locations
			$data['locations'] = $this->Location_model->get_all_locations("distance ASC", $search_data);
		}
		else
		{
			// set filter default to false
			$data['filter'] = false;

			// get all the locations
			$data['locations'] = $this->Location_model->get_all_locations();
		}

		// set layout partial view
		$data['_view'] = 'location/index';

		// set the basetemplate as main view
		$this->load->view('layout/basetemplate', $data);
	}

    /**
	 * Add new locations
	 *
	 * @param 	NULL
	 * @return 	NULL
	 */
	public function add()
	{
		// set validation rules
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('latitude', 'Latitude', 'required|validate_latitude');
		$this->form_validation->set_rules('longitude', 'Longitude', 'required|validate_longitude');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('google_place_name', 'Place name', 'xss_clean');
		$this->form_validation->set_rules('google_place_address', 'Place address', 'xss_clean');

		// set error messages for form validation
		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('validate_latitude', 'Latitude is invalid');
		$this->form_validation->set_message('validate_longitude', 'Longitude is invalid');

		// set error delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		// check if form is valid
		if($this->form_validation->run())
		{
			// build the other location data
			$other_data = array(
				'google_place_name' => $this->input->post('google_place_name'),
				'google_place_address' => $this->input->post('google_place_address'),
			);

			$add_location = $this->Location_model->add_location($this->input->post('name'), $this->input->post('latitude'), $this->input->post('longitude'), $this->input->post('address'), $other_data);

			// set the success / error flash message
			if($add_location == TRUE) 
			{
				$this->session->set_flashdata('success_message', 'Location added successfully');
			} 
			else 
			{
				$this->session->set_flashdata('error_message', 'Error occured while adding the location');
			}

			redirect();
			exit;
		}
		else
		{
			// set layout partial view
			$data['_view'] = 'location/add';

			// set the basetemplate as main view
			$this->load->view('layout/basetemplate', $data);
		}
	}

    /**
	 * Edit an existing location
	 *
	 * @param  integer $location_id (unique id of the location)
	 * @return 	NULL
	 */
	public function edit($location_id)
	{
		// check if location exists in db
		// if not then redirect with error message
		if(!$this->Location_model->check_if_location_is_valid($location_id))
		{
			// set the success / error flash message
			$this->session->set_flashdata('error_message', 'Location not found');
			redirect();
			exit;
		}

		// set validation rules
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('latitude', 'Latitude', 'required|validate_latitude');
		$this->form_validation->set_rules('longitude', 'Longitude', 'required|validate_longitude');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('google_place_name', 'Place name', 'xss_clean');
		$this->form_validation->set_rules('google_place_address', 'Place address', 'xss_clean');

		// set error messages for form validation
		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('validate_latitude', 'Latitude is invalid');
		$this->form_validation->set_message('validate_longitude', 'Longitude is invalid');

		// set error delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		// check if form is valid
		if($this->form_validation->run())
		{
			// build the other location data
			$other_data = array(
				'google_place_name' => $this->input->post('google_place_name'),
				'google_place_address' => $this->input->post('google_place_address'),
			);

			$edit_location = $this->Location_model->edit_location($location_id, $this->input->post('name'), $this->input->post('latitude'), $this->input->post('longitude'), $this->input->post('address'), $other_data);

			// set the success / error flash message
			if($edit_location == TRUE) 
			{
				$this->session->set_flashdata('success_message', 'Location updated successfully');
			} 
			else 
			{
				$this->session->set_flashdata('error_message', 'Error occured while updating the location');
			}

			redirect();
			exit;
		}
		else
		{
			// get the particular location
			$data['location'] = $this->Location_model->get_location_by_id($location_id);

			// set layout partial view
			$data['_view'] = 'location/edit';

			// set the basetemplate as main view
			$this->load->view('layout/basetemplate', $data);
		}
	}

    /**
	 * Delete existing location
	 *
	 * @param  integer $location_id (unique id of the location)
	 * @return 	NULL
	 */
	public function delete($location_id)
	{
		// check if location exists in db
		// if not then redirect with error message
		if(!$this->Location_model->check_if_location_is_valid($location_id))
		{
			// set the success / error flash message
			$this->session->set_flashdata('error_message', 'Location not found');
			redirect();
			exit;
		}

		$delete_location = $this->Location_model->delete_location($location_id);

		// set the success / error flash message
		if($delete_location == TRUE) 
		{
			$this->session->set_flashdata('success_message', 'Location deleted successfully');
		} 
		else 
		{
			$this->session->set_flashdata('error_message', 'Error occured while deleting the location');
		}

		redirect();
		exit;
	}

	/**
	 * View location on map
	 *
	 * @param  integer $location_id (unique id of the location)
	 * @return 	NULL
	 */
	public function map($location_id)
	{
		// check if location exists in db
		// if not then redirect with error message
		if(!$this->Location_model->check_if_location_is_valid($location_id))
		{
			// set the success / error flash message
			$this->session->set_flashdata('error_message', 'Location not found');
			redirect();
			exit;
		}

		// get the particular location
		$data['location'] = $this->Location_model->get_location_by_id($location_id);

		// set layout partial view
		$data['_view'] = 'location/map';

		// set the basetemplate as main view
		$this->load->view('layout/basetemplate', $data);
	}
}
