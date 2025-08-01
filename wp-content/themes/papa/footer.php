<!-- OBS -->
<footer class="footer">

	<div class="container flex footer-top">
		
		<!-- logo -->
		<div class="footer-logo">
			  <?php 
                  $image = get_field('footer_logo', 'option');
                  $size = 'full'; // (thumbnail, medium, large, full or custom size)
                  if( $image ) {
                      echo wp_get_attachment_image( $image, $size );
                  }
        ?>
		</div>

		<!-- green block -->
		<div class="footer-green flex">
			<!-- Categories menu -->
			<div class="footer-menu footer-adress">
				
				<?php dynamic_sidebar( 'sidebar-footer-area-1' ); ?>

			</div>

			<!-- Categories menu -->
			<div class="footer-menu footer-email">
				
				<?php dynamic_sidebar( 'sidebar-footer-area-2' ); ?>

			</div>

			<!-- information menu -->
			<div class="footer-menu footer-phone">

				<?php dynamic_sidebar( 'sidebar-footer-area-3' ); ?>
				
			</div>

			<div class="footer-social">
				
				<?php if( have_rows('footer_social', 'option') ): ?>
				    
				    <?php while( have_rows('footer_social', 'option') ): the_row(); 
				        $soc_name = get_sub_field('footer_social_name');
				        $soc_link = get_sub_field('footer_social_link');
				    ?>
				    	
				    	<a href="<?php echo $soc_link; ?>" target="_blank" rel="no-follow"><?php echo $soc_name; ?></a>

				    <?php endwhile; ?>
				    
				<?php endif; ?>

			</div>

			<div class="footer-copyrights">

				<p>©2022 Papa Poke. All rights reserved</p>

			</div>
		</div>

	</div>

</footer>

<?php wp_footer(); ?>

</body>

</html>