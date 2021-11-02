<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller {

    function __construct()
  {
    parent::__construct();
    /* memanggil model untuk ditampilkan pada masing2 modul */
    $this->load->model(array('Crud_m'));
    /* memanggil function dari masing2 model yang akan digunakan */
  }

  public function index()
	{

    $jumlah= $this->Crud_m->views_row('blogs','blogs_status','blogs_id','DESC');
    $config['total_rows'] = $jumlah;
    $config['per_page_slider'] = 6;
    $config['per_page_bisnis'] = 10;
    if ($this->uri->segment('4')==''){
      $dari = 0;
      }else{
        $dari = $this->uri->segment('4');
    }

    if (is_numeric($dari)) {
			$config['per_page'] = 30;
			$data['identitas']= $this->Crud_m->get_by_id_identitas($id='1');
			$data['posts_templates_category']= $this->Crud_m->view_one_limit('templates_category','templates_cat_status','templates_cat_id','ASC',$dari,'10');
      $data['posts_slider'] = $this->Crud_m->view_one_limit('slider','slider_status','slider_id','DESC',$dari,$config['per_page_slider']);
      $data['posts_popular'] = $this->Crud_m->view_where_order('templates',array('templates_status'=>'publish'),'templates_id','desc');
      $data['posts_blogs'] = $this->Crud_m->view_where_order('blogs',array('blogs_status'=>'publish'),'blogs_id','desc');
      $data['posts_note'] = $this->Crud_m->view_where_order('note',array('note_status'=>'publish'),'note_id','asc');
      $data['posts_promo'] = $this->Crud_m->view_join_one('promo','templates','templates_id',array('promo_status'=>'publish'),'promo_id','DESC','0','1');
    }else{
			redirect('main');
		}
		$this->load->view('fronts/home/index',$data);
  }


}
