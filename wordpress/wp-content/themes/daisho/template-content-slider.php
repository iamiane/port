<?php
/* Template Name: Content Slider Page Template */ 
?> 
<?php get_header(); ?>
<div class="page-template-wrapper">
	<header class="page-header">
		<div class="page-title">
		<?php if (get_post_meta($post->ID, 'Title', true)) { ?>
			<?php echo get_post_meta($post->ID, 'Title', true); ?>
		<?php }else{ ?>
			<?php the_title(); ?>
		<?php } ?>
		</div>
		<?php if (get_post_meta($post->ID, 'Description', true)) { ?>
			<div class="page-description"><?php echo get_post_meta($post->ID, 'Description', true); ?></div>
		<?php } ?>
	</header>
	<?php if($ipad){ ?>
	<style type="text/css">
	.scrollbar-arrowright { width: 60px; margin-right: 30px; }
	</style>
	<?php } //ipad ?>
	<div class="news-container-outer">
		<div class="news-container">
			<?php if( have_posts() ) : 
				while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			<?php else : ?>
			<?php endif; ?>
		</div>
	</div> <!-- /.news-container-outer -->
	<div class="scrollbar-arrowleft scrollbar-arrowleft-inactive" style="display:none;"></div>
	<div class="scrollbar-arrowright" style="display:none;"></div>
</div> <!-- /#content -->
<?php get_footer(); ?>