<?php

$this->load->view('layout/header');

if(isset($_view))
	$this->load->view($_view);

$this->load->view('layout/footer');

?>