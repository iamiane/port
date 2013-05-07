<?php get_header(); ?>
<div id="content">
	<?php if(have_posts()){ while(have_posts()){ the_post(); ?>
	
	<?php /* '0' => 'Full Width', '1' => 'Left Sidebar', '2' => 'Right Sidebar', '3' => 'Double Left Sidebar', '4' => 'Double Right Sidebar', '5' => 'Both Sides Sidebars' */ ?>
	<?php $post_layout = get_post_meta($post->ID, 'flow_post_layout', true); ?>
	
		<div class="extended-blog-single-title clearfix">
			<h1><?php if (get_post_meta($post->ID, 'Title', true)) { echo get_post_meta($post->ID, 'Title', true); }else{ the_title(); } ?></h1>
			<?php if(has_tag()){ echo '<div class="extended-blog-meta clearfix">'; } ?><small <?php if(has_tag() or true){ echo 'class="small-has-tag"'; } ?>>
				<div class="extended-blog-comments <?php if(get_comments_number() == '0'){ echo 'extended-blog-comments-zero'; } ?>">
					<div class="extended-blog-comment-icon">c</div>
					<div class="extended-blog-comments-value"><?php comments_popup_link('0', '1', '%'); ?></div>
				</div>
				<?php /* echo date_i18n(get_option('date_format'), strtotime($post->post_date)); */ ?>
				<?php the_time(__('F jS, Y', 'flowthemes')); ?>
			</small>
			<?php if(has_tag()){ echo '</div>'; } ?>
			<?php if(has_tag()){ ?><div class="extended-blog-single-tags"><?php the_tags(' ', ' '); ?></div><?php } ?>
		</div>
		
		<?php if($post_layout == 2){ ?>
			<div class="page-content right-sidebar-page clearfix container_12">
				<div class="grid_9 right-sidebar-page-content right-sidebar-post-content">
					<?php the_content(); ?>
				</div>
				<div class="grid_3 right-sidebar-page-sidebar">
					<div class="sidebar-left-shadow"></div>
					<div class="right-sidebar-container"><?php get_sidebar(); ?></div>
				</div>
			</div>
		<?php }else if($post_layout == 1){ ?>
			<div class="page-content left-sidebar-page clearfix container_12">
				<div class="grid_3 left-sidebar-page-sidebar">
					<div class="sidebar-right-shadow"></div>
					<div class="left-sidebar-container"><?php get_sidebar(); ?></div>
				</div>
				<div class="grid_9 left-sidebar-page-content left-sidebar-post-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php }else{ ?>
			<div class="extended-blog-single-container">
				<?php the_content(); ?>
			</div>
		<?php } ?>
		
	<?php } ?>
	
	<div class="extended-blog-container">
		<div id="comments-template" class="clearfix">
			<?php comments_template(); ?>
		</div>

		<?php
		$blog_related_posts = get_option('blog_related_posts'); // 0 = display, 1 = not display
		if($blog_related_posts == 0){
			$category = get_option('blog_exclude_categories');
			if(!is_array($category)){
				$category = array();
			}
			$post_per_page = 4;
			$do_not_show_stickies = 1; // 0 to show stickies
			$args = array(
				'category__not_in' => $category,
				'orderby' => 'date',
				'order' => 'DESC',
				'post__not_in' => array(get_the_ID()), // excludes this post
				'post_type' => array('post'),
				'posts_per_page' => $post_per_page,
				'caller_get_posts' => $do_not_show_stickies
			);
			$other_posts_query = new WP_Query($args); 
			if($other_posts_query->have_posts()){
				echo '<div class="related-posts related-posts-home clearfix">';
				while ($other_posts_query->have_posts()){ 
					$other_posts_query->the_post();
			?>
					<div class="related-posts-title">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						<small><?php the_time(__('F jS, Y', 'flowthemes')); ?></small>
					</div>
			<?php 
				}
				echo '</div>';
				$arrows_separator = '';
			}else{
				$arrows_separator = ' has-separator';
			}
		}
		?>
	</div> <!-- /.extended-blog-container -->
	<div class="navigation clearfix<?php echo $arrows_separator; ?>">
		<div class="alignright older_entries"><?php next_post_link('<div class="older_entries_text">%link </div><div class="older_entries_icon">></div>', __('Next', 'flowthemes')); ?></div>
		<div class="alignleft newer_entries"><?php previous_post_link('<div class="newer_entries_icon"><</div><div class="newer_entries_text"> %link</div>', __('Previous', 'flowthemes')); ?></div>
	</div>
	<?php }else{ ?>
		<h2 class="center"><?php _e('Not Found', 'flowthemes'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.', 'flowthemes'); ?></p>
	<?php } ?>
</div> <!-- /#content -->
<?php get_footer(); ?>