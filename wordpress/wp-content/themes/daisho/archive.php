<?php get_header(); ?>
<div id="content">
	<h1 class="blog-title"><?php wp_title(' ', true, ''); ?>
	<?php
	/* if(is_day()){
		printf(__( 'Daily Archives: %s', 'flowthemes'), '<span>'.get_the_date().'</span>');
	}else if(is_month()){
		printf(__( 'Monthly Archives: %s', 'flowthemes'), '<span>'.get_the_date(_x('F Y', 'monthly archives date format', 'flowthemes')).'</span>');
	}else if(is_year()){
		printf(__( 'Yearly Archives: %s', 'flowthemes'), '<span>'.get_the_date(_x('Y', 'yearly archives date format', 'flowthemes')).'</span>');
	}else{
		wp_title(' ', true, '');
	} */
	?>
	</h1>
	
	<?php
	if(is_category()){
		$category_description = category_description();
		if(!empty( $category_description)){
			echo '<div class="blog-description">' . $category_description . '</div>';
		}
	}else if(is_tag()){
		$tag_description = tag_description();
		if(!empty($tag_description)){
			echo '<div class="blog-description">' . $tag_description . '</div>';
		}
	} ?>
		
	<div class="extended-blog-container">	

<?php if(have_posts()){ ?>
 <?php while(have_posts()) : the_post(); ?>  
		<div class="extended-blog-entry clearfix">
			<div class="extended-blog-title"><h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1><div class="extended-blog-comments <?php if(get_comments_number() == '0'){ echo 'extended-blog-comments-zero'; } ?>"><div class="extended-blog-comment-icon">c</div><div class="extended-blog-comments-value"><?php comments_popup_link('0', '1', '%'); ?></div></div><small>
			<?php /* echo date_i18n(get_option('date_format'), strtotime($post->post_date)); */ ?>
			<?php the_time(__('F jS, Y', 'flowthemes')); ?>
			</small><div class="extended-blog-tags"><?php the_tags(' ', ' '); ?></div></div>
			
			<div class="extended-blog-content clearfix">
			<?php if (get_post_meta($post->ID, 'blog-full-image', true)){ ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<img class="extended-blog-image" src="<?php echo get_post_meta($post->ID, 'blog-full-image', true); ?>" alt="<?php the_title(); ?>" /></a>
			<?php } ?>
			<?php echo summarise_excerpt(get_the_excerpt(), 55); ?></div>

		</div>
    <?php endwhile; ?>
	</div> <!-- /.extended-blog-container -->
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }else{ ?>
		<div class="navigation">
			<div class="alignright older_entries"><?php next_posts_link('<div class="older_entries_text">'.__('Older Entries ', 'flowthemes').'</div><div class="older_entries_icon">></div>'); ?></div>
			<div class="alignleft newer_entries"><?php previous_posts_link('<div class="newer_entries_icon"><</div><div class="newer_entries_text">'.__(' Newer Entries', 'flowthemes').'</div>'); ?></div>
		</div>
		<?php } ?>
  <?php }else{ ?>
		<h2 class="center"><?php _e('Not Found', 'flowthemes'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.', 'flowthemes'); ?></p>
		<?php get_search_form(); ?>
	<?php } ?>
</div> <!-- /#content -->
<?php get_footer(); ?>