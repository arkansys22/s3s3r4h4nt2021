
<footer class="footer_dark">
	<div class="top_footer">
        <div class="container">
            <div class="row">
							<div class="col-sm-12 col-lg-4 col-md-6 mb-lg-0">
								<div class="footer_logo">
										<a href="<?php echo base_url()?>"><img height="100%" alt="logo" src="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->logo?>"></a>

								</div>
								<br>
								<p><?php echo $identitas->meta_deskripsi?></p>
								<ul class="list_none footer_social">
										<li><a href="<?php echo $identitas->facebook?>"><i class="ion-social-facebook"></i></a></li>
										<li><a href="https://api.whatsapp.com/send?phone=<?php echo $identitas->whatsapp?>&text=%20Halo%20Seserahant!"><i class="ion-social-whatsapp"></i></a></li>
										<li><a href="<?php echo $identitas->youtube?>"><i class="ion-social-youtube-outline"></i></a></li>
										<li><a href="<?php echo $identitas->instagram?>"><i class="ion-social-instagram-outline"></i></a></li>
								</ul>
								<br>
							</div>
                <div class="col-sm-12 col-lg-4 col-md-6 mb-4 mb-lg-0">
										<h6 class="widget_title">Kontak Kami</h6>
                    <ul class="contact_info contact_info_light list_none">
                        <li>
                            <span class="ti-location-pin"></span>
                            <address><?php echo $identitas->alamat?></address>
                        </li>
                        <li>
                            <span class="ti-email"></span>
                            <a href="mailto:<?php echo $identitas->email?>"><?php echo $identitas->email?></a>
                        </li>
                        <li>
                            <span class="ti-mobile"></span>
                            <a href ="tel:<?php echo $identitas->no_telp?>"><?php echo $identitas->no_telp?></a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-12  col-lg-4 col-md-6 mb-4 mb-lg-0">
                	<h6 class="widget_title">Syarat & Ketentuan</h6>
                    <ul class="list_none widget_links">
											<?php foreach ($posts_note as $post_new){  ?>
                    	<li><a href="<?php echo base_url("syarat-ketentuan/$post_new->note_judul_seo ") ?>"><?php echo $post_new->note_judul; ?></a></li>
										<?php } ?>
                    </ul>
										<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		                  <div class="modal-dialog modal-dialog-centered" role="document">
		                    <div class="modal-content">
		                      <div class="modal-header">
		                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
		                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                          <span aria-hidden="true">&times;</span>
		                        </button>
		                      </div>
		                      <div class="modal-body">
		                       <p>am eget neque pellentesque, efficitur neque at, ornare orci. Morbi convallis a eros fermentum rhoncus. Morbi convallis a eros fermentum rhoncus lorem. Vestibulum ligula orci, volutpat id aliquet eget, consectetur eget ante. Duis pharetra for nec rhoncus felis sagittis nec amet ultricies lorem.</p>
		                      </div>
		                      <div class="modal-footer">
		                        <button type="button" class="btn btn-black" data-dismiss="modal">Close</button>
		                        <button type="button" class="btn btn-default">Save changes</button>
		                      </div>
		                    </div>
		                  </div>
		                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer bg-dark">
    	<div class="container">
        	<div class="row align-items-center">
            	<div class="col-md-6">
                	<p class="copyright m-md-0 text-center text-md-left">&copy; 2021 Seserahant All Rights Reserved | Web Develop by Crudbiz</p>
                </div>
            </div>
        </div>
    </div>
</footer>
