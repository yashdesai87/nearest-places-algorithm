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
		// get all the locations
		$data['locations'] = $this->Location_model->get_all_locations();

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
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('latitude', 'Latitude', 'required|validate_latitude');
		$this->form_validation->set_rules('longitude', 'Longitude', 'required|validate_longitude');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('google_place_name', 'Place name', 'xss_clean');
		$this->form_validation->set_rules('google_place_address', 'Place address', 'xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('validate_latitude', 'Latitude is invalid');
		$this->form_validation->set_message('validate_longitude', 'Longitude is invalid');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if($this->form_validation->run())
		{
			$other_data = array(
				'google_place_name' => $this->input->post('google_place_name'),
				'google_place_address' => $this->input->post('google_place_address'),
			);

			$add_location = $this->Location_model->add_location($this->input->post('name'), $this->input->post('latitude'), $this->input->post('longitude'), $this->input->post('address'), $other_data);

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
		if(!$this->Location_model->check_if_location_is_valid($location_id))
		{
			$this->session->set_flashdata('error_message', 'Location not found');
			redirect();
			exit;
		}

		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('latitude', 'Latitude', 'required|validate_latitude');
		$this->form_validation->set_rules('longitude', 'Longitude', 'required|validate_longitude');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('google_place_name', 'Place name', 'xss_clean');
		$this->form_validation->set_rules('google_place_address', 'Place address', 'xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('validate_latitude', 'Latitude is invalid');
		$this->form_validation->set_message('validate_longitude', 'Longitude is invalid');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if($this->form_validation->run())
		{
			$other_data = array(
				'google_place_name' => $this->input->post('google_place_name'),
				'google_place_address' => $this->input->post('google_place_address'),
			);

			$edit_location = $this->Location_model->edit_location($location_id, $this->input->post('name'), $this->input->post('latitude'), $this->input->post('longitude'), $this->input->post('address'), $other_data);

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
		if(!$this->Location_model->check_if_location_is_valid($location_id))
		{
			$this->session->set_flashdata('error_message', 'Location not found');
			redirect();
			exit;
		}

		$delete_location = $this->Location_model->delete_location($location_id);

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
		if(!$this->Location_model->check_if_location_is_valid($location_id))
		{
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
