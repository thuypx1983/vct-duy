<?php 
class Tool_Skeleton extends Tool{//class name must be smiliar to filename, - replaced with _
	function setup(){
		//setup the tool , fn=setup, this function show the form, accept user input and then call $this->save to save database
	}
	function remove(){//uninstall, this function used to remove the tool, cleanup database
	//must call parent::cleanup() at the end
		parent::cleanup();
	}
	function about(){
		//show information about the tool, short description for user
	}
	function run(){//this is main function to run the tool, default function when fn=NULL
	}
}
?>