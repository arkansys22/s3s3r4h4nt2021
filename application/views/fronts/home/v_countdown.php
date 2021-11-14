<section class="gray_bg p-0">
	<div class="container-fluid">
    	<div class="row">
				<?php foreach ($posts_promo as $post_new){  ?>
        		<div class="col-md-5 col-sm-12 p-0">
							<img height="100%" src="<?php echo base_url()?>assets/frontend/promo/<?php echo $post_new->promo_gambar; ?>" alt="image">

						</div>
            <div class="col-md-7 col-sm-12">
            	<div class="h-100 d-flex align-items-center padding_eight_all">
                	<div>
                        <div class="heading_s1">
                            <h2><?php echo $post_new->promo_judul; ?></h2>
                        </div>

                        <div class="pr_detail">
                          <div class="product-description">
                            <div class="product-title">
                              <h4><a href="#"><?php echo $post_new->templates_judul; ?></a></h4>
                            </div>
                            <div class="product_price float-left">
                                <del>Rp<?php echo number_format($post_new->templates_harga,0,',','.') ?></del>
																<?php ($a = $post_new->templates_harga - ($post_new->templates_harga * ($post_new->promo_harga/100))); ?>
                                <ins>Rp<?php echo number_format($a,0,',','.') ?></ins>
                            </div>
														<div class="clearfix"></div>
	                          <span><?php echo $post_new->promo_limit; ?> Kuota Tersisa </span>
                            <div class="clearfix"></div>
														<br>
														<button type="button" class="btn btn-outline-primary mb-0" data-toggle="modal" data-target="#exampleModal">Detail Promo</button>
                            <p></p>
														<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						                  <div class="modal-dialog modal-dialog-centered" role="document">
						                    <div class="modal-content">
						                      <div class="modal-header">
						                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                          <span aria-hidden="true">&times;</span>
						                        </button>
						                      </div>
						                      <div class="modal-body">
						                       <p><?php echo $post_new->templates_desk; ?></p>
						                      </div>
						                      <div class="modal-footer">
						                        <button type="button" class="btn btn-black" data-dismiss="modal">Kembali</button>
						                      </div>
						                    </div>
						                  </div>
						                </div>

                          </div>
                          <hr>
                            <div class="cart_btn">
															<a href="https://api.whatsapp.com/send?phone=<?php echo $identitas->whatsapp?>&text= Halo Seserahant ! Aku mau ambil promo <?php echo $post_new->promo_judul; ?> <?php echo $post_new->templates_judul; ?> untuk pernikahan." class="btn btn-primary"><i class="ion-android-cart mr-2 ml-0"></i>Pesan Sekarang</a>
                            </div>
														<div class="clearfix"></div>
				                    <hr />
				                    <div class="product_share d-block d-sm-flex align-items-center">
				                      <span>Bagikan ke:</span>
				                        <ul class="list_none social_icons">
				                              <li><a href="http://www.facebook.com/sharer.php?u=<?php echo base_url("produk/$post_new->templates_judul_seo ") ?>" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo base_url("produk/$post_new->templates_judul_seo ") ?>','newwindow','width=400,height=350');  return false;" title="Facebook" target="_blank"><i class="ion-social-facebook"></i></a></li>
				                              <li><a href="whatsapp://send?text=<?php echo $post_new->templates_judul ?> | <?php echo base_url("produk/$post_new->templates_judul_seo ") ?>"><i class="ion-social-whatsapp"></i></a></li>
				                        </ul>
				                    </div>
                        </div>
                        <div class="countdown_time  bg-white border py-sm-4 py-3 mt-4" data-time="<?php echo $post_new->promo_selesai_tanggal; ?> <?php echo $post_new->promo_selesai_jam; ?>"></div>
                    </div>
                </div>
            </div>
					<?php } ?>
        </div>
    </div>
</section>
