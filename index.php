<html>
<head>
<title>Suraj&rsquo;s Weather Website</title>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/
bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/
bootstrap-theme.min.css">
<style>
body {
    font-size: 3em;
	font-family: "Times New Roman", Times, serif;
	background: #800000;
	background-image:url("photo-1442120108414-42e7ea50d0b5.jpg");
	background-size:cover;
	background-position:center;
}
.elements{
	text-align:center;
	
}
.display{
	color:#ffffff;
}
#button{
	width: 10em;  
}
#text{
		height: 5%;
		width:60%;
		margin-left: auto;
		margin-right: auto;
}
</style>
</head>
<body background = "pic">
<div class="elements">
 <h1><b>WEATHER WEBSITE</b></h1>
<form action ="index.php" method="post">

Search by:
  <input type ="radio" name="searchby" value="city_name" required>City
  <input type ="radio" name="searchby" value="zip_value">Zip
  <input type ="radio" name="searchby" value="geo_loc">Geographic Location
  <br>
  <input type="text" id="text" class="form-control" name="entry" value="" placeholder="e.g. Search by Harrison for city, 07029 for zip code or 40.97, -73.71 for geo co-ordinates. You can check five day for 5 day weather forecast" required >
  
Five day:  
  <input type="checkbox" name="resultoption" value="five_day">Five Day Forecast<br>
  <input type="submit" id="button" class="btn btn-success btn-lg" name ="submit" value="Submit">
  
  </div>
  </form>
  <div class="display">
  <?php
  
  if ($_POST["submit"]) {
	  	echo "You are searching by entering ".$_POST["entry"] ;
	  if (isset($_POST["searchby"])){
		//echo $_GET["searchby"];
		if (($_POST["searchby"])=="city_name"){
			echo " for city name"."<br />";
			if (isset($_POST["resultoption"]))
				do5day();
			else
				docity();
			
		}
		elseif(($_POST["searchby"]) == "zip_value"){
			echo " for zip value"."<br />";
			if (isset($_POST["resultoption"]))
				do5day_zip();
			else
				dozip();
			
		}
		elseif(($_POST["searchby"]) == "geo_loc"){
			echo " for latitude and longitude values"."<br />";
			if (isset($_POST["resultoption"]))
				do5day_geo();
			else
				dogeo();
			
			
		}
	} 
		  

	
  }
  
   function docity(){
	   $_POST["entry"] = str_replace(' ', '%20', $_POST["entry"]);
  
   $url = "http://api.openweathermap.org/data/2.5/weather?q=".$_POST["entry"]."&APPID=503830f051e7f1eac47ff727c255e925";
   display_parameters($url);
	
   }
   
   function dozip(){
	   $_POST["entry"] = str_replace(' ', '', $_POST["entry"]);
  
   $url = "http://api.openweathermap.org/data/2.5/weather?zip=".$_POST["entry"]."&APPID=503830f051e7f1eac47ff727c255e925";
	display_parameters($url);
	
   }
   
   function dogeo(){
	   $_POST["entry"] = str_replace(' ', '', $_POST["entry"]);
	   $geo_coords = explode(",",$_POST["entry"]);
	   
		$url = "http://api.openweathermap.org/data/2.5/weather?lat=".$geo_coords[0]."&lon=".$geo_coords[1]."&&APPID=503830f051e7f1eac47ff727c255e925";
		display_parameters($url);
   
	
   }
   function display_parameters($url){
	
   $content = file_get_contents($url);
    $json = json_decode($content, TRUE);
	$max_temp = $json['main']['temp_max'] - 273.15;
	$min_temp = $json['main']['temp_min'] - 273.15;
	
	$city = $json['name'];
	$country = $json['sys']['country'];
	if (!(isset($city))){
		echo "Sorry! We couldn't process your request. Please try again with different values.";
	}
	else{
	//echo $city;
	echo "We are showing weather details for: ".$city.","." $country"."<br />";
	
	
	$weather = array($json['weather']);
	
	$weather2 = array($json['weather']);
	echo "Description: ".$weather[0][0]['description']."<br />";
	echo "Maximum Temperature: ".$max_temp." &deg;C"."<br />";
	echo "Minimum Temperature: ".$min_temp." &deg;C"."<br />";
	echo "Humidity: ".$json['main']['humidity']." %"."<br />";
	echo "Wind Speed: ".$json['wind']['speed']." m/s"."<br />";
	echo "Pressure: ".$json['main']['pressure']." hpa"."<br />";}
	
	
	
   }
   function do5day(){
	$_POST["entry"] = str_replace(' ', '%20', $_POST["entry"]);
	$url = "http://api.openweathermap.org/data/2.5/forecast?q=".$_POST["entry"]."&APPID=503830f051e7f1eac47ff727c255e925";
	$content = file_get_contents($url);
    $json = json_decode($content, TRUE);
	$city = $json['city']['name'];
	$country = $json['city']['country'];
	
	if (!(isset($city))){
		echo "Sorry! We couldn't process your request. Please try again with different values.";
	}
	
	else{
	echo "We are showing weather details for: ".$city.","." $country"."<br />";
	echo "<strong>"."5-DAY FORECAST"."</strong>"."<br /><br />";
	
	for ($x = 0; $x <= 4; $x++) {
    echo "Date: ".$json['list'][$x]['dt_txt']."<br />";
	echo "Description: ".$json['list'][$x]['weather'][0]['description']."<br />";
	echo "Minimum Temperature: ".$json['list'][$x]['main']['temp_min']."<br />";
	echo "Maximum Temperature: ".$json['list'][$x]['main']['temp_max']."<br /><br />";}
	
	} 
   }
	 function do5day_zip(){
	$_POST["entry"] = str_replace(' ', '%20', $_POST["entry"]);
	$url = "http://api.openweathermap.org/data/2.5/forecast?zip=".$_POST["entry"]."&APPID=503830f051e7f1eac47ff727c255e925";
	$content = file_get_contents($url);
    $json = json_decode($content, TRUE);
	$city = $json['city']['name'];
	$country = $json['city']['country'];
	
	if (!(isset($city))){
		echo "Sorry! We couldn't process your request. Please try again with different values.";
	}
	
	else{
	echo "We are showing weather details for: ".$city.","." $country"."<br />";
	echo "<strong>"."5-DAY FORECAST"."</strong>"."<br />";
	for ($x = 0; $x <= 4; $x++) {
    echo "Date: ".$json['list'][$x]['dt_txt']."<br />";
	echo "Description: ".$json['list'][$x]['weather'][0]['description']."<br />";
	echo "Minimum Temperature: ".$json['list'][$x]['main']['temp_min']."<br />";
	echo "Maximum Temperature: ".$json['list'][$x]['main']['temp_max']."<br /><br />";
	
	}
	} 
	 }
	function do5day_geo(){
		$_POST["entry"] = str_replace(' ', '', $_POST["entry"]);
	   
	$geo_coords = explode(",",$_POST["entry"]);
	   
		$url = "http://api.openweathermap.org/data/2.5/forecast?lat=".$geo_coords[0]."&lon=".$geo_coords[1]."&&APPID=503830f051e7f1eac47ff727c255e925";
		
	//$url = "http://api.openweathermap.org/data/2.5/forecast?zip=".$_GET["entry"]."&APPID=503830f051e7f1eac47ff727c255e925";
	$content = file_get_contents($url);
    $json = json_decode($content, TRUE);
	$city = $json['city']['name'];
	$country = $json['city']['country'];
	
	if (!(isset($city))){
		echo "Sorry! We couldn't process your request. Please try again with different values.";
	}
	
	else{
	echo "We are showing weather details for: ".$city.","." $country"."<br />";
	
	echo "<strong>"."5-DAY FORECAST"."</strong>"."<br />";
	echo "<hr>";
	for ($x = 0; $x <= 4; $x++) {
    echo "Date: ".$json['list'][$x]['dt_txt']."<br />";
	echo "Description: ".$json['list'][$x]['weather'][0]['description']."<br />";
	echo "Minimum Temperature: ".$json['list'][$x]['main']['temp_min']."<br />";
	echo "Maximum Temperature: ".$json['list'][$x]['main']['temp_max']."<br /><br />";
	}
	} 
	
	}
	 
   
?>
</div>  
</body>
</html>