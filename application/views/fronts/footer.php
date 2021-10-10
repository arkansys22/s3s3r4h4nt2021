<footer style="background-color: #E1282F" class="footer_dark background_bg" data-img-src="<?php echo base_url()?>assets/frontend/campur/footer2.jpg">
    <div class="top_footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12" >
                    <h2>Crudbiz</h2>
                    <p><?php echo $identitas->meta_deskripsi?></p>
                    <ul class="list_none footer_social">

                        <li><a href="<?php echo $identitas->youtube?>"><i class="ion-social-youtube-outline" ></i></a></li>
                        <li><a href="<?php echo $identitas->instagram?>"><i class="ion-social-instagram-outline"></i></a></li>
                        <li><a href="<?php echo $identitas->facebook?>"><i class="ion-social-facebook"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-12 mt-4 mt-lg-0" >
                    <h2 >KONTAK KAMI</h2>
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

            </div>
        </div>
    </div>
    <div >
        <div class="bottom_footer border_top_tran">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright m-md-0 text-center text-md-left">&copy; 2021 All Rights Reserved by Crudbiz</p>
                </div>
                <!-- <div class="col-md-6">
                    <ul class="list_none footer_link text-center text-md-right">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                    </ul>
                </div> -->
            </div>
        </div>
    </div>
</footer>
