
<footer class="footer_dark">
	<div class="top_footer">
        <div class="container">
            <div class="row">
							<div class="col-lg-3 col-md-6">
								<div class="footer_logo">
										<a href="<?php echo base_url()?>"><img height="250px"alt="logo" src="<?php echo base_url()?>assets/frontend/campur/<?php echo $identitas->logo?>"></a>
									</div>
							</div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">

                    <p><?php echo $identitas->meta_deskripsi?></p>
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
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                	<h6 class="widget_title">Syarat & Ketentuan</h6>
                    <ul class="list_none widget_links">
                    	<li><a href="#">Pendaftaran</a></li>
                      <li><a href="#">Pengantaran</a></li>
                      <li><a href="#">Catatan Penting!</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="widget_title">SOSMED</h6>
                    <ul class="list_none footer_social">
                    	  <li><a href="<?php echo $identitas->facebook?>"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="<?php echo $identitas->whatsapp?>"><i class="ion-social-whatsapp"></i></a></li>
                        <li><a href="<?php echo $identitas->youtube?>"><i class="ion-social-youtube-outline"></i></a></li>
                        <li><a href="<?php echo $identitas->instagram?>"><i class="ion-social-instagram-outline"></i></a></li>
                    </ul>
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
