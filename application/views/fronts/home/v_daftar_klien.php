<section id="klien" class="small_pt small_pb">
	<div class="container-fluid">
		<div class="row">
					<div class="col-sm-12" >
							<div class="heading_s4 text-center">
								<span class="sub_title">Daftar Klien</span>
									<h2>Daftar Klien</h2>
							</div>
							<p><center>Terbukti mampu memberikan hasil yang sesuai dengan karakter Bisnis Anda</center></p>
					</div>
			</div>
    	<div class="row">
        	<div class="col-md-12 animation" data-animation="fadeInUp" data-animation-delay="0.2s">
            	<ul class="list_none carousel_slide2 owl-carousel gallery_hover_style3" data-loop="true" data-margin="15" data-dots="false" data-autoplay="true" data-center="true">
								<?php  foreach ($posts_bisnis as $post_new){
									?>
										<li>

												<a href="<?php echo base_url("klien/$post_new->bisnis_judul_seo")?>">
                            	<div class="gallery_img">
																<?php
																					 if(empty($post_new->bisnis_gambar)) {
																						 echo "<img src='".base_url()."assets/images/blog_small_img1_350X198.jpg'>";
																					 }else {
																						 echo " <img src='".base_url()."assets/frontend/linibisnis/".$post_new->bisnis_gambar."'> ";}
																					 ?>
                                </div>
												</a>

                    </li>
										<?php } ?>
                </ul>
            </div>
        </div>
    </div>
</section>
