<?php

function validate_latitude($lat)
{
	if(preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $lat)) {
		return true;
	} else {
		return false;
	}
}

function validate_longitude($lng)
{
	if(preg_match('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $lng)) {
		return true;
	} else {
		return false;
	}
}