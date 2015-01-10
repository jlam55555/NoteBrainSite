<?php
	
	/** 
	 *	This accepts string values, and tidies the text up by removing whitespace. It may also change case and remove special characters.
	 *	$data: the string to tidy
	 *	$case: leave empty to leave the case, or change it to true for uppercase or false for lowercase.
	 *	&spec_char: leave empty to leave as is, or change it to true to remove special characters (actually converting them to their entity, for security).
	 */
	function tidy($data, $case=null, $spec_char=null) {
		$data = trim($data);
		if(isset($case))
			if($case)
				$data = strtoupper($data);
			else
				$data = strtolower($data);
		if(isset($spec_char) && $spec_char)
			$data = htmlentities($data);
		return $data;
	}
	
	/*
	 *	This is a simple checker-function that accepts string values. You can modify the type patterns and use this as a simple checker for other programs.
	 *	You should run tidy() on $data before using this, especially if the data is not text.
	 *	$data: the string to check
	 *	$min_len, $max_len: the minimum and maximum length constraints of $data
	 *	$type: the type constraint of $data
	 */
	function check($data, $min_len, $max_len, $type) {
		if(strlen($data) < $min_len || strlen($data) > $max_len)
			return false;
		switch($type) {
			case "user":	// checking username
				if(preg_match("/[^A-Za-z0-9\._]/",$data))
					return false;
				break;
			case "email":	// checking email
				if(!preg_match("/[A-Za-z0-9_\.]+@[A-Za-z0-9]+\.[A-Za-z]+/",$data))
					return false;
				break;
			case "plain":	// checking plain text
				if(preg_match("/[^A-Za-z ]/",$data))
					return false;
				break;
			case "text":	// checking regular text
			default:
				if(preg_match("//",$data))	// WORKING ON THIS
					return false;
		}
		return true;
	}
	
?>