<?php

class CM_CLI_Helper{
    public static function directory_builder($dir, $destination){
    	$files = scandir($dir);
    	if(!empty($files)){
    		foreach($files as $file){
    			if($file === '.' || $file === '..'){
    				//do nothing
    			}elseif(is_file($dir . '/' . $file)){
    				CM_CLI_Helper::copy("$dir/$file", "$destination/$file");
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
    	$rewards[] = "(mom's) spaghetti! 🍝";
    	$rewards[] = "rice! 🍚";
    	$rewards[] = "a drumstick! 🍗";
    	$rewards[] = "a beer! 🍺";
    	$rewards[] = "two beer! 🍻";
    	$rewards[] = "meat! 🍖";
    	return "All Done! Good Work! You deserve " . $rewards[mt_rand(0,14)];
    }

    public static function copy($source, $destination){
        global $chunker;

        $contents = file_get_contents($source);
        $contents = $chunker->replacer($contents);

        $basename = basename($source);
        if($basename === 'style.css'){
            $contents = CM_CLI_Helper::prepare_theme_meta($contents);
        }
        $contents = $chunker->chunk($source, $contents);

        file_put_contents($destination, $contents);
    }

    public function prepare_theme_meta($contents){
        global $template_vars;

        foreach($template_vars as $key => $value){
            $contents = str_replace("[[$key]]", $value, $contents);
        }

        return $contents;
    }
}
