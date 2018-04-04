<img src="<?php echo get('Image'); ?>">

...<?php echo $field['Image'][1] ?>


<?php
  // second way to get the fields
 
  // get_group we return an array with all groups and fields of the group
  // the parameter to this function is the name of the group
  $images = get_group('image');
  // to see how this made the arrangement can use pr($miembros);
  // the way this arrangement is made
  // [index of the group] [field name] [index of the field]
  // for fields image type level but in accordance with the letter "o" to the original image or "t" for thumbnail
  foreach($images as image){
    echo image['nombre_miembro'][1]."<br />";
    echo image['puesto_miembro'][1]."<br />";
    echo "<img src='".$miembro['foto_miembro'][1]['t']."'><br /><br />";
  }
?>