<?php
/*
Plugin Name:    Innovation List Shortcode
Description:    This plugin provides add Innovation list and  shortcode to list Innovation posts with slider.
Author:         Bhupesh Kushwaha
Author URI:     https://github.com/bhupeshbk
Version:        1.0.0
Text Domain:    innovation-list-shortcode
Domain Path:    /languages

    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


/* —————————————————————————————————————————————————————————————————————————————————————
* init Create Innovations Post Type
* ————————————————————————————————————————————————————————————————————————————————————— */
add_action( 'init', 'ils_create_post_type' );
function ils_create_post_type() { 
    // set up labels
    $labels = array(
        'name' 			=> 'Innovations',
        'singular_name' => 'Innovation',
        'add_new' 		=> 'Add New',
        'add_new_item'  => 'Add New Innovation',
        'edit_item' 	=> 'Edit Innovation',
        'new_item' 		=> 'New Innovation',
        'all_items' 	=> 'All Innovations',
        'view_item' 	=> 'View Innovation',
        'search_items'  => 'Search Innovations',
        'not_found' 	=>  'No Innovations Found',
        'not_found_in_trash' => 'No Innovations found in Trash',
        'parent_item_colon'  => '',
        'menu_name'		=> 'Innovations',
    );
    // set up register
    register_post_type(
        'innovations',
        array(
            'labels' 			=> $labels,
            'description'        => __( 'Description.', 'irs' ),
            'has_archive'	 	=> true,
            'public' 			=> true,
            'hierarchical'  	=> true,
            'supports' 			=> array( 'title', 'editor','thumbnail','excerpt' ),
            'exclude_from_search' => true,
            'capability_type' 	  => 'post',
            'menu_icon' => 'dashicons-images-alt',
        )
    );
} 
/* —————————————————————————————————————————————————————————————————————————————————————
* Register Css/JS
* ————————————————————————————————————————————————————————————————————————————————————— */
function ils_scripts()
{
    wp_enqueue_style( 'owl.carousel', plugins_url( '/basic/css/owl.carousel.css',  __FILE__ ) );
    wp_enqueue_style( 'owl.theme', plugins_url( '/basic/css/owl.theme.default.css',  __FILE__ ) );
    wp_enqueue_style( 'basic', plugins_url( '/basic/css/basic.css', __FILE__ ) );
    
    wp_register_script( 'owl.carousel-script', plugins_url( '/basic/js/owl.carousel.js', __FILE__ ) ,'' ,'', true);
    wp_enqueue_script( 'owl.carousel-script' );

    wp_register_script( 'jquery.simplemodal-script', plugins_url( '/basic/js/jquery.simplemodal.js', __FILE__ ) ,'' ,'', true );
    wp_enqueue_script( 'jquery.simplemodal-script' );

    wp_register_script( 'basic-script', plugins_url( '/basic/js/basic.js', __FILE__ ) ,'' ,'', true );
    wp_enqueue_script( 'basic-script' );
}
add_action( 'wp_enqueue_scripts', 'ils_scripts' );
/* —————————————————————————————————————————————————————————————————————————————————————
* Create Shortcode To list All Innovations [list-posts-innovation]
* ————————————————————————————————————————————————————————————————————————————————————— */
add_shortcode( 'list-posts-innovation', 'ils_post_listing_shortcode' );
function ils_post_listing_shortcode( $atts ) 
{
    ob_start();
    $query = new WP_Query( array(
		        'post_type' => 'innovations',
		        'posts_per_page' => -1,
		        'order' => 'ASC',
		        'orderby' => 'date',
		    ) );
    /*Slider*/
	if ( $query->have_posts() ) 
	{ 
	?>
		<div id="owl-demo" class="owl-carousel owl-theme">
		<?php	
			while ( $query->have_posts() ) : $query->the_post(); 
			?>
				<div class="item"> 
					<!--main-->
					<a class="avoid-clicks">
                        <?php 
                        if ( has_post_thumbnail() )
                        {
                            the_post_thumbnail();
                        } 
                        else 
                        { 
                        ?>
                            <img src="<?php echo plugins_url( '/basic/innovation-default.png', __FILE__ ); ?>" alt="<?php the_title(); ?>" />
                        <?php 
                        }
                        ?>
                    </a>
					<div class="list_cs" style="text-align: center;background:#ffffff;">
						<h1><?php the_title(); ?></h1>
						<p><?php the_excerpt(); ?></p>
						<p class="popup"><a href="#" id="<?php the_ID(); ?>">Read More</a></p>
						<!-- modal content -->
						<div class="basic-modal-content">
							<?php the_content(); ?>
						</div>
					</div>
					<!--end main--> 
				</div>
			<?php  
			endwhile;
			wp_reset_postdata();
			$myvariable = ob_get_clean();
			return $myvariable;
		?>
		</div>
	<?php
	}         
}
?>