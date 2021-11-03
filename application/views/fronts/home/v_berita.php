<section class="small_pb">
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
            	<div class="heading_s3 text-center">
                	<h2>Tips Pernikahan</h2>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="clearfix small_divider"></div>
            </div>
        </div>
        <div class="row blog_wrap justify-content-center">
						<?php foreach ($posts_blogs as $post_new){
								$isi = character_limiter($post_new->blogs_desk,150);
							 ?>
            <div class="col-lg-4 col-md-6 mb-md-4 mb-2 pb-2">
                <div class="blog_post blog_style1">
                    <div class="blog_img">
                        <a href="<?php echo base_url() ?>tips/<?php echo $post_new->blogs_judul_seo ?>">
													<img <?php
																if(empty($post_new->blogs_gambar)) {
																	echo "<img src='".base_url()."assets/frontend/default-1920-1080.jpg' alt='image'>";
																}else {
																	echo "<img src='".base_url()."assets/frontend/blogs/".$post_new->blogs_gambar."'> ";}
																?>
                        </a>
                        <span class="post_date bg_blue text-light"><?php echo $post_new->blogs_post_tanggal ?></span>
                    </div>
                    <div class="blog_content bg-white">
                        <div class="blog_text">
                            <h6 class="blog_title"><a href="<?php echo base_url() ?>tips/<?php echo $post_new->blogs_judul_seo ?>"><?php echo $post_new->blogs_judul ?></a></h6>
                            <ul class="list_none blog_meta">
                                <li>by
																	<?php
																	if(empty($post_new->blogs_update_oleh)) {
																		echo "$post_new->blogs_post_oleh";
																	}else {
																		echo "$post_new->blogs_update_oleh";}
																	?>
																</li>
                                <li><?php echo $post_new->blogs_dibaca ?> Kunjungan</li>
                        	</ul>
                            <p><?php echo $isi?><a href="<?php echo base_url() ?>tips/<?php echo $post_new->blogs_judul_seo ?>">...Lanjutkan</a></p>
                        </div>
                    </div>
                </div>
            </div>
					<?php } ?>
        </div>
    </div>
</section>
