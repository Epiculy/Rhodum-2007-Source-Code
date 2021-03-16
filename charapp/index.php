<?php
	
	// These appearances are hardcoded and like this because this feature wasn't finished before I closed the project

	header("Content-Type: text/plain");

	$DefaultAppearance = "http://pork.co.nf/charapp/DefaultColors";
	$Appearance = "";

	$Name = $_GET["uname"];

	if (preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $Name))
	{
		if ($Name == "Username") 
		{
			$Appearance = "http://pork.co.nf/charapp/DefaultColors;http://www.roblox.com/asset/?id=2972302&version=1";
		} 
		elseif ($Name == "AnotherUsername")
		{
			$Appearance = "http://pork.co.nf/charapp/DefaultColors;http://www.roblox.com/asset?id=1028606&version=2";
		} 
		elseif ($Name == "User")
		{
			$Appearance = "http://pork.co.nf/charapp/DefaultColors;http://www.roblox.com/asset/?id=2972302&version=1";
		}
		else
		{
			$Appearance = $DefaultAppearance;
		}
	} else {
		$Appearance = $DefaultAppearance;
	}

	echo $Appearance;

?>
