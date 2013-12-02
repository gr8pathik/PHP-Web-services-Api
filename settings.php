<?php 
include("class.iniparser.php");
$config = new iniParser("settings.ini");
$isUpdated = false;
if(isset($_POST) && isset($_POST['method']) && isset($_POST['settings'])){
	foreach ($_POST['settings'] as $key => $value) {
		# code...
		$config->set($key,$value);
		$isUpdated = true;
	}
	$config->save();
}
$dataValues = $config->getAllValues();
$siteInfo = $config->get('SITE');
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('services.php');?>
    <title>Web Serices</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style type="text/css">

  ::selection{ background-color: #E13300; color: white; }
  ::moz-selection{ background-color: #E13300; color: white; }
  ::webkit-selection{ background-color: #E13300; color: white; }

  body {
    background-color: #fff;
    margin: 40px;
    font: 13px/20px normal Helvetica, Arial, sans-serif;
    color: #4F5155;
  }

  h1 {
    color: #444;
    background-color: transparent;
    font-size: 19px;
    font-weight: normal;
    margin: 0;
    padding: 14px 15px 0px 15px;
  }

  #body{
    margin: 0 15px 0 15px;
  }
  
  p.footer{
    text-align: right;
    font-size: 11px;
    border-top: 1px solid #D0D0D0;
    line-height: 32px;
    padding: 0 10px 0 10px;
    margin: 20px 0 0 0;
  }
  
  #container{
    margin: 10px;
    border: 1px solid #D0D0D0;
    -webkit-box-shadow: 0 0 8px #D0D0D0;
  }
  .hide{
    display: none;
  }
  </style>
  </head>  
  <body>
</div>
<!--/.navbar -->
    <div class="navbar ">
  <div class="navbar-inner">
    <a class="brand" href="index.php"><?php echo ucfirst($siteInfo['name']);?> - Web Services</a>
    <ul class="nav">
      <li ><a href="index.php">List</a></li>
      <li class="divider-vertical"></li>
      <li class="active"><a href="settings.php">Settings</a></li>
    </ul>
  </div>
</div>
<div id="container">
  <h1>Webservices Settings</h1>

  <div id="body">
  	 <?php if($isUpdated){?>
  	 	<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <strong>Data Updated</strong>
        </div>
  	 <?php } ?>
	<form class="well" action="settings.php" name="settingsForm" method="post">
	<input type="hidden" name="method" value="setingsData" />
	<div class="form-horizontal">
		<?php foreach ($dataValues as $key => $value) {?>
			<legend><?php echo ucfirst(strtolower($key));?></legend>
			<?php foreach ($value as $key1 => $value1) {?>
				<div class="control-group">
					<label class="control-label" for="data_string"><?php echo ucfirst($key1);?></label>
					<div class="controls">
						<input type="text" name="settings[<?php echo $key;?>][<?php echo $key1;?>]" id="data_string" value="<?php echo $value1;?>" class="input-xlarge span4" />
					</div>
				</div>
			<?php }?>
		<?php }?>
	  
	  <div class="control-group">
	    <div class="controls">
	      <button type="submit" class="btn btn-primary" >Save</button>
	    </div>
	  </div>
	</div>
	</form>
  </div>
</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/services.js"></script>
  </body>
</html>