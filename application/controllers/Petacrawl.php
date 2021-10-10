<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Petacrawl extends CI_Controller {

 public function index(){
     $this->load->helper('url');
     $this->load->model('Sitemap_model');
     $data['klien'] = $this->Sitemap_model->generate_sitemap('bisnis','bisnis_id','bisnis_judul_seo','bisnis_post_hari','bisnis_post_tanggal','bisnis_post_jam');
     $data['templates'] = $this->Sitemap_model->generate_sitemap('templates','templates_id','templates_judul_seo','templates_post_hari','templates_post_tanggal','templates_post_jam');
     $data['paketharga'] = $this->Sitemap_model->generate_sitemap('paketharga','paketharga_id','paketharga_judul_seo','paketharga_post_hari','paketharga_post_tanggal','paketharga_post_jam');

     $this->load->view('fronts/v_sitemap',$data);
 }

}
