<?php
//Gravityform
function my_acf_flexible_content_layout_title( $title, $field, $layout, $i ) {
  
  $title = '';
  if( $text = get_sub_field('layout_title') ) {
    
    $title .= '<span>' . $text . '</span>';
    
  }
  return $title;
  
}
add_filter('acf/fields/flexible_content/layout_title', 'my_acf_flexible_content_layout_title', 10, 4);