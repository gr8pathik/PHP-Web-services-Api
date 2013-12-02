<?php
include("class.iniparser.php");
$config = new iniParser("settings.ini");
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
    <?php
      $rc = new ReflectionClass('Services');
      $commentPart = $rc->getDocComment();
    
      $methods = $rc->getMethods();
      /*print_r($methods);*/
      $classComment = getComment($commentPart);
      $listServices = array();
      foreach ($methods as $method) {
        $funcComment = $method->getDocComment();
        $storecomment = getComment($funcComment);
        if(!empty($storecomment)){
          $storecomment['function'] = $method;
          $listServices[$method->name] = (array)$storecomment;
        }
      }
      //print_r($listServices);
    ?>
</div>
<!--/.navbar -->
    <div class="navbar ">
  <div class="navbar-inner">
    <a class="brand" href="index.php"><?php echo ucfirst($siteInfo['name']);?> - Web Services</a>
    <ul class="nav">
      <li class="active"><a href="index.php">List</a></li>
      <li class="divider-vertical"></li>
      <li><a href="settings.php">Settings</a></li>
    </ul>
  </div>
</div>
<div id="container">
  <h1>List of all Webservices</h1>

  <div id="body">
    <table class="table table-hover">
      <tr>
        <th>Sr. No.</th>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
      <?php if(!empty($listServices)) : $i=1; ?>
      <?php foreach ($listServices as $key => $value): ?>
      <tr>
        <td><?php echo $i;?></td>
        <td><?php echo (isset($value['label']))?$value['label']:'';?></td>
        <td><?php echo (isset($value['desc']))?$value['desc']:'-';?></td>
        <td><a href="#" class="btn showBlock">Show</a></td>
      </tr>
      <tr class="hide">
        <td colspan="4">
          <form class="well servicesForm-<?php echo $i;?>" action="client.php" method="post">
            <input type="hidden" name="method" value="<?php echo $key;?>" />
            <div class="form-horizontal">
              <div class="control-group">
                <label class="control-label" for="data_string">Type</label>
                <div class="controls">
                  <select name="returnType">
                    <option value="json">JSON</option>
                    <option value="array">PHP Array</option>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="data_string">Request</label>
                <div class="controls">
                  <textarea name="data_string" id="data_string" class="input-xlarge span8" rows="10"><?php echo (!empty($value['requestVar']))?json_encode($value['requestVar'], JSON_PRETTY_PRINT):'';?></textarea>
                  <?php //print_r($value['param']);?>
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button type="button" class="btn btn-primary sendServices" data-loading-text="Sending..." data-i="<?php echo $i;?>">Send</button>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Response</label>
                <div class="controls">
                  <pre class="input-xlarge span8 showResponse-<?php echo $i;?>">
                  </pre>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">For Developer</label>
                <div class="controls">
                  <pre class="input-xlarge span8 showResponseDeveloper-<?php echo $i;?>">http://<?php echo $_SERVER['HTTP_HOST'];?>/webserviesphp/client.php</pre>
                </div>
                <?php $showArray = array('method' => $key, 'data_string' => $value['requestVar']);?>
                <div class="controls">
                  <pre class="input-xlarge span8 showResponseDeveloper-<?php echo $i;?>">post_data_string=<?php echo json_encode($showArray);?></pre>
                </div>
              </div>
            </div>
          </form>
        <td>
      </tr>
    <?php $i++; endforeach;?>
    <?php endif;?>
    </table>
  </div>
</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/services.js"></script>
  </body>
</html>