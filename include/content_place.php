<div class="custom-google-places-reviews-wap ">	
	<div class="custom-google-header">
		<div class="custom-google-header-image">
			<a target="_blank" href="<?php echo $data->result->url; ?>" >
				<img title="Business Logo" src="<?php echo $request_url; ?>" />
			</a> 
		</div>
		<div class="custom-google-header-content">
			<div class="custom-google-header-title"> 
			<a href="<?php echo $data->result->url; ?>" target="_blank">
				<?php echo $data->result->name; ?>
			</a>
			</div>
			<div class="custom-google-fr-starsnumb" ><span><?php echo $data->result->rating; ?></span> <?php echo __( 'out of 5 stars', 'cgpr_googlepalcereviews' ); ?></div>
			<div class="custom-google-fr-starslist-wrapper custom-google-fr-starslist-wrapper-google-review aaa">
				<div class="custom-google-fr-starslist-container">
					<div class="custom-google-fr-starslist-current" style="width: <?php echo $data->result->rating / 5 * 100 . "%"; ?>">
						<div class="custom-google-fr-star"></div>
						<div class="custom-google-fr-star"></div>
						<div class="custom-google-fr-star"></div>
						<div class="custom-google-fr-star"></div>
						<div class="custom-google-fr-star"></div>
					</div>
					<div class="custom-google-fr-starslist-background">
						<div class="custom-google-fr-star"></div>
						<div class="custom-google-fr-star"></div>
						<div class="custom-google-fr-star"></div>
						<div class="custom-google-fr-star"></div>
						<div class="custom-google-fr-star"></div>
					</div>
				</div>
			</div>			
			<span class="gpr-rating-time"><?php echo $data->result->rating; ?> <?php echo __( 'out of 5 stars', 'cgpr_googlepalcereviews' ); ?></span>
		</div>
	</div>
	<div class="custom-google-reviews-wrap">
	<?php 
	for($i=0; $i<count($data->result->reviews); $i++){
		$profile_picture = @$data->result->reviews[$i]->profile_photo_url;
		$author_url = $data->result->reviews[$i]->author_url;
		$description = $data->result->reviews[$i]->text;
		$author_name = $data->result->reviews[$i]->author_name; 
		$time = $data->result->reviews[$i]->time; 
		$rating = $data->result->reviews[$i]->rating; 
		if (strlen($description) > 250){
			$description = substr($description, 0, 250);
		}
		 ?>
		<div style="width:100%" class="custom-google-review custom-google-review-1">
			<div class="custom-google-review-header custom-google-clearfix">
				<div class="custom-google-review-avatar">
					<img src="<?php echo $profile_picture; ?>" alt="<?php echo $author_name; ?>" title="<?php echo $author_name; ?>"/>

				</div>
				<div class="custom-google-review-info custom-google-clearfix">
					<span class="grp-reviewer-name">
						<a target="_blank" href="https://www.google.com/maps/contrib/114848446501799714678/reviews" title="View this profile." 11>
							<span><?php echo $author_name; ?></span>
						</a>
					</span>

					<div class="custom-google-fr-starsnumb" ><span><?php echo $rating; ?></span> <?php echo __( 'out of 5 stars', 'cgpr_googlepalcereviews' ); ?></div>
						<div class="custom-google-fr-starslist-wrapper custom-google-fr-starslist-wrapper-google-review aaa">
							<div class="custom-google-fr-starslist-container">
							<div class="custom-google-fr-starslist-current" style="width: <?php echo $rating / 5 * 100; ?>%">
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
							</div>
							<div class="custom-google-fr-starslist-background">
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
								<div class="custom-google-fr-star"></div>
							</div>
							</div>
						</div>
				<span class="gpr-rating-time"><?php echo cgpr_google_time_elapsed_string($time); ?></span>
				</div>
			</div>
			<div class="custom-google-review-content">
				<div id="review-<?php echo $i; ?>" >
					<span class="review-item review-item-long ">
						<?php echo $description; ?>
					</span>
				</div>
			</div>
		</div>
	   <?php } ?>
	</div>
	<div class="clearfix"></div>
	<!-- write -->
	<a target='_blank' href='https://search.google.com/local/writereview?placeid=<?php echo $data->result->place_id; ?>'><?php echo __( 'Write a review', 'cgpr_googlepalcereviews' ); ?></a>
</div>