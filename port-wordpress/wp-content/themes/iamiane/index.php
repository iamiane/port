<?php
/*
Template Name: home
*/
?>

<?php get_header(); ?>

<div class="container">

			<div class="cbp-af-header">
				<div class="cbp-af-inner">

					<ul class="the-link-effect">
						<a href="#link-work"><li>Work</li></a>
						<a href="#link-about"><li>About</li></a>
					</ul>

					
					<div class="logoMainWrap"><img class="logo" src="<?php echo get_template_directory_uri(); ?>/library/images/logo.png" /></div>
					

					<ul class="the-link-effect right">
						<a href="#link-contact"><li>Contact</li></a>
						<a href="http://www.linkedin.com/in/iamiane"><li>Linkedin</li></a>
					</ul>
				</div>
			</div>

			
			<div class="hero-content">	
				<h3>Hello, I am Ian Edwards</h3>
				<p>Web Designer, Illustrator and avid shoe wearer</p>

				<a href="#link-work" class="btn">Find out what I can do</a>

				<div class="arrow-down">
					<img class="floating-arrow" src="<?php echo get_template_directory_uri(); ?>/library/images/floating-arrow.png" alt=""/> 
				</div>


			</div>
				
            
            
			<div class="main">
				
                
               <section id="link-work">
                	<div class="wrapper">
                   
					<h2><div class="in-a-box">My Work</div></h2>

					<?php get_template_part( 'gallery-content', 'page' ); ?>

                 </div>
				</section>

                
                
				<section id="link-about">
                	<div class="wrapper clearfix">

                	<div class="about-me-img">
						<img src="<?php echo get_template_directory_uri(); ?>/library/images/me.jpg" width="150" height="150"  alt=""/> 
                  </div>
                  
					<h2><div class="in-a-box">Some Stuff About Me</div></h2>
					<div class="fourcol first">
                    
						<h3><span>Who</span></h3>
						<p>Hello, my name is Ian Edwards and I am a london based digital designer with experience in both agency and in house roles as well as some experience working freelance.</p> 

					</div>

					<div class="fourcol">
       
						<h3><span>What</span></h3>
						<p>I have had experience with illutration, flash, photoshop and coding. I am able to see a project through to the end from brainstorming, user experience, graphic design and front-end development.</p> 

					</div>

					<div class="fourcol">
                    
						<h3><span>Where</span></h3>
						<p>My work experience so far includes working for SAY Media, LBI and Media Ingenuity</p> 

					</div>

					<div class="twelvecol first">
						<a class="btn cv">If You Dont Beleive me Check Out My CV</a>						
					</div>

                    </div>
				</section>

				<section id="link-contact">
                	<div class="wrapper">
                    
					<h2><div class="in-a-box">Contact</div></h2>

					<?php echo do_shortcode( '[contact-form-7 id="9" title="port-email"]' ); ?>
                    </div>
				</section>
				
			</div>
            
  
<?php get_footer(); ?>
