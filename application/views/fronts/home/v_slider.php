<section class="banner_section p-0">
    <div id="carouselExampleFade" class="carousel slide carousel-fade light_arrow2 slide_height_700" data-ride="carousel" data-pause="false">
        <div class="carousel-inner">
            <?php  foreach ($posts_slider as $post_new){ ?>
              <?php
                if(empty($post_new->slider_gambar)) {
                  echo "<div class='carousel-item active background_bg' data-img-src='".base_url()."assets/images/blog_small_img1_350X198.jpg'>";
                  }else {
                  echo " <div class='carousel-item ".$post_new->slider_meta_aktiv." background_bg' data-img-src='".base_url()."assets/frontend/slider/".$post_new->slider_gambar."'> ";}
                  ?>
                           <div class="banner_slide_content">
                               <div class="container"><!-- STRART CONTAINER -->
                               <div class="row">
                                   <div class="col-lg-8 col-9">
                                       <div class="banner_content shop_banner animation" data-animation="fadeInRight" data-animation-delay="0.8s">
                                         <h4 class="animation text_default" data-animation="fadeInRight" data-animation-delay="0.9s">Best Selling</h4>
                                           <h2 class="animation text-uppercase" data-animation="fadeInRight" data-animation-delay="1s">New Collection</h2>
                                           <p class="animation my-4" data-animation="fadeInRight" data-animation-delay="1.5s">Lorem is simply text of the printing and typesetting industry.</p>
                                           <a class="btn btn-default radius_none animation" href="#" data-animation="fadeInRight" data-animation-delay="1.8s">Shop Now</a>
                                       </div>
                                   </div>
                               </div>
                           </div><!-- END CONTAINER-->
                           </div>
                          </div>

            <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
            <i class="ion-chevron-left"></i>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
            <i class="ion-chevron-right"></i>
        </a>
    </div>
</section>
