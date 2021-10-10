<section id="testi" class="small_pb small_pt">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
                <div class="heading_s4 text-center">
                	<span class="sub_title">Kesan & Pesan</span>
                    <h2>Para Klien Crudbiz</h2>
                </div>
					</div>
        </div>
				<div class="row mb-md-5 mb-3">
            <div class="col-md-12">
                <div class="testimonial_slider testimonial_style1 carousel_slide3 owl-carousel owl-theme" data-margin="30" data-loop="true" data-center="true" data-autoplay="true">
									<?php  foreach ($posts_testimoni as $post_new){
										?>

										<div class="item">
				                <div class="testimonial_box">
				                    <div class="testimonial_img">

																<?php
	                                  if(empty($post_new->testimoni_gambar)) {
	                                  echo "<img src='".base_url()."assets/frontend/campur/testimoni.png'>";
	                                  }else {
	                                  echo " <img src='".base_url()."assets/frontend/testimoni/".$post_new->testimoni_gambar."'> ";}
	                              ?>

				                    </div>
				                    <div class="testi_meta">
				                        <h6><?php echo $post_new->testimoni_judul?></h6>
				                        <span><?php echo $post_new->testimoni_jabatan?></span>
				                        <p><?php echo $post_new->testimoni_desk?></p>
				                    </div>
				                </div>
				            </div>

									<?php } ?>
                </div>
            </div>
        </div>
</section>
