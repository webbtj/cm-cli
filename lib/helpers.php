<?php

class CM_CLI_Helper{
    public static function directory_builder($dir, $destination){
    	$files = scandir($dir);
    	if(!empty($files)){
    		foreach($files as $file){
    			if($file === '.' || $file === '..'){
    				//do nothing
    			}elseif(is_file($dir . '/' . $file)){
    				copy("$dir/$file", "$destination/$file");
    			}else{
    				mkdir("$destination/$file");
    				CM_CLI_Helper::directory_builder("$dir/$file", "$destination/$file");
    			}
    		}
    	}
    }

    public static function reward(){
    	$rewards[] = "a tea! 🍵";
    	$rewards[] = "a cookie! 🍪";
    	$rewards[] = "a doughnut! 🍩";
    	$rewards[] = "ice cream! 🍦";
    	$rewards[] = "a treat! 🍧";
    	$rewards[] = "a fish cake! 🍥";
    	$rewards[] = "a fried shrimp! 🍤";
    	$rewards[] = "a roasted sweet potatoe! 🍠";
    	$rewards[] = "fries! 🍟";
    	$rewards[] = "spaghetti! 🍝";
    	$rewards[] = "rice! 🍚";
    	$rewards[] = "a drumstick! 🍗";
    	$rewards[] = "a beer! 🍺";
    	$rewards[] = "two beer! 🍻";
    	$rewards[] = "meat! 🍖";
    	return "All Done! Good Work! You deserve " . $rewards[mt_rand(0,14)];
    }
}
