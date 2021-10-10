<section>
	   <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
                <div class="heading_s4 text-center">
                	<span class="sub_title">Daftar Harga</span>
                    <h2>Sesuaikan Dengan Bisnis Anda</h2>
                </div>
					</div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <ul class="portfolio_gallery portfolio_style4 carousel_slide4 owl-carousel owl-theme" data-margin="15" data-dots="false" data-autoplay="true" data-nav="true" data-loop="true" data-autoplay-timeout="2000">
								<?php  foreach ($posts_paketharga as $post_new){
									?>
                  <li class="portfolio-item">
                    <div class="portfolio_item">

														<?php
																											if(empty($post_new->paketharga_gambar)) {
																												echo "<img src='".base_url()."assets/frontend/campur/harga_22.jpg'>";
																											}else {
																												echo " <a href='".base_url()."harga/$post_new->paketharga_judul_seo' class='image_link'><img src='".base_url()."assets/frontend/paketharga/".$post_new->paketharga_gambar."'> ";}
																											?>

                          </a>
                    </div>
                  </li>
								<?php } ?>
              </ul>
          </div>
      </div>
    </div>
</section>
