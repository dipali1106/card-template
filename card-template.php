<?php
/*
 * Template Name: card
 * description: >-
  Page template without sidebar
 */

  wp_enqueue_style('custom-style',get_template_directory_uri( __FILE__ ) .'/template-style.css');

    $post_per_page = 10;
    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
    $offset = ( $page * $post_per_page ) - $post_per_page;
    $url='https://jsonplaceholder.typicode.com/comments';  
    $arguments=array(
        'method'=> 'GET',
    );
    $response=wp_remote_get($url,$arguments);

    if( is_wp_error( $response )  ){
        $error_msg=$response->get_error_message();
        echo "something went wrong:$error_msg";
    }

    $results=json_decode(wp_remote_retrieve_body($response));
      $total=count($results);
    $final = array_splice($results, $offset, $post_per_page);


?>
<?php
      

get_header();?>


<section id="content">
    <?php ?>
    <div class="container">
        <div class="author-heading">
            <h2><?php echo $atts['title']; ?></h2>
        </div>
            <div class="card-major">
                <div>
                <?php
            if ( $final ) : 

             foreach($final as $key => $value): 
             echo '<div class="card-data">';        
        foreach($value as $index => $element): ?>
           <?php echo '<div>' .$element. '<br/></div>'; 
            ?>

        <?php endforeach; 

        echo '</div>';

     endforeach;    
            echo '<div class="pagination">';
echo paginate_links( array(
'base' => add_query_arg( 'cpage', '%#%' ),
'format' => '',
'prev_text' => __('&laquo;'),
'next_text' => __('&raquo;'),
'total' => ceil($total / $post_per_page),
'current' => $page,
'type' => 'list'
));
echo '</div>'; 
            endif;?>
                </div>

    
    </div>

</div>
</section>

<?php
/* Restore original Post Data */
wp_reset_postdata();
 
?>
<?php get_footer(); ?>