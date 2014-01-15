	<?php
/*
Template Name: item
*/
?>

<?php get_header(); ?>

  <div class="header-work">
            <div class="contained">
				<a class="back" href="<?php echo home_url(); ?>">&larr; Home</a>
			</div>

			
            
            
			<div class="main">
				
                
               <section>
                   <div class="wrapper">
                         
							<h2><div class="in-a-box"><?php the_field('title'); ?></div></h2>
                         <h3 class="work-sub"><?php the_field('client'); ?></h3>

                         <?php the_field('description'); ?>
                         
                   </div>
				</section>
                
                <section>
                   <div class="wrapper clearfix">
                       <?php the_field('imgs'); ?>
                       <?php the_field('go to'); ?>
                   </div>
				</section>

                  <section>
                   <div class="wrapper">
                   <h2><div class="in-a-box">Other Work</div></h2>
                      <?php get_template_part( 'gallery-content', 'page' ); ?>
                   </div>
				</section>

        <?php get_footer(); ?>