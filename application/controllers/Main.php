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
			$data['posts']= $this->Crud_m->view_one_limit('blogs','blogs_status','blogs_id','desc',$dari,$config['per_page']);
      $data['posts_paketharga']= $this->Crud_m->view_one_limit('paketharga','paketharga_status','paketharga_id','ASC',$dari,$config['per_page']);
      $data['posts_templates_category']= $this->Crud_m->view_one_limit('templates_category','templates_cat_status','templates_cat_id','desc',$dari,$config['per_page']);
      $data['posts_slider'] = $this->Crud_m->view_one_limit('slider','slider_status','slider_id','DESC',$dari,$config['per_page_slider']);
      $data['posts_bisnis'] = $this->Crud_m->view_one_limit('bisnis','bisnis_status','bisnis_id','ASC',$dari,$config['per_page_bisnis']);
      $data['posts_testimoni'] = $this->Crud_m->view_one_limit('testimoni','testimoni_status','testimoni_id','ASC',$dari,$config['per_page_bisnis']);
      $data['posts_templates'] = $this->Crud_m->view_join_one('templates','templates_category','templates_cat_id',array('templates_status'=>'publish'),'templates_id','DESC',$dari,$config['per_page']);
    }else{
			redirect('main');
		}
		$this->load->view('fronts/home/index',$data);
  }


}
