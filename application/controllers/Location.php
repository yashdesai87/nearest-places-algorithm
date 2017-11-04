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
		$data['_view'] = 'location/index';
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

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('validate_latitude', 'Latitude is invalid');
		$this->form_validation->set_message('validate_longitude', 'Longitude is invalid');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if($this->form_validation->run())
		{
			$add_location = $this->Location_model->add_location($this->input->post('name'), $this->input->post('latitude'), $this->input->post('longitude'), $this->input->post('address'));

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
			$data['_view'] = 'location/add';
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
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('latitude', 'Latitude', 'required|validate_latitude');
		$this->form_validation->set_rules('longitude', 'Longitude', 'required|validate_longitude');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');

		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('validate_latitude', 'Latitude is invalid');
		$this->form_validation->set_message('validate_longitude', 'Longitude is invalid');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if($this->form_validation->run())
		{
			$add_location = $this->Location_model->add_location($this->input->post('name'), $this->input->post('latitude'), $this->input->post('longitude'), $this->input->post('address'));

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
			$data['_view'] = 'location/add';
			$this->load->view('layout/basetemplate', $data);
		}
	}
}
