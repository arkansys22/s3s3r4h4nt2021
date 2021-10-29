<section class="small_pt small_pb">
    <div class="container">
    	<div class="row">
        	<div class="col-md-12">
            	<div class="heading_s1 heading_uppercase">
                	<h2>Popular Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="carousel_slide4 owl-carousel owl-theme nav_top" data-margin="30" data-nav="true" data-dots="false">
                  <?php foreach ($posts_popular as $post_new){  ?>
                    <div class="item">
                        <div class="shop-item">
                            <div class="product ">
                                <div class="product_img">
                                    <a href="#">
                                      <img src="<?php echo base_url()?>assets/frontend/produk/<?php echo $post_new->templates_gambar; ?>" alt="image">
                                    </a>
                                    <div class="product_action_box">
                                        <ul class="list_none pr_action_btn">
                                            <li><a href="https://bestwebcreator.com/anger/demo/shop-quick-view.html" class="popup-ajax"><i class="ion-eye"></i></a></li>
                                            <li class="add-to-cart"><a href="#"><i class="ion-android-cart"></i></a></li>
                                            <li><a href="#"><i class="ion-ios-heart-outline"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <div class="product_title">
                                        <h5><?php echo $post_new->templates_judul; ?></h5>
                                    </div>
                                    <div class="product_price">
                                      <del>Rp1.550.000</del>
                                      <ins>Rp1.050.000</ins>
                                    </div>
                                    <div align="left">
                                        <span>99 Terjual</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                  <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
