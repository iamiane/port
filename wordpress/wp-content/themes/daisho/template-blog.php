<?php
/* Template Name: Blog Template */ 
?> 
<?php get_header(); ?>
<div id="content">
	<?php if(get_post_meta($post->ID, 'Title', true)){ ?>
		<h1 class="blog-title"><?php echo get_post_meta($post->ID, 'Title', true); ?></h1>
	<?php } ?>
	<?php if(get_post_meta($post->ID, 'Description', true)){ ?>
		<div class="blog-description"><?php echo get_post_meta($post->ID, 'Description', true); ?></div>
	<?php } ?>
		<div class="extended-blog-container">	
<?php 
$category = get_option('blog_exclude_categories');
if(!is_array($category)){
	$category = array();
}

/* global $page, $paged;
if($paged >= 2 || $page >= 2){
	echo ' | ' . sprintf( __('Page %s', 'flowthemes'), max($paged, $page ));
} */
		
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$post_per_page = 6; // -1 shows all posts
if(get_option('blog_items_per_page') != ''){
	$post_per_page = get_option('blog_items_per_page'); // -1 shows all posts
}
$do_not_show_stickies = 1; // 0 to show stickies
$args=array(
	'category__not_in' => $category,
	'orderby' => 'date',
	'order' => 'DESC',
	'paged' => $paged,
	'posts_per_page' => $post_per_page,
	'caller_get_posts' => $do_not_show_stickies
);
$temp = $wp_query;  // assign orginal query to temp variable for later use   
$wp_query = null;
$wp_query = new WP_Query($args); 
if($wp_query->have_posts()){
	while ($wp_query->have_posts()){ $wp_query->the_post(); ?>
		<div class="extended-blog-entry clearfix">
			<div class="extended-blog-title">
				<h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
				<div class="extended-blog-comments <?php if(get_comments_number() == '0'){ echo 'extended-blog-comments-zero'; } ?>">
					<div class="extended-blog-comment-icon">c</div>
					<div class="extended-blog-comments-value"><?php comments_popup_link('0', '1', '%'); ?></div>
				</div>
				<small><?php /* echo date_i18n(get_option('date_format'), strtotime($wp_query->post->post_date)); */ ?><?php the_time(__('F jS, Y', 'flowthemes')); ?></small>
				<div class="extended-blog-tags"><?php the_tags(' ', ' '); ?></div>
			</div>
			<div class="extended-blog-content clearfix">
				<?php if(get_post_meta($post->ID, 'blog-full-image', true)){ ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<img class="extended-blog-image" src="<?php echo get_post_meta($post->ID, 'blog-full-image', true); ?>" alt="<?php the_title(); ?>" />
					</a>
				<?php } ?>
				<?php echo summarise_excerpt(get_the_excerpt(), 55); ?>
			</div>
		</div>
    <?php } ?>
		</div> <!-- /.extended-blog-container -->
		<?php if(function_exists('wp_pagenavi')){ wp_pagenavi(); }else{ ?>
		<div class="navigation clearfix">
			<div class="alignright older_entries"><?php next_posts_link('<div class="older_entries_text">'.__('Older Entries ', 'flowthemes').'</div><div class="older_entries_icon">></div>'); ?></div>
			<div class="alignleft newer_entries"><?php previous_posts_link('<div class="newer_entries_icon"><</div><div class="newer_entries_text">'.__(' Newer Entries', 'flowthemes').'</div>'); ?></div>
		</div>
		<?php } ?>
<?php }else{ ?>
		<h2 class="center"><?php _e('Not Found', 'flowthemes'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.', 'flowthemes'); ?></p>
<?php }
	$wp_query = $temp; //reset back to original query
?>
</div> <!-- /#content -->
<?php get_footer(); ?>