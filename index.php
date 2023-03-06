<?php ob_start();?>
<?php


$current_link = 'http://'.$_SERVER['HTTP_HOST' ].$_SERVER['REQUEST_URI'];


global $wpdb;
if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}lacni_phatsapp'") != $wpdb->prefix . 'lacni_phatsapp'){
  $wpdb->query("CREATE TABLE {$wpdb->prefix}lacni_phatsapp (
  id integer not null auto_increment,
  btntext TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  image TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  link TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  background TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,

  PRIMARY KEY (id)
  );");
}



add_action('admin_menu', 'lacni_phatsapp_message');

function lacni_phatsapp_message()
 {
 add_options_page('Lacni-Buttons','Whatsapp Contact', '8', 'lacnipos_phatsapp', 'lacni_phatsappfunctions');
 }


 function lacni_phatsappfunctions() {
    global $current_link;
 ?>


 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/forms-min.css">
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/buttons-min.css">
 <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/tables-min.css">


 <div style="margin-top:10px;">
 <h2>Whatsapp Communication System</h2>
 <form class="pure-form pure-form-aligned" method="post" action="">
    <fieldset>
        <div class="pure-control-group">
            <label for="name">Whatsapp Text</label>
            <input id="text" name="stickybuttontext" type="text" placeholder="Text">
        </div>

        <div class="pure-control-group">
            <label for="Image">Icon Link</label>
            <input id="text" name="stickybuttonimage" type="text" placeholder="Icon Link" value="https://whatsapp.com/favicon.png"> 
        </div>

        <div class="pure-control-group">
            <label for="Link">Phone number</label>
            <input id="text" name="stickybuttonlink" type="text" placeholder="Phone number">
        </div>

        <div class="pure-control-group">
            <label for="foo">Background </label>
            <input id="text" name="stickybuttonbgcolor" value="#29a9e8" type="color" placeholder="#29a9e8">
        </div>

        <div class="pure-controls">

            <button type="submit" class="pure-button pure-button-primary">Add</button>
        </div>
    </fieldset>
</form>
 </div>
<!-- Button List -->
<h2>Contact Button List</h2>

<table class="pure-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Text</th>
            <th>Phone number </th>
            <th>İcon</th>
            <th>Background</th>
            <th>Process</th>
        </tr>
    </thead>

    <tbody>
    <?php if($_GET["action"]=="delete"){
$back_page = $_SERVER['HTTP_REFERER'];
$deletebuttonid = $_GET["id"];
global $wpdb;
$deleteds = $wpdb->delete($wpdb->prefix.'lacni_phatsapp',array('id'=>$deletebuttonid));
    if($deleteds){
header("location: $back_page");
ob_end_flush();
    }}
    ?>
    <?php
global $wpdb;

$btnlist = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lacni_phatsapp order by id DESC" );
foreach($btnlist as $row)
{
?>
        <tr class="pure-table-odd">
            <td><?php echo $row->id;?></td>
            <td><?php echo $row->btntext;?></td>
            <td><?php echo $row->link;?></td>
            <td><?php echo $row->image;?></td>
            <td><?php echo $row->background;?></td>
            <td><a href="<?php echo $current_link;?>&action=delete&id=<?php echo $row->id;?>">Delete</a></td>

        </tr>
<?php } ?>

    </tbody>
</table>

<?php
if($_POST){

global $wpdb;


$stickybuttontext = $_POST["stickybuttontext"];
$stickybuttonimage = $_POST["stickybuttonimage"];
$stickybuttonlink = $_POST["stickybuttonlink"];
$stickybuttonbgcolor = $_POST["stickybuttonbgcolor"];

if(empty($stickybuttontext) or empty($stickybuttonlink)){
  echo '<div id="message" style="margin: 9px 0;" class="error notice notice-error is-dismissible below-h2"><p>Fill All Fields</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Hide Message.</span></button></div>';
}else{



$values=array(
        'btntext'=>$stickybuttontext,
        'image'=>$stickybuttonimage,
        'link'=>$stickybuttonlink,
        'background'=>$stickybuttonbgcolor
        );
$buttonadd = $wpdb->insert($wpdb->prefix.'lacni_phatsapp',$values);
}
if($buttonadd)
{
    echo '<div id="message" style="margin: 9px 0;" class="updated notice notice-success is-dismissible below-h2"><p>Button Added. <a target="_blank" href="'.get_bloginfo(url).'">View Site.</a></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Hide Message.</span></button></div>';
}

}
else{

}
?>

 <?php }

## Function ##
function lacni_phatsapp_mesaj()
{
?>

<!-- CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style>
.sticky-container {
  /* background-color: #333; */
  padding: 0px;
  margin: 0px;
  position: fixed;
  right: -140px;
  top: 130px;
  width: 200px;
  z-index: 9999999;
}
.sticky li {
  opacity: .5;
      border: 3px solid #E8E8E8;
      border-radius: 7px;
      list-style-type: none;
      background-color: #29a9e8;
      color: #efefef;
      height: 61px;
      padding: 0px;
      margin: 0px -35px 1px;
      -webkit-transition: all 0.6s ease-in-out;
      -moz-transition: all 0.6s ease-in-out;
      -o-transition: all 0.6s ease-in-out;
      transition: all 0.6s ease-in-out;
      cursor: pointer;
      /* filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter ….3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); */
      filter: gray;
      /* -webkit-filter: grayscale(100%); */
}
.sticky li:hover {
  opacity: 1;
  margin-left: -180px;
  /* background-color: #8e44ad; */
  -webkit-filter: grayscale(0%);
}
.sticky li img {
  display: block;
  /* float: left; */
    margin: -5px 5px;
      padding: 6px;
  margin-right: 10px;
}
.sticky li i {
  display: block;
  /* float: left; */
    margin: -5px 5px;
      padding: 6px;
  margin-right: 10px;
}
.sticky li p {
  position: relative;
bottom: 61px;
padding: 0px;
margin-left: 61px;
    line-height: 68px;
    font-size: 1.17em;
color: #fff;
z-index: -1;
}
</style>

<div class="sticky-container">
<ul class="sticky">
    <?php
global $wpdb;

$btnlist = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}lacni_phatsapp order by id ASC" );
foreach($btnlist as $row)
{
    ?>
<li style="background:<?php echo $row->background;?>">
<a href="https://api.whatsapp.com/send?phone=<?php echo $row->link;?>&text=<?php echo $row->btntext;?>" target="_blank">
<?php $detect = mb_substr($row->image,0,2);
if($detect=="fa"){
echo'<i style="font-size:50px;color:#fff" class="'.$row->image.'"></i>';
}else{?>
<img width="64" target="_blank" title="Whatsapp" alt="" src="<?php echo $row->image;?>" />
<?php }?>
</a>
<p>Whatsapp Contact</p>
</li>
<?php } ?>

</ul>
</div>
<?php
}
?>
