<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ketentuan extends CI_Controller {

  function __construct()
  {
      parent::__construct();
      /* memanggil model untuk ditampilkan pada masing2 modul */
      $this->load->model(array('Crud_m'));
      /* memanggil function dari masing2 model yang akan digunakan */
    }
  public function detail($id)
	{


			$row = $this->Crud_m->get_by_id_post($id,'templates_id','templates','templates_judul_seo');
			if ($this->uri->segment('4')==''){
				$dari = 0;
				}else{
					$dari = $this->uri->segment('4');
			}
			if ($row)
				{
          $data['posts_produk'] = $this->Crud_m->view_where_order('templates',array('templates_status'=>'publish'),'templates_id','desc');
					$data['posts']            = $this->Crud_m->get_by_id_post($id,'templates_id','templates','templates_judul_seo');
          $data['posts_templates_category']= $this->Crud_m->view_one_limit('templates_category','templates_cat_status','templates_cat_id','ASC',$dari,'10');

          $data['menu'] = 'syarat-ketentuan';
					$data['identitas']= $this->Crud_m->get_by_id_identitas($id='1');
          $this->load->view('fronts/ketentuan/v_detail', $data);
				}
				else
						{
							$this->session->set_flashdata('message', '<div class="alert alert-dismissible alert-danger">
								<button type="button" class="close" data-dismiss="alert">&times;</button>Halaman tidak ditemukan</b></div>');
							redirect(base_url());
						}
	}

}
