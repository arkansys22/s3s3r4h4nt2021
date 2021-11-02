<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Aspanel extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	public function index()
	{
			redirect(base_url('login'));
	}
	public function home()
	{
		if ($this->session->level=='1'){
			$data['home_stat']   = '';
			$this->load->view('backend/home', $data);
		}elseif ($this->session->level=='2'){
			$data['home_stat']   = '';
			$this->load->view('backend/home', $data);
		}elseif ($this->session->level=='3'){
			$data['home_stat']   = '';
				$this->load->view('backend/home', $data);
		}else{
			redirect(base_url());
		}
	}
	public function login()
	{
            $data['title'] = 'Sign In';
						$data['identitas']= $this->Crud_m->get_by_id_identitas($id='1');
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if($this->form_validation->run() === FALSE){
                $this->load->view('backend/index', $data);
            } else {

                $username = $this->input->post('username');
								$password = sha1($this->input->post('password'));
								$cek = $this->As_m->cek_login($username,$password,'user');
							    $row = $cek->row_array();
							    $total = $cek->num_rows();
									if ($total > 0){
										$this->session->set_userdata(
											array(
												'username'=>$row['username'],
												'level'=>$row['level'],
												'id_users'=>$row['id_users'],
												'id_session'=>$row['id_session']));

										 $this->session->set_flashdata('user_loggedin','Selamat Anda Berhasil Login');
										$id = array('id_session' => $this->session->id_session);
									 	$data = array('user_login_status'=>'online','user_login_tanggal'=> date('Y-m-d'),'user_login_jam'=> date('H:i:s'));
									 	$this->db->update('user', $data, $id);
										redirect('aspanel/home');
									}else {
                    // Set message
                    $this->session->set_flashdata('login_failed', 'Username Dan Password salah!');

                    redirect(base_url('login'));
                }
            }
        }
	public function register()
	{
						$data['title'] = 'Sign Up';
            $this->form_validation->set_rules('username','','trim|required|min_length[5]|max_length[30]|is_unique[user.username]', array('trim' => '','min_length'=>'Minimal 5 karakter','max_length'=>'Maksimal 30 karakter','required' => 'username masih kosong','is_unique' => 'Username telah digunakan, silahkan gunakan username lain.'));
						$this->form_validation->set_rules('nama','','trim|required', array('trim' => '','required'=>'Nama masih kosong'));
            $this->form_validation->set_rules('email','','trim|required|valid_email|is_unique[user.email]', array('trim' => '','required' => 'Email masih kosong','is_unique' => 'Email telah digunakan, silahkan gunakan email lain.'));
            $this->form_validation->set_rules('password','','trim|required', array('trim' => '','required'=>'Password masih kosong'));
            $this->form_validation->set_rules('password2', '','trim|required|matches[password]', array('trim' => '','required' => 'Konfirmasi password masih kosong','matches'=>'Password tidak sama! Cek kembali password Anda'));

            if($this->form_validation->run() != false){
							if (isset($_POST['submit']))
								{
									$nama = $this->input->post('nama');
									$username = $this->input->post('username');
									$email = $this->input->post('email');
									$password = hash("sha512", md5($this->input->post('password')));
									$cek = $this->Crud_m->cek_register($username,$email,'user');
								    $total = $cek->num_rows();
									if ($total > 0)
										{
										$data['title'] = 'Periksa kembali email dan password Anda!';
										redirect(site_url('daftar'));
										}else{
										        $saltid   = md5($email);
														$data = array(
																						'username'=>$this->input->post('username'),
																						'password'=>hash("sha512", md5($this->input->post('password'))),
																						'nama'=>$this->input->post('nama'),
																						'email'=>$this->db->escape_str($this->input->post('email')),
																						'user_status'=> '0',
																						'user_post_hari'=>hari_ini(date('w')),
							                              'user_post_tanggal'=>date('Y-m-d'),
							                              'user_post_jam'=>date('H:i:s'),
																						'level'=>'4',
																						'user_stat'=>'Publish',
																						'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'));

																						if($this->Crud_m->insert('user',$data))
																						{
																								if($this->sendemail($email, $saltid,$username)){
										                			            $this->session->set_flashdata('msg','<div class="alert bg-5 text-center">Segera lakukan aktivasi akun mantenbaru dari email anda. Harap merefresh pesan masuk di email Anda.</div>');
										                			            redirect(base_url('daftar'));
										                 						}else{
										                      					$this->session->set_flashdata('msg','<div class="alert bg-5 text-center">Coba lagi ...</div>');
										                          			    redirect(base_url('daftar'));
										                  				    }
																						}
														$data['title'] = 'Sukses mendaftar';
														$this->load->view('backend/register',$data);
											}
									}else{
													$data['title'] = 'Silahkan lengkapi kembali';
				                	$this->load->view('backend/register', $data);
				            		}
								}else{
									$data['title'] = 'Ops.. Masih ada yang kurang. Silahkan dicek kembali.';
									$this->load->view('backend/register',$data);
								}
	}
	function sendemail($email,$saltid,$username)
	{
		  // configure the email setting
					$config['protocol'] = 'smtp';
					$config['smtp_host'] = 'ssl://mail.crudbiz.com'; //smtp host name
					$config['smtp_port'] = '465'; //smtp port number
					$config['smtp_user'] = 'noreply@crudbiz.com';
					$config['smtp_pass'] = 'dh4wy3p1c'; //$from_email password
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					$config['newline'] = "\r\n"; //use double quotes
					$this->email->initialize($config);
					$url = base_url()."aspanel/confirmation/".$saltid;
					$this->email->from('noreply@crudbiz.com', 'Aktivasi Akun');
					$this->email->to($email);
					$this->email->subject('Aktivasi Akun Yuk - Crudbiz');
					$message = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'></head><body><p><strong>Hallo, $username</strong></p><p>Hanya tinggal 1 langkah lagi untuk bisa bergabung dengan Crudbiz.</p><p>Silahkan mengklik link di bawah ini</p>".$url."<br/><p>Salam Hangat</p><p>Crudbiz Team</p></body></html>";
					$this->email->message($message);
					return $this->email->send();
		}
	public function confirmation($key)
	{
					if($this->crud_m->verifyemail($key))
					{
						$this->session->set_flashdata('msg','<div class="alert bg-3 text-center">Selamat Anda telah Resmi Bergabung! Silahkan Login.</div>');
						redirect(base_url('login'));
					}	else {
						$this->session->set_flashdata('msg','<div class="alert bg-3 text-center">Ops. Anda gagal, silahkan coba lagi.</div>');
						redirect(base_url('login'));
					}
	}

	public function check_username_exists($username)
	{
					 $this->form_validation->set_message('check_username_exists', 'Username Sudah diambil. Silahkan gunakan username lain');
					 if($this->As_m->check_username_exists($username)){
							 return true;
					 } else {
							 return false;
					 }
	}
	public function check_email_exists($email)
	{
            $this->form_validation->set_message('check_email_exists', 'Email Sudah diambil. Silahkan gunakan email lain');
            if($this->As_m->check_email_exists($email)){
                return true;
            } else {
                return false;
            }
  }
	public function logout()
	{
		$id = array('id_session' => $this->session->id_session);
						$data = array('user_login_status'=>'offline');
						$this->db->update('user', $data, $id);
            // Unset user data
            $this->session->unset_userdata('logged_in');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('username');

            // Set message
            $this->session->set_flashdata('user_logout', 'You are now logged out');
						$this->session->sess_destroy();
            redirect(base_url());
    }
	public function profil()
	{
		cek_session_akses($this->session->id_session);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'assets/frontend/user/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/user/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '90%';
			$config['width']= 200;
			$config['height']= 200;
			$config['new_image']= './assets/frontend/user/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

				if ($hasil22['file_name']=='' AND $this->input->post('password')=='' ){
									          $data = array(
																'email'=>$this->db->escape_str($this->input->post('email')),
																'nama'=>$this->input->post('nama'),
																'user_update_hari'=>hari_ini(date('w')),
																'user_update_tanggal'=>date('Y-m-d'),
																'user_update_jam'=>date('H:i:s'));
																$where = array('id_user' => $this->input->post('id_user'));
						    								$this->db->update('user',$data,$where);
															}else if ($this->input->post('password')=='' ){
																$data = array(
																'user_gambar'=>$hasil22['file_name'],
																'email'=>$this->db->escape_str($this->input->post('email')),
																'nama'=>$this->input->post('nama'),
																'user_update_hari'=>hari_ini(date('w')),
																'user_update_tanggal'=>date('Y-m-d'),
																'user_update_jam'=>date('H:i:s'));
																$where = array('id_user' => $this->input->post('id_user'));
																$_image = $this->db->get_where('user',$where)->row();
																$query = $this->db->update('user',$data,$where);
																if($query){
																	unlink("assets/frontend/user/".$_image->user_gambar);
																}
															}else if ($hasil22['file_name']==''){
																$data = array(
																'email'=>$this->db->escape_str($this->input->post('email')),
																'nama'=>$this->input->post('nama'),
																'password'=>sha1($this->input->post('password')),
																'user_update_hari'=>hari_ini(date('w')),
																'user_update_tanggal'=>date('Y-m-d'),
																'user_update_jam'=>date('H:i:s'));
																$where = array('id_user' => $this->input->post('id_user'));
						    								$this->db->update('user',$data,$where);
															}else{
															$data = array(
																'user_gambar'=>$hasil22['file_name'],
																'email'=>$this->db->escape_str($this->input->post('email')),
																'nama'=>$this->input->post('nama'),
																'password'=>sha1($this->input->post('password')),
																'user_update_hari'=>hari_ini(date('w')),
																'user_update_tanggal'=>date('Y-m-d'),
																'user_update_jam'=>date('H:i:s'));
																$where = array('id_user' => $this->input->post('id_user'));
																$_image = $this->db->get_where('user',$where)->row();
																$query = $this->db->update('user',$data,$where);
																if($query){
																	unlink("assets/frontend/user/".$_image->user_gambar);
																}
															}
			redirect('aspanel/profil');
		}else{
		$proses = $this->As_m->edit('user', array('username' => $this->session->username))->row_array();
		$data = array('record' => $proses);
				$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
	    $data['jamkerja_stat']   = '';
	    $data['absen_stat']   = '';
	    $data['dataabsen_stat']   = '';
	    $data['cuti_stat']   = '';
	    $data['gaji_stat']   = '';
	    $data['pengumuman_stat']   = '';
	    $data['konfig_stat']   = 'active';
			$data['produk_menu_open']   = '';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = '';

			$data['post'] = $this->As_m->view_ordering('user_detail','id_user','ASC');
			if ($this->session->level=='1'){
					$data['recordall'] = $this->Crud_m->view_where_ordering('user',array('user_status'=>'1'),'id_user','DESC');
			}else{
			}
			$this->load->view('backend/profil/profilall', $data);
			}
		}
	public function user_update()
	{
				cek_session_akses($this->session->id_session);
				$id = $this->uri->segment(3);
				if (isset($_POST['submit'])){
					$config['upload_path'] = 'assets/frontend/user/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/user/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '90%';
					$config['width']= 200;
					$config['height']= 200;
					$config['new_image']= './assets/frontend/user/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($hasil22['file_name']=='' AND $this->input->post('password')=='' ){
										          $data = array(
																	'email'=>$this->db->escape_str($this->input->post('email')),
																	'nama'=>$this->input->post('nama'),
																	'level'=>$this->input->post('level'),
																	'user_status'=>$this->input->post('user_status'),
																	'user_update_hari'=>hari_ini(date('w')),
																	'user_update_tanggal'=>date('Y-m-d'),
																	'user_update_jam'=>date('H:i:s'));
																	$where = array('id_session' => $this->input->post('id_session'));
							    								$this->db->update('user',$data,$where);
																}else if ($this->input->post('password')=='' ){
																	$data = array(
																	'user_gambar'=>$hasil22['file_name'],
																	'email'=>$this->db->escape_str($this->input->post('email')),
																	'nama'=>$this->input->post('nama'),
																	'level'=>$this->input->post('level'),
																	'user_status'=>$this->input->post('user_status'),
																	'user_update_hari'=>hari_ini(date('w')),
																	'user_update_tanggal'=>date('Y-m-d'),
																	'user_update_jam'=>date('H:i:s'));
																	$where = array('id_session' => $this->input->post('id_session'));
																	$_image = $this->db->get_where('user',$where)->row();
																	$query = $this->db->update('user',$data,$where);
																	if($query){
																		unlink("assets/frontend/user/".$_image->user_gambar);
																	}
																}else if ($hasil22['file_name']==''){
																	$data = array(
																	'email'=>$this->db->escape_str($this->input->post('email')),
																	'nama'=>$this->input->post('nama'),
																	'password'=>sha1($this->input->post('password')),
																	'level'=>$this->input->post('level'),
																	'user_status'=>$this->input->post('user_status'),
																	'user_update_hari'=>hari_ini(date('w')),
																	'user_update_tanggal'=>date('Y-m-d'),
																	'user_update_jam'=>date('H:i:s'));
																	$where = array('id_session' => $this->input->post('id_session'));
							    								$this->db->update('user',$data,$where);
																}else{
																$data = array(
																	'user_gambar'=>$hasil22['file_name'],
																	'email'=>$this->db->escape_str($this->input->post('email')),
																	'nama'=>$this->input->post('nama'),
																	'password'=>sha1($this->input->post('password')),
																	'level'=>$this->input->post('level'),
																	'user_status'=>$this->input->post('user_status'),
																	'user_update_hari'=>hari_ini(date('w')),
																	'user_update_tanggal'=>date('Y-m-d'),
																	'user_update_jam'=>date('H:i:s'));
																	$where = array('id_session' => $this->input->post('id_session'));
																	$_image = $this->db->get_where('user',$where)->row();
																	$query = $this->db->update('user',$data,$where);
																	if($query){
																		unlink("assets/frontend/user/".$_image->user_gambar);
																	}
																}

					redirect('aspanel/profil');
				}else{
				if ($this->session->level=='1'){
							 $proses = $this->As_m->edit('user', array('id_session' => $id))->row_array();
					}else{
							$proses = $this->As_m->edit('user', array('id_session' => $id))->row_array();
					}
					$data = array('rows' => $proses);
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = 'active';
					$data['sliders_stat']   = '';
					$data['templates_stat']   = '';
					$data['cat_templates_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
					$data['post'] = $this->As_m->view_ordering('user_detail','id_user','ASC');
					if ($this->session->level=='1'){
							$data['recordall'] = $this->Crud_m->view_where_ordering('user',array('user_status'=>'active'),'id_user','DESC');
					}else{
					}
					$data['records'] = $this->Crud_m->view_ordering('user_level','user_level_id','DESC');
					$data['record_status'] = $this->Crud_m->view_ordering('user_status','user_status_id','DESC');
					$this->load->view('backend/profil/profiledit', $data);
					}
			}
	public function user_storage_bin()
	{
				cek_session_akses ($this->session->id_session);
				$data['karyawan_menu_open']   = '';
				$data['home_stat']   = '';
				$data['identitas_stat']   = '';
				$data['profil_stat']   = 'active';
				$data['sliders_stat']   = '';
				$data['templates_stat']   = '';
				$data['cat_templates_stat']   = '';
				$data['slider_stat']   = '';
				$data['blogs_stat']   = '';
				$data['message_stat']   = '';
				$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

						if ($this->session->level=='1'){
								$data['recordall'] = $this->Crud_m->view_where_ordering('user',array('user_status'=>'2'),'id_user','DESC');
						}else{
								$data['recordall'] = $this->Crud_m->view_where_ordering('user',array('user_status'=>'2'),'id_user','DESC');
						}
						$this->load->view('backend/profil/profilblock', $data);
			}
	public function user_delete()
	{
					cek_session_akses ('profil',$this->session->id_session);
					$id = $this->uri->segment(3);
					$_id = $this->db->get_where('user',['id_session' => $id])->row();
					 $query = $this->db->delete('user',['id_session'=>$id]);
				 	if($query){
									 unlink("./bahan/foto_profil/".$_id->user_gambar);
				 }
				redirect('aspanel/user_storage_bin');
			}

	function identitaswebsite()
	{

		if (isset($_POST['submit'])){
					$config['upload_path'] = 'assets/frontend/campur/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('logo');
					$hasillogo=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/campur/'.$hasillogo['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '100%';
					$config['new_image']= './assets/frontend/campur/'.$hasillogo['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					$this->upload->initialize($config);
					$this->upload->do_upload('favicon');
					$hasilfav=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/campur/'.$hasilfav['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '50%';
					$config['width']= 30;
					$config['height']= 30;
					$config['new_image']= './assets/frontend/campur/'.$hasilfav['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('meta_keyword')!=''){
								$tag_seo = $this->input->post('meta_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('meta_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
          if ($hasilfav['file_name']=='' && $hasillogo['file_name']==''){
            	$data = array(
            	                	'nama_website'=>$this->db->escape_str($this->input->post('nama_website')),
                                'email'=>$this->db->escape_str($this->input->post('email')),
                                'url'=>$this->db->escape_str($this->input->post('url')),
                                'facebook'=>$this->input->post('facebook'),
                                'instagram'=>$this->input->post('instagram'),
                                'youtube'=>$this->input->post('youtube'),
                                'no_telp'=>$this->db->escape_str($this->input->post('no_telp')),
                                'slogan'=>$this->input->post('slogan'),
                                'alamat'=>$this->input->post('alamat'),
																'whatsapp'=>$this->input->post('whatsapp'),
                                'meta_deskripsi'=>$this->input->post('meta_deskripsi'),
																'seo'=>$this->input->post('seo'),
																'analytics'=>$this->input->post('analytics'),
																'pixel'=>$this->input->post('pixel'),
                                'meta_keyword'=>$tag,
                                'maps'=>$this->input->post('maps'),
															);
																$where = array('id_identitas' => $this->input->post('id_identitas'));
    														$query = $this->db->update('identitas',$data,$where);
            }else if ($hasillogo['file_name']==''){
            	$data = array(
																'nama_website'=>$this->db->escape_str($this->input->post('nama_website')),
																'email'=>$this->db->escape_str($this->input->post('email')),
																'url'=>$this->db->escape_str($this->input->post('url')),
																'facebook'=>$this->input->post('facebook'),
																'instagram'=>$this->input->post('instagram'),
																'youtube'=>$this->input->post('youtube'),
																'no_telp'=>$this->db->escape_str($this->input->post('no_telp')),
																'slogan'=>$this->input->post('slogan'),
																'alamat'=>$this->input->post('alamat'),
																'whatsapp'=>$this->input->post('whatsapp'),
																'meta_deskripsi'=>$this->input->post('meta_deskripsi'),
																'seo'=>$this->input->post('seo'),
																'analytics'=>$this->input->post('analytics'),
																'pixel'=>$this->input->post('pixel'),
																'meta_keyword'=>$tag,
																'maps'=>$this->input->post('maps'),
                                'favicon'=>$hasilfav['file_name']);
																$where = array('id_identitas' => $this->input->post('id_identitas'));
						    								$_image = $this->db->get_where('identitas',$where)->row();
						    								$query = $this->db->update('identitas',$data,$where);
						    								if($query){
						    					                unlink("assets/frontend/campur/".$_image->favicon);
						    					                }
            }else if ($hasilfav['file_name']==''){
            	$data = array(
																'nama_website'=>$this->db->escape_str($this->input->post('nama_website')),
																'email'=>$this->db->escape_str($this->input->post('email')),
																'url'=>$this->db->escape_str($this->input->post('url')),
																'facebook'=>$this->input->post('facebook'),
																'instagram'=>$this->input->post('instagram'),
																'youtube'=>$this->input->post('youtube'),
																'no_telp'=>$this->db->escape_str($this->input->post('no_telp')),
																'slogan'=>$this->input->post('slogan'),
																'alamat'=>$this->input->post('alamat'),
																'whatsapp'=>$this->input->post('whatsapp'),
																'meta_deskripsi'=>$this->input->post('meta_deskripsi'),
																'seo'=>$this->input->post('seo'),
																'analytics'=>$this->input->post('analytics'),
																'pixel'=>$this->input->post('pixel'),
																'meta_keyword'=>$tag,
																'maps'=>$this->input->post('maps'),
                                'logo'=>$hasillogo['file_name']);
																$where = array('id_identitas' => $this->input->post('id_identitas'));
						    								$_image = $this->db->get_where('identitas',$where)->row();
						    								$query = $this->db->update('identitas',$data,$where);
						    								if($query){
						    					                unlink("assets/frontend/campur/".$_image->logo);
						    					                }
            }else{
            	$data = array(
																'nama_website'=>$this->db->escape_str($this->input->post('nama_website')),
																'email'=>$this->db->escape_str($this->input->post('email')),
																'url'=>$this->db->escape_str($this->input->post('url')),
																'facebook'=>$this->input->post('facebook'),
																'instagram'=>$this->input->post('instagram'),
																'youtube'=>$this->input->post('youtube'),
																'no_telp'=>$this->db->escape_str($this->input->post('no_telp')),
																'slogan'=>$this->input->post('slogan'),
																'alamat'=>$this->input->post('alamat'),
																'whatsapp'=>$this->input->post('whatsapp'),
																'meta_deskripsi'=>$this->input->post('meta_deskripsi'),
																'seo'=>$this->input->post('seo'),
																'analytics'=>$this->input->post('analytics'),
																'pixel'=>$this->input->post('pixel'),
																'meta_keyword'=>$tag,
																'maps'=>$this->input->post('maps'),
																'favicon'=>$hasilfav['file_name'],
                                'logo'=>$hasillogo['file_name']);
																$where = array('id_identitas' => $this->input->post('id_identitas'));
						    								$_image = $this->db->get_where('identitas',$where)->row();
						    								$query = $this->db->update('identitas',$data,$where);
						    								if($query){
						    					                unlink("assets/frontend/campur/".$_image->favicon);
																					unlink("assets/frontend/campur/".$_image->logo);
						    					                }
            }
			redirect('aspanel/identitaswebsite');
		}else{

			$proses = $this->As_m->edit('identitas', array('id_identitas' => 1))->row_array();
			$data = array('record' => $proses);
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			if ($this->session->level=='1'){
				cek_session_akses('identitaswebsite',$this->session->id_session);
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('identitaswebsite',$this->session->id_session);
				}else{
					redirect('aspanel/home');
				}
			$this->load->view('backend/identitas/views', $data);
		}
	}

    /* Data konsumen */

  public function konsumen()
  {
    	    if ($this->session->level=='1'){

    						$data['record'] = $this->Crud_m->view_join_where2_ordering('konsumen','perumahan','konsumen_perumahan_kode','perumahan_kode',array('konsumen_status'=>'publish'),'konsumen_tgl_order','ASC');
    				}else if  ($this->session->level=='2'){
    						$data['record'] = $this->Crud_m->view_join_where_ordering_konsumen_leader('konsumen','perumahan','user','konsumen_perumahan_kode','perumahan_kode','id_user','perumahan_pl',array('konsumen_status'=>'publish'),'konsumen_tgl_order','ASC');
    				}else{
    						$data['record'] = $this->Crud_m->view_join_where2_ordering('konsumen','perumahan','konsumen_perumahan_kode','perumahan_kode',array('konsumen_cs_fu'=>$this->session->username,'konsumen_status'=>'publish'),'konsumen_tgl_order','ASC');
    				}
							cek_session_akses('konsumen',$this->session->id_session);
    			    $this->load->view('backend/konsumen/v_daftar', $data);
    	}
  public function exportxlskonsumen()
  {
      $data = $this->Crud_m->view_ordering('konsumen','konsumen_tgl_order','ASC');

      include_once APPPATH.'/third_party/xlsxwriter.class.php';
      ini_set('display_errors', 0);
      ini_set('log_errors', 1);
      error_reporting(E_ALL & ~E_NOTICE);


      $filename = "report-".date('d-m-Y-H-i-s').".xlsx";
      header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
      header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
      header('Content-Transfer-Encoding: binary');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');

      $styles = array('widths'=>[3,20,30,40], 'font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#eee', 'halign'=>'center', 'border'=>'left,right,top,bottom');
      $styles2 = array( ['font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#eee', 'halign'=>'left', 'border'=>'left,right,top,bottom','fill'=>'#ffc'],['fill'=>'#fcf'],['fill'=>'#ccf'],['fill'=>'#cff'],);

      $header = array(
        'No'=>'integer',
        'Nama Sales'=>'string',
        'Nama Konsumen'=>'string',
        'Tanggal Dealing'=>'string',
        'Minggu'=>'string',
        'Perumahan'=>'string',
        'Media Promosi' =>'string',
        'Nomor Telepon' =>'string',
        'Pembayaran'=>'string',
        'Tanggal FU'=>'string',
        'Status'=>'string',
        'Status Proses'=>'string',
        'Status Prospek'=>'string',
        'Status Update'=>'string',
        'Detail Kondisi'=>'string',
        'Solusi'=>'string',
        'Gaji Istri'=>'string',
        'Gaji Suami'=>'string',
        'Cicilan'=>'string',
        'Kantor Suami'=>'string',
        'Kantor Istri'=>'string',
        'Domisili'=>'string',
      );

      $writer = new XLSXWriter();
      $writer->setAuthor('Admin');

      $writer->writeSheetHeader('Sheet1', $header, $styles);
      $no = 1;
      foreach($data as $row){
        $writer->writeSheetRow('Sheet1', [$no, $row['konsumen_cs_fu'], $row['konsumen_nama'], $row['konsumen_tgl_order'], $row['konsumen_minggu'], $row['konsumen_perumahan_kode'], $row['konsumen_media_nama'], $row['konsumen_telp'], $row['konsumen_pembayaran'], $row['konsumen_tgl_fu'], $row['konsumen_stat'], $row['konsumen_statpros'], $row['konsumen_statprospek'], $row['konsumen_statupdate'], $row['konsumen_kondisi'], $row['konsumen_solusi'], $row['konsumen_gi'], $row['konsumen_gs'], $row['konsumen_cicilan'], $row['konsumen_ks'], $row['konsumen_ki'], $row['konsumen_domisili']], $styles2);
        $no++;
      }
      $writer->writeToStdOut();
    }
	public function konsumen_storage_bin()
	{


				if ($this->session->level=='1'){
				        $data['record'] = $this->Crud_m->view_join_where2_ordering('konsumen','perumahan','konsumen_perumahan_kode','perumahan_kode',array('konsumen_status'=>'delete'),'konsumen_tgl_order','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_join_where2_ordering('konsumen','perumahan','konsumen_perumahan_kode','perumahan_kode',array('konsumen_cs_fu'=>$this->session->username,'konsumen_status'=>'delete'),'konsumen_tgl_order','DESC');
				}
				cek_session_akses('konsumen',$this->session->id_session);
				$this->load->view('backend/konsumen/v_daftar_hapus', $data);
	}
	public function konsumen_tambahkan()
	{


             if (isset($_POST['submit'])){
							$data = array(
							                'konsumen_kode'=>$this->input->post('konsumen_kode'),
											'konsumen_nama'=>$this->input->post('konsumen_nama'),
											'konsumen_tgl_order'=>$this->input->post('konsumen_tgl_order'),
											'konsumen_minggu'=>$this->input->post('konsumen_minggu'),
											'konsumen_perumahan_kode'=>$this->input->post('konsumen_perumahan_kode'),
											'konsumen_media_nama'=>$this->input->post('konsumen_media_nama'),
											'konsumen_telp'=>$this->input->post('konsumen_telp'),
											'konsumen_pembayaran'=>$this->input->post('konsumen_pembayaran'),
											'konsumen_cs_fu'=>$this->input->post('konsumen_cs_fu'),
											'konsumen_tgl_fu'=>$this->input->post('konsumen_tgl_fu'),
											'konsumen_stat'=>$this->input->post('konsumen_stat'),
											'konsumen_statprospek'=>$this->input->post('konsumen_statprospek'),
											'konsumen_statpros'=>$this->input->post('konsumen_statpros'),
											'konsumen_statupdate'=>$this->input->post('konsumen_statupdate'),
											'konsumen_kondisi'=>$this->input->post('konsumen_kondisi'),
											'konsumen_solusi'=>$this->input->post('konsumen_solusi'),
											'konsumen_gi'=>$this->input->post('konsumen_gi'),
											'konsumen_gs'=>$this->input->post('konsumen_gs'),
											'konsumen_cicilan'=>$this->input->post('konsumen_cicilan'),
											'konsumen_ki'=>$this->input->post('konsumen_ki'),
											'konsumen_ks'=>$this->input->post('konsumen_ks'),
											'konsumen_domisili'=>$this->input->post('konsumen_domisili'),

											'konsumen_post_oleh'=>$this->session->username,
											'konsumen_hari'=>hari_ini(date('w')),
											'konsumen_tanggal'=>date('Y-m-d'),
											'konsumen_jam'=>date('H:i:s'),
											'konsumen_status'=>'publish');

								$this->As_m->insert('konsumen',$data);
								redirect('aspanel/konsumen');
				}else{

		            $data['record_cs'] = $this->Crud_m->view_ordering('user','id_user','DESC');
		            $data['record_stat'] = $this->Crud_m->view_ordering('konsumen_status','konsumen_status_id','ASC');
		            $data['record_statupdate'] = $this->Crud_m->view_ordering('konsumen_statupdate','konsumen_statupdate_id','ASC');
		            $data['record_statpros'] = $this->Crud_m->view_ordering('konsumen_statpros','konsumen_statpros_id','ASC');
		            $data['record_statprospek'] = $this->Crud_m->view_ordering('konsumen_statprospek','konsumen_statprospek_id','DESC');
		            $data['record_minggu'] = $this->Crud_m->view_ordering('konsumen_minggu','konsumen_minggu_id','ASC');
		            $data['record_kategori'] = $this->Crud_m->view_ordering('paketharga','paketharga_id','ASC');
		            $data['record_medpro'] = $this->Crud_m->view_ordering('media_promosi','media_promosi_id','ASC');
		            $data['record_bayar'] = $this->Crud_m->view_ordering('konsumen_pembayaran','konsumen_pembayaran_id','ASC');
					cek_session_akses('konsumen',$this->session->id_session);
					$this->load->view('backend/konsumen/v_tambahkan', $data);

				}
	}
	public function konsumen_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
						$data = array(
						          'konsumen_kode'=>$this->input->post('konsumen_kode'),
											'konsumen_nama'=>$this->input->post('konsumen_nama'),
											'konsumen_tgl_order'=>$this->input->post('konsumen_tgl_order'),
											'konsumen_minggu'=>$this->input->post('konsumen_minggu'),
											'konsumen_perumahan_kode'=>$this->input->post('konsumen_perumahan_kode'),
											'konsumen_media_nama'=>$this->input->post('konsumen_media_nama'),
											'konsumen_telp'=>$this->input->post('konsumen_telp'),
											'konsumen_pembayaran'=>$this->input->post('konsumen_pembayaran'),
											'konsumen_cs_fu'=>$this->input->post('konsumen_cs_fu'),
											'konsumen_tgl_fu'=>$this->input->post('konsumen_tgl_fu'),
											'konsumen_stat'=>$this->input->post('konsumen_stat'),
											'konsumen_statprospek'=>$this->input->post('konsumen_statprospek'),
											'konsumen_statpros'=>$this->input->post('konsumen_statpros'),
											'konsumen_statupdate'=>$this->input->post('konsumen_statupdate'),
											'konsumen_kondisi'=>$this->input->post('konsumen_kondisi'),
											'konsumen_solusi'=>$this->input->post('konsumen_solusi'),
											'konsumen_gi'=>$this->input->post('konsumen_gi'),
											'konsumen_gs'=>$this->input->post('konsumen_gs'),
											'konsumen_cicilan'=>$this->input->post('konsumen_cicilan'),
											'konsumen_ki'=>$this->input->post('konsumen_ki'),
											'konsumen_ks'=>$this->input->post('konsumen_ks'),
											'konsumen_domisili'=>$this->input->post('konsumen_domisili'));
											$where = array('konsumen_id' => $this->input->post('konsumen_id'));
											$this->db->update('konsumen', $data, $where);

						redirect('aspanel/konsumen');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('konsumen', array('konsumen_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('konsumen', array('konsumen_id' => $id))->row_array();
			}
			 $data = array('rows' => $proses);
			 $data['record_cs'] = $this->Crud_m->view_ordering('user','id_user','DESC');
		     $data['record_stat'] = $this->Crud_m->view_ordering('konsumen_status','konsumen_status_id','ASC');
		     $data['record_statupdate'] = $this->Crud_m->view_ordering('konsumen_statupdate','konsumen_statupdate_id','ASC');
		     $data['record_statpros'] = $this->Crud_m->view_ordering('konsumen_statpros','konsumen_statpros_id','ASC');
		     $data['record_statprospek'] = $this->Crud_m->view_ordering('konsumen_statprospek','konsumen_statprospek_id','DESC');
		     $data['record_minggu'] = $this->Crud_m->view_ordering('konsumen_minggu','konsumen_minggu_id','ASC');
		     $data['record_kodeper'] = $this->Crud_m->view_ordering('perumahan','perumahan_id','ASC');
		     $data['record_medpro'] = $this->Crud_m->view_ordering('media_promosi','media_promosi_id','ASC');
		     $data['record_bayar'] = $this->Crud_m->view_ordering('konsumen_pembayaran','konsumen_pembayaran_id','ASC');
			cek_session_akses('konsumen',$this->session->id_session);
			$this->load->view('backend/konsumen/v_update', $data);
		}
	}
	public function konsumen_detail()
	{

		$id = $this->uri->segment(3);

			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('konsumen', array('konsumen_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('konsumen', array('konsumen_id' => $id))->row_array();
			}
				$data = array('rows' => $proses);

        $data['record_cs'] = $this->Crud_m->view_ordering('user','id_user','DESC');
	    $data['record'] = $this->Crud_m->view_ordering('perumahan','perumahan_id','DESC');
		cek_session_akses('konsumen',$this->session->id_session);
		$this->load->view('backend/konsumen/v_detail', $data);

	}
	function konsumen_delete_temp()
	{
			cek_session_akses('konsumen',$this->session->id_session);
			$data = array('konsumen_status'=>'delete');
			$where = array('konsumen_id' => $this->uri->segment(3));
			$this->db->update('konsumen', $data, $where);
			redirect('aspanel/konsumen');
	}
	function konsumen_restore()
	{
		cek_session_akses('konsumen',$this->session->id_session);
			$data = array('konsumen_status'=>'Publish');
			$where = array('konsumen_id' => $this->uri->segment(3));
			$this->db->update('konsumen', $data, $where);
			redirect('aspanel/konsumen');
	}
	public function konsumen_delete()
	{
			cek_session_akses('konsumen',$this->session->id_session);
			$id = $this->uri->segment(3);
			$query = $this->db->delete('konsumen',['konsumen_id'=>$id]);

		redirect('aspanel/konsumen_storage_bin');
	}
	/* konsumen - tutup */


	/*	Bagian untuk slider - Pembuka	*/
	public function slider()
	{
		$data['home_stat']   = '';
		if ($this->session->level=='1'){
			cek_session_akses('slider',$this->session->id_session);
			$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_status'=>'publish'),'slider_id','DESC');
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('slider',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_status'=>'publish'),'slider_id','DESC');
			}else{
				cek_session_akses_staff('slider',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_post_oleh'=>$this->session->username,'slider_status'=>'publish'),'slider_id','DESC');

			}
			$this->load->view('backend/slider/v_daftar', $data);
	}
	public function slider_storage_bin()
	{
		if ($this->session->level=='1'){
			cek_session_akses('slider',$this->session->id_session);
			$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_status'=>'delete'),'slider_id','DESC');
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('slider',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_status'=>'delete'),'slider_id','DESC');
			}else{
				cek_session_akses_staff('slider',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('slider',array('slider_post_oleh'=>$this->session->username,'slider_status'=>'delete'),'slider_id','DESC');

			}
				$this->load->view('backend/slider/v_daftar_hapus', $data);
	}
	public function slider_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'assets/frontend/slider/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/slider/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['new_image']= './assets/frontend/slider/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('slider_keyword')!=''){
								$tag_seo = $this->input->post('slider_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('slider_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
										'slider_post_oleh'=>$this->session->username,
										'slider_judul'=>$this->db->escape_str($this->input->post('slider_judul')),
										'slider_judul_seo'=>$this->mylibrary->seo_title($this->input->post('slider_judul')),

										'slider_post_hari'=>hari_ini(date('w')),
										'slider_post_tanggal'=>date('Y-m-d'),
										'slider_post_jam'=>date('H:i:s'),
										'slider_dibaca'=>'0',
										'slider_status'=>'publish');
											}else{
												$data = array(
													'slider_post_oleh'=>$this->session->username,
													'slider_judul'=>$this->db->escape_str($this->input->post('slider_judul')),
													'slider_judul_seo'=>$this->mylibrary->seo_title($this->input->post('slider_judul')),

													'slider_post_hari'=>hari_ini(date('w')),
													'slider_post_tanggal'=>date('Y-m-d'),
													'slider_post_jam'=>date('H:i:s'),
													'slider_dibaca'=>'0',
													'slider_status'=>'publish',
													'slider_gambar'=>$hasil22['file_name']);
												}
								$this->As_m->insert('slider',$data);
								redirect('aspanel/slider');
				}else{
					if ($this->session->level=='1'){
							cek_session_akses('slider',$this->session->id_session);
							$data['home_stat']   = '';
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}elseif ($this->session->level=='2'){
							cek_session_akses_admin('slider',$this->session->id_session);
							$data['home_stat']   = '';
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}else{
							cek_session_akses_staff('slider',$this->session->id_session);
							$data['home_stat']   = '';
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}
					$this->load->view('backend/slider/v_tambahkan', $data);
				}
	}
	public function slider_update()
	{
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'assets/frontend/slider/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/slider/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['new_image']= './assets/frontend/slider/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('slider_keyword')!=''){
						$tag_seo = $this->input->post('slider_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('slider_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'slider_post_oleh'=>$this->session->username,
											'slider_judul'=>$this->db->escape_str($this->input->post('slider_judul')),
											'slider_judul_seo'=>$this->mylibrary->seo_title($this->input->post('slider_judul')),

											'slider_post_hari'=>hari_ini(date('w')),
											'slider_post_tanggal'=>date('Y-m-d'),
											'slider_post_jam'=>date('H:i:s'));
											$where = array('slider_id' => $this->input->post('slider_id'));
											$this->db->update('slider', $data, $where);
						}else{
										$data = array(
											'slider_post_oleh'=>$this->session->username,
											'slider_judul'=>$this->db->escape_str($this->input->post('slider_judul')),
											'slider_judul_seo'=>$this->mylibrary->seo_title($this->input->post('slider_judul')),

											'slider_post_hari'=>hari_ini(date('w')),
											'slider_post_tanggal'=>date('Y-m-d'),
											'slider_post_jam'=>date('H:i:s'),
											'slider_gambar'=>$hasil22['file_name']);
											$where = array('slider_id' => $this->input->post('slider_id'));
											$_image = $this->db->get_where('slider',$where)->row();
											$query = $this->db->update('slider',$data,$where);
											if($query){
												unlink("assets/frontend/slider/".$_image->sliders_gambar);
											}

						}
						redirect('aspanel/slider');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('slider', array('slider_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('slider', array('slider_id' => $id, 'slider_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			if ($this->session->level=='1'){
					cek_session_akses('slider',$this->session->id_session);
					$data['home_stat']   = '';
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('slider',$this->session->id_session);
					$data['home_stat']   = '';
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}else{
					cek_session_akses_staff('slider',$this->session->id_session);
					$data['home_stat']   = '';
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}
			$this->load->view('backend/slider/v_update', $data);
		}
	}
	function slider_delete_temp()
	{
		if ($this->session->level=='1'){
				cek_session_akses('slider',$this->session->id_session);
				$data = array('slider_status'=>'delete');
				$where = array('slider_id' => $this->uri->segment(3));
				$this->db->update('slider', $data, $where);
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('slider',$this->session->id_session);
				$data = array('slider_status'=>'delete');
				$where = array('slider_id' => $this->uri->segment(3));
				$this->db->update('slider', $data, $where);
			}else{
				cek_session_akses_staff('slider',$this->session->id_session);
				$data = array('slider_status'=>'delete');
				$where = array('slider_id' => $this->uri->segment(3));
				$this->db->update('slider', $data, $where);
			}
			redirect('aspanel/slider');
	}
	function slider_restore()
	{
		if ($this->session->level=='1'){
				cek_session_akses('slider',$this->session->id_session);
				$data = array('slider_status'=>'Publish');
				$where = array('slider_id' => $this->uri->segment(3));
				$this->db->update('slider', $data, $where);
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('slider',$this->session->id_session);
				$data = array('slider_status'=>'Publish');
				$where = array('slider_id' => $this->uri->segment(3));
				$this->db->update('slider', $data, $where);
			}else{
				cek_session_akses_staff('slider',$this->session->id_session);
				$data = array('slider_status'=>'Publish');
				$where = array('slider_id' => $this->uri->segment(3));
				$this->db->update('slider', $data, $where);
			}
			redirect('aspanel/slider_storage_bin');
	}
	public function slider_delete()
	{
		if ($this->session->level=='1'){
			 cek_session_akses('slider',$this->session->id_session);
			 $id = $this->uri->segment(3);
			 $_id = $this->db->get_where('slider',['slider_id' => $id])->row();
				$query = $this->db->delete('slider',['slider_id'=>$id]);
			 if($query){
								unlink("./assets/frontend/foto_slider/".$_id->sliders_gambar);
						}
		 }elseif ($this->session->level=='2'){
			 cek_session_akses_admin('slider',$this->session->id_session);
 			$id = $this->uri->segment(3);
 			$_id = $this->db->get_where('slider',['slider_id' => $id])->row();
 			 $query = $this->db->delete('slider',['slider_id'=>$id]);
 			if($query){
 							 unlink("./assets/frontend/foto_slider/".$_id->sliders_gambar);
						}
		 }else{
			 cek_session_akses_staff('slider',$this->session->id_session);
		 }
		redirect('aspanel/slider_storage_bin');
	}
	/*	Bagian untuk slider - Penutup	*/

	/*	Bagian untuk Message - Pembuka	*/
	public function message()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = 'active';
		cek_session_akses ('templates',$this->session->id_session);
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('templates',array('templates_status'=>'publish'),'templates_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('templates',array('templates_post_oleh'=>$this->session->username,'templates_status'=>'publish'),'templates_id','DESC');
				}
				cek_session_akses('message',$this->session->id_session);
				$this->load->view('backend/templates/v_daftar', $data);
	}
	/*	Bagian untuk Message - Penutup	*/

	/*	Bagian untuk klien - Pembuka	*/
	public function paketharga()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['paketharga']   = 'active';
			$data['produk']   = '';
			$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('paketharga',array('paketharga_status'=>'publish'),'paketharga_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('paketharga',array('paketharga_post_oleh'=>$this->session->username,'paketharga_status'=>'publish'),'paketharga_id','DESC');
				}
				cek_session_akses('paketharga',$this->session->id_session);
				$this->load->view('backend/paketharga/v_daftar', $data);
	}
	public function paketharga_storage_bin()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['paketharga']   = 'active';
			$data['produk']   = '';
			$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('paketharga',array('paketharga_status'=>'delete'),'paketharga_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('paketharga',array('paketharga_post_oleh'=>$this->session->username,'paketharga_status'=>'delete'),'paketharga_id','DESC');
				}
				cek_session_akses('paketharga',$this->session->id_session);
				$this->load->view('backend/paketharga/v_daftar_hapus', $data);
	}
	public function paketharga_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'assets/frontend/paketharga/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/paketharga/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '100%';
					$config['width']= 1080;
					$config['height']= 1920;
					$config['new_image']= './assets/frontend/paketharga/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('paketharga_keyword')!=''){
								$tag_seo = $this->input->post('paketharga_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('paketharga_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
													'paketharga_post_oleh'=>$this->session->username,
													'paketharga_judul'=>$this->db->escape_str($this->input->post('paketharga_judul')),
													'paketharga_judul_seo'=>$this->mylibrary->seo_title($this->input->post('paketharga_judul')),
													'paketharga_desk'=>$this->input->post('paketharga_desk'),
													'paketharga_fitur'=>$this->input->post('paketharga_fitur'),
													'paketharga_harga'=>$this->input->post('paketharga_harga'),
													'paketharga_post_hari'=>hari_ini(date('w')),
													'paketharga_post_tanggal'=>date('Y-m-d'),
													'paketharga_post_jam'=>date('H:i:s'),
													'paketharga_dibaca'=>'0',
													'paketharga_status'=>'publish',
													'paketharga_meta_desk'=>$this->input->post('paketharga_meta_desk'),
													'paketharga_keyword'=>$tag);
											}else{
												$data = array(
													'paketharga_post_oleh'=>$this->session->username,
													'paketharga_judul'=>$this->db->escape_str($this->input->post('paketharga_judul')),
													'paketharga_judul_seo'=>$this->mylibrary->seo_title($this->input->post('paketharga_judul')),
													'paketharga_desk'=>$this->input->post('paketharga_desk'),
													'paketharga_fitur'=>$this->input->post('paketharga_fitur'),
													'paketharga_harga'=>$this->input->post('paketharga_harga'),
													'paketharga_post_hari'=>hari_ini(date('w')),
													'paketharga_post_tanggal'=>date('Y-m-d'),
													'paketharga_post_jam'=>date('H:i:s'),
													'paketharga_dibaca'=>'0',
													'paketharga_status'=>'publish',
													'paketharga_gambar'=>$hasil22['file_name'],
													'paketharga_meta_desk'=>$this->input->post('paketharga_meta_desk'),
													'paketharga_keyword'=>$tag);
												}
								$this->As_m->insert('paketharga',$data);
								redirect('aspanel/paketharga');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['templates_stat']   = '';
					$data['cat_templates_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = '';
					$data['kehadiran_menu_open']   = '';
					$data['jamkerja_stat']   = '';
					$data['absen_stat']   = '';
					$data['dataabsen_stat']   = '';
					$data['cuti_stat']   = '';
					$data['gaji_stat']   = '';
					$data['pengumuman_stat']   = '';
					$data['konfig_stat']   = '';
					$data['produk_menu_open']   = 'menu-open';
					$data['paketharga']   = 'active';
					$data['produk']   = '';
					$data['services']   = '';
					cek_session_akses('paketharga',$this->session->id_session);
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/paketharga/v_tambahkan', $data);
				}
	}
	public function paketharga_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'assets/frontend/paketharga/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/paketharga/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '100%';
			$config['width']= 1080;
			$config['height']= 1920;
			$config['new_image']= './assets/frontend/paketharga/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('paketharga_keyword')!=''){
						$tag_seo = $this->input->post('paketharga_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('paketharga_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'paketharga_update_oleh'=>$this->session->username,
											'paketharga_judul'=>$this->db->escape_str($this->input->post('paketharga_judul')),
											'paketharga_judul_seo'=>$this->mylibrary->seo_title($this->input->post('paketharga_judul')),
											'paketharga_desk'=>$this->input->post('paketharga_desk'),
											'paketharga_fitur'=>$this->input->post('paketharga_fitur'),
											'paketharga_harga'=>$this->input->post('paketharga_harga'),
											'paketharga_update_hari'=>hari_ini(date('w')),
											'paketharga_update_tanggal'=>date('Y-m-d'),
											'paketharga_update_jam'=>date('H:i:s'),
											'paketharga_meta_desk'=>$this->input->post('paketharga_meta_desk'),
											'paketharga_keyword'=>$tag);
											$where = array('paketharga_id' => $this->input->post('paketharga_id'));
											$this->db->update('paketharga', $data, $where);
						}else{
										$data = array(
											'paketharga_update_oleh'=>$this->session->username,
											'paketharga_judul'=>$this->db->escape_str($this->input->post('paketharga_judul')),
											'paketharga_judul_seo'=>$this->mylibrary->seo_title($this->input->post('paketharga_judul')),
											'paketharga_desk'=>$this->input->post('paketharga_desk'),
											'paketharga_fitur'=>$this->input->post('paketharga_fitur'),
											'paketharga_harga'=>$this->input->post('paketharga_harga'),
											'paketharga_update_hari'=>hari_ini(date('w')),
											'paketharga_update_tanggal'=>date('Y-m-d'),
											'paketharga_update_jam'=>date('H:i:s'),
											'paketharga_gambar'=>$hasil22['file_name'],
											'paketharga_meta_desk'=>$this->input->post('paketharga_meta_desk'),
											'paketharga_keyword'=>$tag);
											$where = array('paketharga_id' => $this->input->post('paketharga_id'));
											$_image = $this->db->get_where('paketharga',$where)->row();
											$query = $this->db->update('paketharga',$data,$where);
											if($query){
												unlink("assets/frontend/paketharga/".$_image->paketharga_gambar);
											}

						}
						redirect('aspanel/paketharga');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('paketharga', array('paketharga_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('paketharga', array('paketharga_id' => $id, 'paketharga_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['templates_stat']   = '';
			$data['cat_templates_stat']   = 'active';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['kehadiran_menu_open']   = 'menu-open';
				$data['jamkerja_stat']   = '';
				$data['absen_stat']   = '';
				$data['dataabsen_stat']   = 'active';
				$data['cuti_stat']   = '';
				$data['gaji_stat']   = '';
				$data['pengumuman_stat']   = '';
				$data['konfig_stat']   = '';
				$data['produk_menu_open']   = 'menu-open';
				$data['paketharga']   = 'active';
				$data['produk']   = '';
				$data['services']   = '';
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			cek_session_akses('paketharga',$this->session->id_session);
			$this->load->view('backend/paketharga/v_update', $data);
		}
	}
	function paketharga_delete_temp()
	{
			cek_session_akses('paketharga',$this->session->id_session);
			$data = array('paketharga_status'=>'delete');
			$where = array('paketharga_id' => $this->uri->segment(3));
			$this->db->update('paketharga', $data, $where);
			redirect('aspanel/paketharga');
	}
	function paketharga_restore()
	{
			cek_session_akses('paketharga',$this->session->id_session);
			$data = array('paketharga_status'=>'Publish');
			$where = array('paketharga_id' => $this->uri->segment(3));
			$this->db->update('paketharga', $data, $where);
			redirect('aspanel/paketharga_storage_bin');
	}
	public function paketharga_delete()
	{
			cek_session_akses('paketharga',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('paketharga',['paketharga_id' => $id])->row();
			 $query = $this->db->delete('paketharga',['paketharga_id'=>$id]);
			if($query){
							 unlink("./assets/frontend/paketharga/".$_id->paketharga_gambar);
		 }
		redirect('aspanel/paketharga_storage_bin');
	}
	/*	Bagian untuk klien - Penutup	*/


		/*	Bagian untuk promo - Pembuka	*/
		public function promo()
		{
			if ($this->session->level=='1'){
				cek_session_akses('promo',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('promo',array('promo_status'=>'publish'),'promo_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('promo',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('promo',array('promo_status'=>'publish'),'promo_id','DESC');
				}else{
					cek_session_akses_staff('promo',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('promo',array('promo_post_oleh'=>$this->session->username,'promo_status'=>'publish'),'promo_id','DESC');

				}
					$this->load->view('backend/promo/v_daftar', $data);
		}
		public function promo_storage_bin()
		{
			if ($this->session->level=='1'){
				cek_session_akses('promo',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('promo',array('promo_status'=>'delete'),'promo_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('promo',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('promo',array('promo_status'=>'delete'),'promo_id','DESC');
				}else{
					cek_session_akses_staff('promo',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('promo',array('promo_post_oleh'=>$this->session->username,'promo_status'=>'delete'),'promo_id','DESC');
				}
				$this->load->view('backend/promo/v_daftar_hapus', $data);
		}
		public function promo_tambahkan()
		{
			if (isset($_POST['submit'])){

						$config['upload_path'] = 'assets/frontend/promo/';
						$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
						$this->upload->initialize($config);
						$this->upload->do_upload('gambar');
						$hasil22=$this->upload->data();
						$config['image_library']='gd2';
						$config['source_image'] = './assets/frontend/promo/'.$hasil22['file_name'];
						$config['create_thumb']= FALSE;
						$config['maintain_ratio']= FALSE;
						$config['quality']= '95%';
						$config['new_image']= './assets/frontend/promo/'.$hasil22['file_name'];
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						if ($this->input->post('promo_keyword')!=''){
									$tag_seo = $this->input->post('promo_keyword');
									$tag=implode(',',$tag_seo);
							}else{
									$tag = '';
							}
						$tag = $this->input->post('promo_keyword');
						$tags = explode(",", $tag);
						$tags2 = array();
						foreach($tags as $t)
						{
							$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
							$a = $this->db->query($sql)->result_array();
							if(count($a) == 0){
								$data = array('keyword_nama'=>$this->db->escape_str($t),
										'keyword_username'=>$this->session->username,
										'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
										'count'=>'0');
								$this->As_m->insert('keyword',$data);
							}
							$tags2[] = $this->mylibrary->seo_title($t);
						}
						$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
														'promo_post_oleh'=>$this->session->username,
														'templates_id'=>$this->input->post('templates_id'),
														'promo_selesai_tanggal'=>$this->input->post('promo_selesai_tanggal'),
														'promo_selesai_jam'=>$this->input->post('promo_selesai_jam'),
														'promo_judul'=>$this->db->escape_str($this->input->post('promo_judul')),
														'promo_judul_seo'=>$this->mylibrary->seo_title($this->input->post('promo_judul')),
														'promo_harga'=>$this->input->post('promo_harga'),
														'promo_limit'=>$this->input->post('promo_limit'),
														'promo_post_hari'=>hari_ini(date('w')),
														'promo_post_tanggal'=>date('Y-m-d'),
														'promo_post_jam'=>date('H:i:s'),
														'promo_status'=>'publish');
												}else{
													$data = array(
														'promo_post_oleh'=>$this->session->username,
														'templates_id'=>$this->input->post('templates_id'),
														'promo_selesai_tanggal'=>$this->input->post('promo_selesai_tanggal'),
														'promo_selesai_jam'=>$this->input->post('promo_selesai_jam'),
														'promo_judul'=>$this->db->escape_str($this->input->post('promo_judul')),
														'promo_judul_seo'=>$this->mylibrary->seo_title($this->input->post('promo_judul')),
														'promo_harga'=>$this->input->post('promo_harga'),
														'promo_limit'=>$this->input->post('promo_limit'),
														'promo_post_hari'=>hari_ini(date('w')),
														'promo_post_tanggal'=>date('Y-m-d'),
														'promo_post_jam'=>date('H:i:s'),
														'promo_status'=>'publish',
														'promo_gambar'=>$hasil22['file_name']);
													}
									$this->As_m->insert('promo',$data);
									redirect('aspanel/promo');
					}else{
						if ($this->session->level=='1'){
								cek_session_akses('promo',$this->session->id_session);
								$data['home_stat']   = '';
								$data['records'] = $this->Crud_m->view_where_ordering('templates',array('templates_status'=>'Publish'),'templates_id','DESC');
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}elseif ($this->session->level=='2'){
								cek_session_akses_admin('promo',$this->session->id_session);
								$data['home_stat']   = '';
								$data['records'] = $this->Crud_m->view_where_ordering('templates',array('templates_status'=>'Publish'),'templates_id','DESC');
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}else{
								cek_session_akses_staff('promo',$this->session->id_session);
								$data['home_stat']   = '';
								$data['records'] = $this->Crud_m->view_where_ordering('templates',array('templates_status'=>'Publish'),'templates_id','DESC');
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}
						$this->load->view('backend/promo/v_tambahkan', $data);
					}
		}
		public function promo_update()
		{

			$id = $this->uri->segment(3);
			if (isset($_POST['submit'])){

				$config['upload_path'] = 'assets/frontend/promo/';
				$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
				$this->upload->initialize($config);
				$this->upload->do_upload('gambar');
				$hasil22=$this->upload->data();
				$config['image_library']='gd2';
				$config['source_image'] = './assets/frontend/promo/'.$hasil22['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= FALSE;
				$config['quality']= '95%';
				$config['new_image']= './assets/frontend/promo/'.$hasil22['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				if ($this->input->post('promo_keyword')!=''){
							$tag_seo = $this->input->post('promo_keyword');
							$tag=implode(',',$tag_seo);
					}else{
							$tag = '';
					}
				$tag = $this->input->post('promo_keyword');
				$tags = explode(",", $tag);
				$tags2 = array();
				foreach($tags as $t)
				{
					$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
					$a = $this->db->query($sql)->result_array();
					if(count($a) == 0){
						$data = array('keyword_nama'=>$this->db->escape_str($t),
								'keyword_username'=>$this->session->username,
								'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
								'count'=>'0');
						$this->As_m->insert('keyword',$data);
					}
					$tags2[] = $this->mylibrary->seo_title($t);
				}
				$tags = implode(",", $tags2);
							if ($hasil22['file_name']==''){
											$data = array(
												'promo_update_oleh'=>$this->session->username,
												'templates_id'=>$this->input->post('templates_id'),
												'promo_selesai_tanggal'=>$this->input->post('promo_selesai_tanggal'),
												'promo_selesai_jam'=>$this->input->post('promo_selesai_jam'),
												'promo_harga'=>$this->input->post('promo_harga'),
												'promo_limit'=>$this->input->post('promo_limit'),
												'promo_judul'=>$this->db->escape_str($this->input->post('promo_judul')),
												'promo_judul_seo'=>$this->mylibrary->seo_title($this->input->post('promo_judul')),
												'promo_update_hari'=>hari_ini(date('w')),
												'promo_update_tanggal'=>date('Y-m-d'),
												'promo_update_jam'=>date('H:i:s'));
												$where = array('promo_id' => $this->input->post('promo_id'));
												$this->db->update('promo', $data, $where);
							}else{
											$data = array(
												'promo_update_oleh'=>$this->session->username,
												'templates_id'=>$this->input->post('templates_id'),
												'promo_selesai_tanggal'=>$this->input->post('promo_selesai_tanggal'),
												'promo_selesai_jam'=>$this->input->post('promo_selesai_jam'),
												'promo_harga'=>$this->input->post('promo_harga'),
												'promo_limit'=>$this->input->post('promo_limit'),
												'promo_judul'=>$this->db->escape_str($this->input->post('promo_judul')),
												'promo_judul_seo'=>$this->mylibrary->seo_title($this->input->post('promo_judul')),
												'promo_update_hari'=>hari_ini(date('w')),
												'promo_update_tanggal'=>date('Y-m-d'),
												'promo_update_jam'=>date('H:i:s'),
												'promo_gambar'=>$hasil22['file_name']);
												$where = array('promo_id' => $this->input->post('promo_id'));
												$_image = $this->db->get_where('promo',$where)->row();
												$query = $this->db->update('promo',$data,$where);
												if($query){
													unlink("assets/frontend/promo/".$_image->promo_gambar);
												}

							}
							redirect('aspanel/promo');
			}else{
				if ($this->session->level=='1'){
						 $proses = $this->As_m->edit('promo', array('promo_id' => $id))->row_array();
				}else{
						$proses = $this->As_m->edit('promo', array('promo_id' => $id, 'promo_post_oleh' => $this->session->username))->row_array();
				}
				$data = array('rows' => $proses);
				if ($this->session->level=='1'){
						cek_session_akses('promo',$this->session->id_session);
						$data['home_stat']   = '';
						$data['records'] = $this->Crud_m->view_where_ordering('templates',array('templates_status'=>'Publish'),'templates_id','DESC');
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}elseif ($this->session->level=='2'){
						cek_session_akses_admin('promo',$this->session->id_session);
						$data['home_stat']   = '';
						$data['records'] = $this->Crud_m->view_where_ordering('templates',array('templates_status'=>'Publish'),'templates_id','DESC');
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}else{
						cek_session_akses_staff('promo',$this->session->id_session);
						$data['home_stat']   = '';
						$data['records'] = $this->Crud_m->view_where_ordering('templates',array('templates_status'=>'Publish'),'templates_id','DESC');
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}
				$this->load->view('backend/promo/v_update', $data);
			}
		}
		function promo_delete_temp()
		{
			if ($this->session->level=='1'){
					cek_session_akses('promo',$this->session->id_session);
					$data = array('promo_status'=>'delete');
		      $where = array('promo_id' => $this->uri->segment(3));
					$this->db->update('promo', $data, $where);
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('promo',$this->session->id_session);
					$data = array('promo_status'=>'delete');
		      $where = array('promo_id' => $this->uri->segment(3));
					$this->db->update('promo', $data, $where);
				}else{
					cek_session_akses_staff('promo',$this->session->id_session);
					$data = array('promo_status'=>'delete');
		      $where = array('promo_id' => $this->uri->segment(3));
					$this->db->update('promo', $data, $where);
				}
				redirect('aspanel/promo');
		}
		function promo_restore()
		{
			if ($this->session->level=='1'){
					cek_session_akses('promo',$this->session->id_session);
					$data = array('promo_status'=>'Publish');
					$where = array('promo_id' => $this->uri->segment(3));
					$this->db->update('promo', $data, $where);
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('promo',$this->session->id_session);
					$data = array('promo_status'=>'Publish');
					$where = array('promo_id' => $this->uri->segment(3));
					$this->db->update('promo', $data, $where);
				}else{
					cek_session_akses_staff('promo',$this->session->id_session);
					$data = array('promo_status'=>'Publish');
					$where = array('promo_id' => $this->uri->segment(3));
					$this->db->update('promo', $data, $where);
				}
				redirect('aspanel/promo_storage_bin');
		}
		public function promo_delete()
		{
			 if ($this->session->level=='1'){
 					cek_session_akses('promo',$this->session->id_session);
 					$id = $this->uri->segment(3);
 					$_id = $this->db->get_where('promo',['promo_id' => $id])->row();
 					 $query = $this->db->delete('promo',['promo_id'=>$id]);
 				 	if($query){
 									 unlink("./assets/frontend/promo/".$_id->promo_gambar);
 				 			 }
 				}elseif ($this->session->level=='2'){
 					cek_session_akses_admin('promo',$this->session->id_session);
 					$id = $this->uri->segment(3);
 					$_id = $this->db->get_where('promo',['promo_id' => $id])->row();
 					 $query = $this->db->delete('promo',['promo_id'=>$id]);
 				 	if($query){
 									 unlink("./assets/frontend/promo/".$_id->promo_gambar);
 				 			 }
 				}else{
 					cek_session_akses_staff('promo',$this->session->id_session);
 				}
			redirect('aspanel/promo_storage_bin');
		}
		/*	Bagian untuk promo - Penutup	*/

		/*	Bagian untuk testimoni - Pembuka	*/
		public function testimoni()
		{
					if ($this->session->level=='1'){
							$data['record'] = $this->Crud_m->view_where_ordering('testimoni',array('testimoni_status'=>'publish'),'testimoni_id','DESC');
					}else{
							$data['record'] = $this->Crud_m->view_where_ordering('testimoni',array('testimoni_post_oleh'=>$this->session->username,'testimoni_status'=>'publish'),'testimoni_id','DESC');
					}
					cek_session_akses('testimoni',$this->session->id_session);
					$this->load->view('backend/testimoni/v_daftar', $data);
		}
		public function testimoni_storage_bin()
		{
					if ($this->session->level=='1'){
							$data['record'] = $this->Crud_m->view_where_ordering('testimoni',array('testimoni_status'=>'delete'),'testimoni_id','DESC');
					}else{
							$data['record'] = $this->Crud_m->view_where_ordering('testimoni',array('testimoni_post_oleh'=>$this->session->username,'testimoni_status'=>'delete'),'testimoni_id','DESC');
					}
					cek_session_akses('testimoni',$this->session->id_session);
					$this->load->view('backend/testimoni/v_daftar_hapus', $data);
		}
		public function testimoni_tambahkan()
		{
			if (isset($_POST['submit'])){

						$config['upload_path'] = 'assets/frontend/testimoni/';
						$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
						$this->upload->initialize($config);
						$this->upload->do_upload('gambar');
						$hasil22=$this->upload->data();
						$config['image_library']='gd2';
						$config['source_image'] = './assets/frontend/testimoni/'.$hasil22['file_name'];
						$config['create_thumb']= FALSE;
						$config['maintain_ratio']= FALSE;
						$config['quality']= '80%';
						$config['width']= 100;
						$config['height']= 100;
						$config['new_image']= './assets/frontend/testimoni/'.$hasil22['file_name'];
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						if ($this->input->post('testimoni_keyword')!=''){
									$tag_seo = $this->input->post('testimoni_keyword');
									$tag=implode(',',$tag_seo);
							}else{
									$tag = '';
							}
						$tag = $this->input->post('testimoni_keyword');
						$tags = explode(",", $tag);
						$tags2 = array();
						foreach($tags as $t)
						{
							$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
							$a = $this->db->query($sql)->result_array();
							if(count($a) == 0){
								$data = array('keyword_nama'=>$this->db->escape_str($t),
										'keyword_username'=>$this->session->username,
										'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
										'count'=>'0');
								$this->As_m->insert('keyword',$data);
							}
							$tags2[] = $this->mylibrary->seo_title($t);
						}
						$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
														'testimoni_post_oleh'=>$this->session->username,
														'testimoni_judul'=>$this->db->escape_str($this->input->post('testimoni_judul')),
														'testimoni_judul_seo'=>$this->mylibrary->seo_title($this->input->post('testimoni_judul')),
														'testimoni_desk'=>$this->input->post('testimoni_desk'),
														'testimoni_jabatan'=>$this->input->post('testimoni_jabatan'),
														'testimoni_post_hari'=>hari_ini(date('w')),
														'testimoni_post_tanggal'=>date('Y-m-d'),
														'testimoni_post_jam'=>date('H:i:s'),
														'testimoni_dibaca'=>'0',
														'testimoni_status'=>'publish',
														'testimoni_meta_desk'=>$this->input->post('testimoni_meta_desk'),
														'testimoni_keyword'=>$tag);
												}else{
													$data = array(
														'testimoni_post_oleh'=>$this->session->username,
														'testimoni_judul'=>$this->db->escape_str($this->input->post('testimoni_judul')),
														'testimoni_judul_seo'=>$this->mylibrary->seo_title($this->input->post('testimoni_judul')),
														'testimoni_desk'=>$this->input->post('testimoni_desk'),
														'testimoni_jabatan'=>$this->input->post('testimoni_jabatan'),
														'testimoni_post_hari'=>hari_ini(date('w')),
														'testimoni_post_tanggal'=>date('Y-m-d'),
														'testimoni_post_jam'=>date('H:i:s'),
														'testimoni_dibaca'=>'0',
														'testimoni_status'=>'publish',
														'testimoni_gambar'=>$hasil22['file_name'],
														'testimoni_meta_desk'=>$this->input->post('testimoni_meta_desk'),
														'testimoni_keyword'=>$tag);
													}
									$this->As_m->insert('testimoni',$data);
									redirect('aspanel/testimoni');
					}else{

						cek_session_akses('testimoni',$this->session->id_session);
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						$this->load->view('backend/testimoni/v_tambahkan', $data);
					}
		}
		public function testimoni_update()
		{

			$id = $this->uri->segment(3);
			if (isset($_POST['submit'])){

				$config['upload_path'] = 'assets/frontend/testimoni/';
				$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
				$this->upload->initialize($config);
				$this->upload->do_upload('gambar');
				$hasil22=$this->upload->data();
				$config['image_library']='gd2';
				$config['source_image'] = './assets/frontend/testimoni/'.$hasil22['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= FALSE;
				$config['quality']= '80%';
				$config['width']= 100;
				$config['height']= 100;
				$config['new_image']= './assets/frontend/testimoni/'.$hasil22['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				if ($this->input->post('testimoni_keyword')!=''){
							$tag_seo = $this->input->post('testimoni_keyword');
							$tag=implode(',',$tag_seo);
					}else{
							$tag = '';
					}
				$tag = $this->input->post('testimoni_keyword');
				$tags = explode(",", $tag);
				$tags2 = array();
				foreach($tags as $t)
				{
					$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
					$a = $this->db->query($sql)->result_array();
					if(count($a) == 0){
						$data = array('keyword_nama'=>$this->db->escape_str($t),
								'keyword_username'=>$this->session->username,
								'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
								'count'=>'0');
						$this->As_m->insert('keyword',$data);
					}
					$tags2[] = $this->mylibrary->seo_title($t);
				}
				$tags = implode(",", $tags2);
							if ($hasil22['file_name']==''){
											$data = array(
												'testimoni_update_oleh'=>$this->session->username,
												'testimoni_judul'=>$this->db->escape_str($this->input->post('testimoni_judul')),
												'testimoni_judul_seo'=>$this->mylibrary->seo_title($this->input->post('testimoni_judul')),
												'testimoni_desk'=>$this->input->post('testimoni_desk'),
												'testimoni_jabatan'=>$this->input->post('testimoni_jabatan'),
												'testimoni_update_hari'=>hari_ini(date('w')),
												'testimoni_update_tanggal'=>date('Y-m-d'),
												'testimoni_update_jam'=>date('H:i:s'),
												'testimoni_meta_desk'=>$this->input->post('testimoni_meta_desk'),
												'testimoni_keyword'=>$tag);
												$where = array('testimoni_id' => $this->input->post('testimoni_id'));
												$this->db->update('testimoni', $data, $where);
							}else{
											$data = array(
												'testimoni_update_oleh'=>$this->session->username,
												'testimoni_judul'=>$this->db->escape_str($this->input->post('testimoni_judul')),
												'testimoni_judul_seo'=>$this->mylibrary->seo_title($this->input->post('testimoni_judul')),
												'testimoni_desk'=>$this->input->post('testimoni_desk'),
												'testimoni_jabatan'=>$this->input->post('testimoni_jabatan'),
												'testimoni_update_hari'=>hari_ini(date('w')),
												'testimoni_update_tanggal'=>date('Y-m-d'),
												'testimoni_update_jam'=>date('H:i:s'),
												'testimoni_gambar'=>$hasil22['file_name'],
												'testimoni_meta_desk'=>$this->input->post('testimoni_meta_desk'),
												'testimoni_keyword'=>$tag);
												$where = array('testimoni_id' => $this->input->post('testimoni_id'));
												$_image = $this->db->get_where('testimoni',$where)->row();
												$query = $this->db->update('testimoni',$data,$where);
												if($query){
													unlink("assets/frontend/testimoni/".$_image->testimoni_gambar);
												}

							}
							redirect('aspanel/testimoni');
			}else{
				if ($this->session->level=='1'){
						 $proses = $this->As_m->edit('testimoni', array('testimoni_id' => $id))->row_array();
				}else{
						$proses = $this->As_m->edit('testimoni', array('testimoni_id' => $id, 'testimoni_post_oleh' => $this->session->username))->row_array();
				}
				$data = array('rows' => $proses);

					cek_session_akses('testimoni',$this->session->id_session);
				$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				$this->load->view('backend/testimoni/v_update', $data);
			}
		}
		function testimoni_delete_temp()
		{
				cek_session_akses('testimoni',$this->session->id_session);
				$data = array('testimoni_status'=>'delete');
				$where = array('testimoni_id' => $this->uri->segment(3));
				$this->db->update('testimoni', $data, $where);
				redirect('aspanel/testimoni');
		}
		function testimoni_restore()
		{
				cek_session_akses('testimoni',$this->session->id_session);
				$data = array('testimoni_status'=>'Publish');
				$where = array('testimoni_id' => $this->uri->segment(3));
				$this->db->update('testimoni', $data, $where);
				redirect('aspanel/testimoni_storage_bin');
		}
		public function testimoni_delete()
		{
				cek_session_akses('testimoni',$this->session->id_session);
				$id = $this->uri->segment(3);
				$_id = $this->db->get_where('testimoni',['testimoni_id' => $id])->row();
				 $query = $this->db->delete('testimoni',['testimoni_id'=>$id]);
				if($query){
								 unlink("./assets/frontend/testimoni/".$_id->testimoni_gambar);
			 }
			redirect('aspanel/testimoni_storage_bin');
		}
		/*	Bagian untuk testimoni - Penutup	*/

		/*	Bagian untuk klien - Pembuka	*/
		public function klien()
		{
			if ($this->session->level=='1'){
				cek_session_akses('klien',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('klien',array('klien_status'=>'publish'),'klien_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('klien',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('klien',array('klien_status'=>'publish'),'klien_id','DESC');
				}else{
					cek_session_akses_staff('klien',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('klien',array('klien_post_oleh'=>$this->session->username,'klien_status'=>'publish'),'klien_id','DESC');
				}
				$this->load->view('backend/klien/v_daftar', $data);
		}
		public function klien_storage_bin()
		{
			if ($this->session->level=='1'){
				cek_session_akses('klien',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('klien',array('klien_status'=>'delete'),'klien_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('klien',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('klien',array('klien_status'=>'delete'),'klien_id','DESC');
				}else{
					cek_session_akses_staff('klien',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('klien',array('klien_post_oleh'=>$this->session->username,'klien_status'=>'delete'),'klien_id','DESC');
				}
				$this->load->view('backend/klien/v_daftar_hapus', $data);
		}
		public function klien_tambahkan()
		{
			if (isset($_POST['submit'])){

						$config['upload_path'] = 'assets/frontend/klien/';
						$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
						$this->upload->initialize($config);
						$this->upload->do_upload('gambar');
						$hasil22=$this->upload->data();
						$config['image_library']='gd2';
						$config['source_image'] = './assets/frontend/klien/'.$hasil22['file_name'];
						$config['create_thumb']= FALSE;
						$config['maintain_ratio']= FALSE;
						$config['quality']= '95%';
						$config['new_image']= './assets/frontend/klien/'.$hasil22['file_name'];
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						if ($hasil22['file_name']==''){
										$data = array(
														'klien_post_oleh'=>$this->session->username,
														'klien_nama_pemesan'=>$this->input->post('klien_nama_pemesan'),
														'klien_nama_pasangan'=>$this->input->post('klien_nama_pasangan'),
														'klien_whatsapp'=>$this->input->post('klien_whatsapp'),
														'klien_instagram'=>$this->input->post('klien_instagram'),
														'klien_alamat'=>$this->input->post('klien_alamat'),
														'klien_produk'=>$this->input->post('klien_produk'),
														'klien_post_hari'=>hari_ini(date('w')),
														'klien_post_tanggal'=>date('Y-m-d'),
														'klien_post_jam'=>date('H:i:s'),
														'klien_dibaca'=>'0',
														'klien_status'=>'publish',
														'klien_meta_desk'=>$this->input->post('klien_meta_desk'),
														'klien_keyword'=>$tag);
												}else{
													$data = array(
														'klien_post_oleh'=>$this->session->username,
														'klien_judul'=>$this->db->escape_str($this->input->post('klien_judul')),
														'klien_judul_seo'=>$this->mylibrary->seo_title($this->input->post('klien_judul')),
														'klien_desk'=>$this->input->post('klien_desk'),
														'klien_post_hari'=>hari_ini(date('w')),
														'klien_post_tanggal'=>date('Y-m-d'),
														'klien_post_jam'=>date('H:i:s'),
														'klien_dibaca'=>'0',
														'klien_status'=>'publish',
														'klien_gambar'=>$hasil22['file_name'],
														'klien_meta_desk'=>$this->input->post('klien_meta_desk'),
														'klien_keyword'=>$tag);
													}
									$this->As_m->insert('klien',$data);
									redirect('aspanel/klien');
					}else{
						if ($this->session->level=='1'){
								cek_session_akses('klien',$this->session->id_session);
								$data['home_stat']   = '';
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}elseif ($this->session->level=='2'){
								cek_session_akses_admin('klien',$this->session->id_session);
								$data['home_stat']   = '';
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}else{
								cek_session_akses_staff('klien',$this->session->id_session);
								$data['home_stat']   = '';
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}
						$this->load->view('backend/klien/v_tambahkan', $data);
					}
		}
		public function klien_update()
		{

			$id = $this->uri->segment(3);
			if (isset($_POST['submit'])){

				$config['upload_path'] = 'assets/frontend/liniklien/';
				$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
				$this->upload->initialize($config);
				$this->upload->do_upload('gambar');
				$hasil22=$this->upload->data();
				$config['image_library']='gd2';
				$config['source_image'] = './assets/frontend/liniklien/'.$hasil22['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= FALSE;
				$config['quality']= '80%';
				$config['new_image']= './assets/frontend/liniklien/'.$hasil22['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				if ($this->input->post('klien_keyword')!=''){
							$tag_seo = $this->input->post('klien_keyword');
							$tag=implode(',',$tag_seo);
					}else{
							$tag = '';
					}
				$tag = $this->input->post('klien_keyword');
				$tags = explode(",", $tag);
				$tags2 = array();
				foreach($tags as $t)
				{
					$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
					$a = $this->db->query($sql)->result_array();
					if(count($a) == 0){
						$data = array('keyword_nama'=>$this->db->escape_str($t),
								'keyword_username'=>$this->session->username,
								'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
								'count'=>'0');
						$this->As_m->insert('keyword',$data);
					}
					$tags2[] = $this->mylibrary->seo_title($t);
				}
				$tags = implode(",", $tags2);
							if ($hasil22['file_name']==''){
											$data = array(
												'klien_update_oleh'=>$this->session->username,
												'klien_judul'=>$this->db->escape_str($this->input->post('klien_judul')),
												'klien_judul_seo'=>$this->mylibrary->seo_title($this->input->post('klien_judul')),
												'klien_desk'=>$this->input->post('klien_desk'),
												'klien_update_hari'=>hari_ini(date('w')),
												'klien_update_tanggal'=>date('Y-m-d'),
												'klien_update_jam'=>date('H:i:s'),
												'klien_meta_desk'=>$this->input->post('klien_meta_desk'),
												'klien_keyword'=>$tag);
												$where = array('klien_id' => $this->input->post('klien_id'));
												$this->db->update('klien', $data, $where);
							}else{
											$data = array(
												'klien_update_oleh'=>$this->session->username,
												'klien_judul'=>$this->db->escape_str($this->input->post('klien_judul')),
												'klien_judul_seo'=>$this->mylibrary->seo_title($this->input->post('klien_judul')),
												'klien_desk'=>$this->input->post('klien_desk'),
												'klien_update_hari'=>hari_ini(date('w')),
												'klien_update_tanggal'=>date('Y-m-d'),
												'klien_update_jam'=>date('H:i:s'),
												'klien_gambar'=>$hasil22['file_name'],
												'klien_meta_desk'=>$this->input->post('klien_meta_desk'),
												'klien_keyword'=>$tag);
												$where = array('klien_id' => $this->input->post('klien_id'));
												$_image = $this->db->get_where('klien',$where)->row();
												$query = $this->db->update('klien',$data,$where);
												if($query){
													unlink("assets/frontend/liniklien/".$_image->klien_gambar);
												}

							}
							redirect('aspanel/klien');
			}else{
				if ($this->session->level=='1'){
						 $proses = $this->As_m->edit('klien', array('klien_id' => $id))->row_array();
				}else{
						$proses = $this->As_m->edit('klien', array('klien_id' => $id, 'klien_post_oleh' => $this->session->username))->row_array();
				}

				if ($this->session->level=='1'){
						cek_session_akses('klien',$this->session->id_session);
						$data['home_stat']   = '';
						$data = array('rows' => $proses);
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}elseif ($this->session->level=='2'){
						cek_session_akses_admin('klien',$this->session->id_session);
						$data['home_stat']   = '';
						$data = array('rows' => $proses);
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}else{
						cek_session_akses_staff('klien',$this->session->id_session);
						$data['home_stat']   = '';
						$data = array('rows' => $proses);
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}
				$this->load->view('backend/klien/v_update', $data);
			}
		}
		function klien_delete_temp()
		{
			if ($this->session->level=='1'){
					cek_session_akses('klien',$this->session->id_session);
					$data = array('klien_status'=>'delete');
		      $where = array('klien_id' => $this->uri->segment(3));
					$this->db->update('klien', $data, $where);
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('klien',$this->session->id_session);
					$data = array('klien_status'=>'delete');
		      $where = array('klien_id' => $this->uri->segment(3));
					$this->db->update('klien', $data, $where);
				}else{
					cek_session_akses_staff('klien',$this->session->id_session);
					$data = array('klien_status'=>'delete');
		      $where = array('klien_id' => $this->uri->segment(3));
					$this->db->update('klien', $data, $where);
				}
			redirect('aspanel/klien');
		}
		function klien_restore()
		{
			if ($this->session->level=='1'){
					cek_session_akses('klien',$this->session->id_session);
					$data = array('klien_status'=>'publish');
					$where = array('klien_id' => $this->uri->segment(3));
					$this->db->update('klien', $data, $where);
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('klien',$this->session->id_session);
					$data = array('klien_status'=>'publish');
					$where = array('klien_id' => $this->uri->segment(3));
					$this->db->update('klien', $data, $where);
				}else{
					cek_session_akses_staff('klien',$this->session->id_session);
					$data = array('klien_status'=>'publish');
					$where = array('klien_id' => $this->uri->segment(3));
					$this->db->update('klien', $data, $where);
				}
				redirect('aspanel/klien_storage_bin');
		}
		public function klien_delete()
		{
			 if ($this->session->level=='1'){
 				 cek_session_akses('klien',$this->session->id_session);
 				 $id = $this->uri->segment(3);
 				 $_id = $this->db->get_where('klien',['klien_id' => $id])->row();
 					$query = $this->db->delete('klien',['klien_id'=>$id]);
 				 if($query){
 									unlink("./assets/frontend/liniklien/".$_id->klien_gambar);
 							}
 			 }elseif ($this->session->level=='2'){
 				 cek_session_akses_admin('klien',$this->session->id_session);
 				 $id = $this->uri->segment(3);
 				 $_id = $this->db->get_where('klien',['klien_id' => $id])->row();
 					$query = $this->db->delete('klien',['klien_id'=>$id]);
 				 if($query){
 									unlink("./assets/frontend/liniklien/".$_id->klien_gambar);
 							}
 			 }else{
 				 cek_session_akses_staff('klien',$this->session->id_session);
 			 }
			redirect('aspanel/klien_storage_bin');
		}
		/*	Bagian untuk klien - Penutup	*/

		/*	Bagian untuk note - Pembuka	*/
		public function note()
		{
			if ($this->session->level=='1'){
				cek_session_akses('note',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('note',array('note_status'=>'publish'),'note_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('note',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('note',array('note_status'=>'publish'),'note_id','DESC');
				}else{
					cek_session_akses_staff('note',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('note',array('note_post_oleh'=>$this->session->username,'note_status'=>'publish'),'note_id','DESC');
			}
			$this->load->view('backend/note/v_daftar', $data);
		}
		public function note_storage_bin()
		{
			if ($this->session->level=='1'){
				cek_session_akses('note',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('note',array('note_status'=>'delete'),'note_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('note',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('note',array('note_status'=>'delete'),'note_id','DESC');
				}else{
					cek_session_akses_staff('note',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('note',array('note_post_oleh'=>$this->session->username,'note_status'=>'delete'),'note_id','DESC');
			}
			$this->load->view('backend/note/v_daftar_hapus', $data);
		}
		public function note_tambahkan()
		{
			if (isset($_POST['submit'])){

						$config['upload_path'] = 'assets/frontend/lininote/';
						$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
						$this->upload->initialize($config);
						$this->upload->do_upload('gambar');
						$hasil22=$this->upload->data();
						$config['image_library']='gd2';
						$config['source_image'] = './assets/frontend/lininote/'.$hasil22['file_name'];
						$config['create_thumb']= FALSE;
						$config['maintain_ratio']= FALSE;
						$config['quality']= '80%';
						$config['new_image']= './assets/frontend/lininote/'.$hasil22['file_name'];
						$this->load->library('image_lib', $config);
						$this->image_lib->resize();

						if ($this->input->post('note_keyword')!=''){
									$tag_seo = $this->input->post('note_keyword');
									$tag=implode(',',$tag_seo);
							}else{
									$tag = '';
							}
						$tag = $this->input->post('note_keyword');
						$tags = explode(",", $tag);
						$tags2 = array();
						foreach($tags as $t)
						{
							$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
							$a = $this->db->query($sql)->result_array();
							if(count($a) == 0){
								$data = array('keyword_nama'=>$this->db->escape_str($t),
										'keyword_username'=>$this->session->username,
										'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
										'count'=>'0');
								$this->As_m->insert('keyword',$data);
							}
							$tags2[] = $this->mylibrary->seo_title($t);
						}
						$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
														'note_post_oleh'=>$this->session->username,
														'note_judul'=>$this->db->escape_str($this->input->post('note_judul')),
														'note_judul_seo'=>$this->mylibrary->seo_title($this->input->post('note_judul')),
														'note_desk'=>$this->input->post('note_desk'),
														'note_post_hari'=>hari_ini(date('w')),
														'note_post_tanggal'=>date('Y-m-d'),
														'note_post_jam'=>date('H:i:s'),
														'note_dibaca'=>'0',
														'note_status'=>'publish',
														'note_meta_desk'=>$this->input->post('note_meta_desk'),
														'note_keyword'=>$tag);
												}else{
													$data = array(
														'note_post_oleh'=>$this->session->username,
														'note_judul'=>$this->db->escape_str($this->input->post('note_judul')),
														'note_judul_seo'=>$this->mylibrary->seo_title($this->input->post('note_judul')),
														'note_desk'=>$this->input->post('note_desk'),
														'note_post_hari'=>hari_ini(date('w')),
														'note_post_tanggal'=>date('Y-m-d'),
														'note_post_jam'=>date('H:i:s'),
														'note_dibaca'=>'0',
														'note_status'=>'publish',
														'note_gambar'=>$hasil22['file_name'],
														'note_meta_desk'=>$this->input->post('note_meta_desk'),
														'note_keyword'=>$tag);
													}
									$this->As_m->insert('note',$data);
									redirect('aspanel/note');
					}else{
						if ($this->session->level=='1'){
								cek_session_akses('note',$this->session->id_session);
								$data['home_stat']   = '';
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}elseif ($this->session->level=='2'){
								cek_session_akses_admin('note',$this->session->id_session);
								$data['home_stat']   = '';
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}else{
								cek_session_akses_staff('note',$this->session->id_session);
								$data['home_stat']   = '';
								$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
							}
						$this->load->view('backend/note/v_tambahkan', $data);
					}
		}
		public function note_update()
		{

			$id = $this->uri->segment(3);
			if (isset($_POST['submit'])){

				$config['upload_path'] = 'assets/frontend/lininote/';
				$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
				$this->upload->initialize($config);
				$this->upload->do_upload('gambar');
				$hasil22=$this->upload->data();
				$config['image_library']='gd2';
				$config['source_image'] = './assets/frontend/lininote/'.$hasil22['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= FALSE;
				$config['quality']= '80%';
				$config['new_image']= './assets/frontend/lininote/'.$hasil22['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				if ($this->input->post('note_keyword')!=''){
							$tag_seo = $this->input->post('note_keyword');
							$tag=implode(',',$tag_seo);
					}else{
							$tag = '';
					}
				$tag = $this->input->post('note_keyword');
				$tags = explode(",", $tag);
				$tags2 = array();
				foreach($tags as $t)
				{
					$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
					$a = $this->db->query($sql)->result_array();
					if(count($a) == 0){
						$data = array('keyword_nama'=>$this->db->escape_str($t),
								'keyword_username'=>$this->session->username,
								'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
								'count'=>'0');
						$this->As_m->insert('keyword',$data);
					}
					$tags2[] = $this->mylibrary->seo_title($t);
				}
				$tags = implode(",", $tags2);
							if ($hasil22['file_name']==''){
											$data = array(
												'note_update_oleh'=>$this->session->username,
												'note_judul'=>$this->db->escape_str($this->input->post('note_judul')),
												'note_judul_seo'=>$this->mylibrary->seo_title($this->input->post('note_judul')),
												'note_desk'=>$this->input->post('note_desk'),
												'note_update_hari'=>hari_ini(date('w')),
												'note_update_tanggal'=>date('Y-m-d'),
												'note_update_jam'=>date('H:i:s'),
												'note_meta_desk'=>$this->input->post('note_meta_desk'),
												'note_keyword'=>$tag);
												$where = array('note_id' => $this->input->post('note_id'));
												$this->db->update('note', $data, $where);
							}else{
											$data = array(
												'note_update_oleh'=>$this->session->username,
												'note_judul'=>$this->db->escape_str($this->input->post('note_judul')),
												'note_judul_seo'=>$this->mylibrary->seo_title($this->input->post('note_judul')),
												'note_desk'=>$this->input->post('note_desk'),
												'note_update_hari'=>hari_ini(date('w')),
												'note_update_tanggal'=>date('Y-m-d'),
												'note_update_jam'=>date('H:i:s'),
												'note_gambar'=>$hasil22['file_name'],
												'note_meta_desk'=>$this->input->post('note_meta_desk'),
												'note_keyword'=>$tag);
												$where = array('note_id' => $this->input->post('note_id'));
												$_image = $this->db->get_where('note',$where)->row();
												$query = $this->db->update('note',$data,$where);
												if($query){
													unlink("assets/frontend/lininote/".$_image->note_gambar);
												}

							}
							redirect('aspanel/note');
			}else{
				if ($this->session->level=='1'){
						 $proses = $this->As_m->edit('note', array('note_id' => $id))->row_array();
				}else{
						$proses = $this->As_m->edit('note', array('note_id' => $id, 'note_post_oleh' => $this->session->username))->row_array();
				}

				if ($this->session->level=='1'){
						cek_session_akses('note',$this->session->id_session);
						$data['home_stat']   = '';
						$data = array('rows' => $proses);
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}elseif ($this->session->level=='2'){
						cek_session_akses_admin('note',$this->session->id_session);
						$data['home_stat']   = '';
						$data = array('rows' => $proses);
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}else{
						cek_session_akses_staff('note',$this->session->id_session);
						$data['home_stat']   = '';
						$data = array('rows' => $proses);
						$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					}
				$this->load->view('backend/note/v_update', $data);
			}
		}
		function note_delete_temp()
		{
			if ($this->session->level=='1'){
					cek_session_akses('note',$this->session->id_session);
					$data = array('note_status'=>'delete');
		      $where = array('note_id' => $this->uri->segment(3));
					$this->db->update('note', $data, $where);
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('note',$this->session->id_session);
					$data = array('note_status'=>'delete');
		      $where = array('note_id' => $this->uri->segment(3));
					$this->db->update('note', $data, $where);
				}else{
					cek_session_akses_staff('note',$this->session->id_session);
					$data = array('note_status'=>'delete');
		      $where = array('note_id' => $this->uri->segment(3));
					$this->db->update('note', $data, $where);
				}
				redirect('aspanel/note');
		}
		function note_restore()
		{
			if ($this->session->level=='1'){
					cek_session_akses('note',$this->session->id_session);
					$data = array('note_status'=>'Publish');
					$where = array('note_id' => $this->uri->segment(3));
					$this->db->update('note', $data, $where);
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('note',$this->session->id_session);
					$data = array('note_status'=>'Publish');
					$where = array('note_id' => $this->uri->segment(3));
					$this->db->update('note', $data, $where);
				}else{
					cek_session_akses_staff('note',$this->session->id_session);
					$data = array('note_status'=>'Publish');
					$where = array('note_id' => $this->uri->segment(3));
					$this->db->update('note', $data, $where);
				}
				redirect('aspanel/note_storage_bin');
		}
		public function note_delete()
		{
			if ($this->session->level=='1'){
				 cek_session_akses('note',$this->session->id_session);
				 $id = $this->uri->segment(3);
				 $_id = $this->db->get_where('note',['note_id' => $id])->row();
					$query = $this->db->delete('note',['note_id'=>$id]);
				 if($query){
									unlink("./assets/frontend/lininote/".$_id->note_gambar);
							}
			 }elseif ($this->session->level=='2'){
				 cek_session_akses_admin('note',$this->session->id_session);
				 $id = $this->uri->segment(3);
				 $_id = $this->db->get_where('note',['note_id' => $id])->row();
					$query = $this->db->delete('note',['note_id'=>$id]);
				 if($query){
									unlink("./assets/frontend/lininote/".$_id->note_gambar);
							}
			 }else{
				 cek_session_akses_staff('note',$this->session->id_session);
			 }
			redirect('aspanel/note_storage_bin');
		}
		/*	Bagian untuk note - Penutup	*/



	/*	Bagian untuk Produks cat - Pembuka	*/
	public function produks_cat()
	{
		$data['home_stat']   = '';
				if ($this->session->level=='1'){
						cek_session_akses('produks_cat',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'publish'),'templates_cat_id','DESC');
					}elseif ($this->session->level=='2'){
						cek_session_akses_admin('produks_cat',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'publish'),'templates_cat_id','DESC');
					}else{
						cek_session_akses_staff('produks_cat',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_post_oleh'=>$this->session->username,'templates_cat_status'=>'publish'),'templates_cat_id','DESC');
				}

				$this->load->view('backend/templates_cat/v_daftar', $data);
	}
	public function produks_cat_storage_bin()
	{
		$data['home_stat']   = '';
		if ($this->session->level=='1'){
				cek_session_akses('produks_cat',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'delete'),'templates_cat_id','DESC');
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('produks_cat',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'delete'),'templates_cat_id','DESC');
			}else{
				cek_session_akses_staff('produks_cat',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_post_oleh'=>$this->session->username,'templates_cat_status'=>'delete'),'templates_cat_id','DESC');
		}

		$this->load->view('backend/templates_cat/v_daftar_hapus', $data);
	}
	public function produks_cat_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'bahan/foto_templates/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './bahan/foto_templates/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '60%';
					$config['width']= 150;
					$config['height']= 150;
					$config['new_image']= './bahan/foto_templates/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('templates_cat_keyword')!=''){
								$tag_seo = $this->input->post('templates_cat_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('templates_cat_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
													'templates_cat_post_oleh'=>$this->session->username,
													'templates_cat_judul'=>$this->db->escape_str($this->input->post('templates_cat_judul')),
													'templates_cat_judul_seo'=>$this->mylibrary->seo_title($this->input->post('templates_cat_judul')),
													'templates_cat_desk'=>$this->input->post('templates_cat_desk'),
													'templates_cat_post_hari'=>hari_ini(date('w')),
													'templates_cat_post_tanggal'=>date('Y-m-d'),
													'templates_cat_post_jam'=>date('H:i:s'),
													'templates_cat_dibaca'=>'0',
													'templates_cat_status'=>'publish',
													'templates_cat_meta_desk'=>$this->input->post('templates_cat_meta_desk'),
													'templates_cat_keyword'=>$tag);
											}else{
												$data = array(
													'templates_cat_post_oleh'=>$this->session->username,
													'templates_cat_judul'=>$this->db->escape_str($this->input->post('templates_cat_judul')),
													'templates_cat_judul_seo'=>$this->mylibrary->seo_title($this->input->post('templates_cat_judul')),
													'templates_cat_desk'=>$this->input->post('templates_cat_desk'),
													'templates_cat_post_hari'=>hari_ini(date('w')),
													'templates_cat_post_tanggal'=>date('Y-m-d'),
													'templates_cat_post_jam'=>date('H:i:s'),
													'templates_cat_dibaca'=>'0',
													'templates_cat_status'=>'publish',
													'templates_catgambar'=>$hasil22['file_name'],
													'templates_cat_meta_desk'=>$this->input->post('templates_cat_meta_desk'),
													'templates_cat_keyword'=>$tag);
												}
								$this->As_m->insert('templates_category',$data);
								redirect('aspanel/produks_cat');
				}else{
					if ($this->session->level=='1'){
							cek_session_akses('produks_cat',$this->session->id_session);
							$data['home_stat']   = '';
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}elseif ($this->session->level=='2'){
							cek_session_akses_admin('produks_cat',$this->session->id_session);
							$data['home_stat']   = '';
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}else{
							cek_session_akses_staff('produks_cat',$this->session->id_session);
							$data['home_stat']   = '';
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}
					$this->load->view('backend/templates_cat/v_tambahkan', $data);
				}
	}
	public function produks_cat_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'bahan/foto_templates/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './bahan/foto_templates/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '100%';
			$config['width']= 150;
			$config['height']= 150;
			$config['new_image']= './bahan/foto_templates/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('templates_cat_keyword')!=''){
						$tag_seo = $this->input->post('templates_cat_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('templates_cat_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'templates_cat_update_oleh'=>$this->session->username,
											'templates_cat_judul'=>$this->db->escape_str($this->input->post('templates_cat_judul')),
											'templates_cat_judul_seo'=>$this->mylibrary->seo_title($this->input->post('templates_cat_judul')),
											'templates_cat_desk'=>$this->input->post('templates_cat_desk'),
											'templates_cat_update_hari'=>hari_ini(date('w')),
											'templates_cat_update_tanggal'=>date('Y-m-d'),
											'templates_cat_update_jam'=>date('H:i:s'),
											'templates_cat_meta_desk'=>$this->input->post('templates_cat_meta_desk'),
											'templates_cat_keyword'=>$tag);
											$where = array('templates_cat_id' => $this->input->post('templates_cat_id'));
											$this->db->update('templates_category', $data, $where);
						}else{
										$data = array(
											'templates_cat_update_oleh'=>$this->session->username,
											'templates_cat_judul'=>$this->db->escape_str($this->input->post('templates_cat_judul')),
											'templates_cat_judul_seo'=>$this->mylibrary->seo_title($this->input->post('templates_cat_judul')),
											'templates_cat_desk'=>$this->input->post('templates_cat_desk'),
											'templates_cat_update_hari'=>hari_ini(date('w')),
											'templates_cat_update_tanggal'=>date('Y-m-d'),
											'templates_cat_update_jam'=>date('H:i:s'),
											'templates_cat_gambar'=>$hasil22['file_name'],
											'templates_cat_meta_desk'=>$this->input->post('templates_cat_meta_desk'),
											'templates_cat_keyword'=>$tag);
											$where = array('templates_cat_id' => $this->input->post('templates_cat_id'));
											$_image = $this->db->get_where('templates_category',$where)->row();
											$query = $this->db->update('templates_category',$data,$where);
											if($query){
												unlink("bahan/foto_templates/".$_image->templates_cat_gambar);
											}

						}
						redirect('aspanel/produks_cat');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('templates_category', array('templates_cat_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('templates_category', array('templates_cat_id' => $id, 'templates_cat_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);

			if ($this->session->level=='1'){
					cek_session_akses('produks_cat',$this->session->id_session);
					$data['home_stat']   = '';
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('produks_cat',$this->session->id_session);
					$data['home_stat']   = '';
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}else{
					cek_session_akses_staff('produks_cat',$this->session->id_session);
					$data['home_stat']   = '';
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}
			$this->load->view('backend/templates_cat/v_update', $data);
		}
	}
	public function produks_cat_delete_temp()
	{
		if ($this->session->level=='1'){
				cek_session_akses('produks_cat',$this->session->id_session);
				$data = array('templates_cat_status'=>'delete');
				$where = array('templates_cat_id' => $this->uri->segment(3));
				$this->db->update('templates_category', $data, $where);
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('produks_cat',$this->session->id_session);
				$data = array('templates_cat_status'=>'delete');
				$where = array('templates_cat_id' => $this->uri->segment(3));
				$this->db->update('templates_category', $data, $where);
			}else{
				cek_session_akses_staff('produks_cat',$this->session->id_session);
				$data = array('templates_cat_status'=>'delete');
				$where = array('templates_cat_id' => $this->uri->segment(3));
				$this->db->update('templates_category', $data, $where);
			}
			redirect('aspanel/produks_cat');
	}
	public function produks_cat_restore()
	{
		if ($this->session->level=='1'){
				cek_session_akses('produks_cat',$this->session->id_session);
				$data = array('templates_cat_status'=>'Publish');
				$where = array('templates_cat_id' => $this->uri->segment(3));
				$this->db->update('templates_category', $data, $where);
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('produks_cat',$this->session->id_session);
				$data = array('templates_cat_status'=>'Publish');
				$where = array('templates_cat_id' => $this->uri->segment(3));
				$this->db->update('templates_category', $data, $where);
			}else{
				cek_session_akses_staff('produks_cat',$this->session->id_session);
				$data = array('templates_cat_status'=>'Publish');
				$where = array('templates_cat_id' => $this->uri->segment(3));
				$this->db->update('templates_category', $data, $where);
			}
			redirect('aspanel/produks_cat_storage_bin');
	}
	public function produks_cat_delete()
	{
		if ($this->session->level=='1'){
				cek_session_akses('produks_cat',$this->session->id_session);
				$id = $this->uri->segment(3);
				$_id = $this->db->get_where('templates_category',['templates_cat_id' => $id])->row();
				 $query = $this->db->delete('templates_category',['templates_cat_id'=>$id]);
				if($query){
								 unlink("./bahan/foto_templates/".$_id->templates_cat_gambar);
			 }
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('produks_cat',$this->session->id_session);
				$id = $this->uri->segment(3);
				$_id = $this->db->get_where('templates_category',['templates_cat_id' => $id])->row();
				 $query = $this->db->delete('templates_category',['templates_cat_id'=>$id]);
				if($query){
								 unlink("./bahan/foto_templates/".$_id->templates_cat_gambar);
			 }
			}else{
				cek_session_akses_staff('produks_cat',$this->session->id_session);
			}
		redirect('aspanel/produks_cat_storage_bin');
	}
	/*	Bagian untuk Produks Category - Penutup	*/

	/*	Bagian untuk Product - Pembuka	*/
	public function produks()
	{
		 		$data['home_stat']   = '';
				if ($this->session->level=='1'){
					cek_session_akses('produks',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_join_where_ordering('templates','templates_category','templates_cat_id',array('templates_status'=>'publish'),'templates_id','desc');
					}elseif ($this->session->level=='2'){
						cek_session_akses_admin('produks',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_join_where_ordering('templates','templates_category','templates_cat_id',array('templates_status'=>'publish'),'templates_id','desc');
					}else{
						cek_session_akses_staff('produks',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_join_where_ordering('templates','templates_category','templates_cat_id',array('templates_post_oleh'=>$this->session->username,'templates_status'=>'publish'),'templates_id','desc');

					}

				$this->load->view('backend/templates/v_daftar', $data);
	}
	public function produks_storage_bin()
	{
				$data['home_stat']   = '';
				if ($this->session->level=='1'){
					cek_session_akses('produks',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('templates',array('templates_status'=>'delete'),'templates_id','DESC');
					}elseif ($this->session->level=='2'){
						cek_session_akses_admin('produks',$this->session->id_session);
						$data['record'] = $this->Crud_m->view_where_ordering('templates',array('templates_post_oleh'=>$this->session->username,'templates_status'=>'delete'),'templates_id','DESC');
					}else{
						cek_session_akses_staff('produks',$this->session->id_session);
						redirect('aspanel/home');
					}
				$this->load->view('backend/templates/v_daftar_hapus', $data);
	}
	public function produks_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'assets/frontend/produk/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';

					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/produk/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['new_image']= './assets/frontend/produk/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('templates_keyword')!=''){
								$tag_seo = $this->input->post('templates_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('templates_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']=='' ){
									$data = array(
													'templates_post_oleh'=>$this->session->username,
													'templates_judul'=>$this->db->escape_str($this->input->post('templates_judul')),
													'templates_judul_seo'=>$this->mylibrary->seo_title($this->input->post('templates_judul')),
													'templates_desk'=>$this->input->post('templates_desk'),
													'templates_harga'=>$this->input->post('templates_harga'),
													'templates_harga_diskon'=>$this->input->post('templates_harga_diskon'),
													'templates_url'=>$this->input->post('templates_url'),
													'templates_url_tokped'=>$this->input->post('templates_url_tokped'),
													'templates_cat_id'=>$this->input->post('templates_cat_id'),
													'templates_post_hari'=>hari_ini(date('w')),
													'templates_post_tanggal'=>date('Y-m-d'),
													'templates_post_jam'=>date('H:i:s'),
													'templates_dibaca'=>'0',
													'templates_status'=>'publish',
													'templates_meta_desk'=>$this->input->post('templates_meta_desk'),
													'templates_keyword'=>$tag);

												}else {
												$data = array(
													'templates_post_oleh'=>$this->session->username,
													'templates_judul'=>$this->db->escape_str($this->input->post('templates_judul')),
													'templates_judul_seo'=>$this->mylibrary->seo_title($this->input->post('templates_judul')),
													'templates_desk'=>$this->input->post('templates_desk'),
													'templates_harga'=>$this->input->post('templates_harga'),
													'templates_harga_diskon'=>$this->input->post('templates_harga_diskon'),
													'templates_url'=>$this->input->post('templates_url'),
													'templates_url_tokped'=>$this->input->post('templates_url_tokped'),
													'templates_cat_id'=>$this->input->post('templates_cat_id'),
													'templates_post_hari'=>hari_ini(date('w')),
													'templates_post_tanggal'=>date('Y-m-d'),
													'templates_post_jam'=>date('H:i:s'),
													'templates_dibaca'=>'0',
													'templates_status'=>'publish',
													'templates_gambar'=>$hasil22['file_name'],
													'templates_meta_desk'=>$this->input->post('templates_meta_desk'),
													'templates_keyword'=>$tag);
												}
								$this->As_m->insert('templates',$data);
								redirect('aspanel/produks');
				}else{
					if ($this->session->level=='1'){
							cek_session_akses('produks',$this->session->id_session);
							$data['home_stat']   = '';
							$data['records'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'Publish'),'templates_cat_id','DESC');
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}elseif ($this->session->level=='2'){
							cek_session_akses_admin('produks',$this->session->id_session);
							$data['home_stat']   = '';
							$data['records'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'Publish'),'templates_cat_id','DESC');
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}else{
							cek_session_akses_staff('produks',$this->session->id_session);
							$data['home_stat']   = '';
							$data['records'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'Publish'),'templates_cat_id','DESC');
							$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
						}
					$this->load->view('backend/templates/v_tambahkan', $data);
				}
	}
	public function produks_update()
	{
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
			$config['upload_path'] = 'assets/frontend/produk/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/produk/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['new_image']= './assets/frontend/produk/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('templates_keyword')!=''){
						$tag_seo = $this->input->post('templates_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('templates_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'templates_update_oleh'=>$this->session->username,
											'templates_judul'=>$this->db->escape_str($this->input->post('templates_judul')),
											'templates_judul_seo'=>$this->mylibrary->seo_title($this->input->post('templates_judul')),
											'templates_desk'=>$this->input->post('templates_desk'),
											'templates_harga'=>$this->input->post('templates_harga'),
											'templates_harga_diskon'=>$this->input->post('templates_harga_diskon'),
											'templates_url'=>$this->input->post('templates_url'),
											'templates_url_tokped'=>$this->input->post('templates_url_tokped'),
											'templates_cat_id'=>$this->input->post('templates_cat_id'),
											'templates_update_hari'=>hari_ini(date('w')),
											'templates_update_tanggal'=>date('Y-m-d'),
											'templates_update_jam'=>date('H:i:s'),
											'templates_meta_desk'=>$this->input->post('templates_meta_desk'),
											'templates_keyword'=>$tag);
											$where = array('templates_id' => $this->input->post('templates_id'));
							 				$this->db->update('templates', $data, $where);
						}else{
										$data = array(
											'templates_update_oleh'=>$this->session->username,
											'templates_judul'=>$this->db->escape_str($this->input->post('templates_judul')),
											'templates_judul_seo'=>$this->mylibrary->seo_title($this->input->post('templates_judul')),
											'templates_desk'=>$this->input->post('templates_desk'),
											'templates_harga'=>$this->input->post('templates_harga'),
											'templates_harga_diskon'=>$this->input->post('templates_harga_diskon'),
											'templates_url'=>$this->input->post('templates_url'),
											'templates_url_tokped'=>$this->input->post('templates_url_tokped'),
											'templates_cat_id'=>$this->input->post('templates_cat_id'),
											'templates_update_hari'=>hari_ini(date('w')),
											'templates_update_tanggal'=>date('Y-m-d'),
											'templates_update_jam'=>date('H:i:s'),
											'templates_gambar'=>$hasil22['file_name'],
											'templates_meta_desk'=>$this->input->post('templates_meta_desk'),
											'templates_keyword'=>$tag);
											$where = array('templates_id' => $this->input->post('templates_id'));
											$_image = $this->db->get_where('templates',$where)->row();
											$query = $this->db->update('templates',$data,$where);
											if($query){
												unlink("assets/frontend/produk/".$_image->templates_gambar);
											}
						}
						redirect('aspanel/produks');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('templates', array('templates_judul_seo' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('templates', array('templates_judul_seo' => $id, 'templates_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			if ($this->session->level=='1'){
					cek_session_akses('produks',$this->session->id_session);
					$data['home_stat']   = '';
					$data['records'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'Publish'),'templates_cat_id','DESC');
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('produks',$this->session->id_session);
					$data['home_stat']   = '';
					$data['records'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'Publish'),'templates_cat_id','DESC');
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}else{
					cek_session_akses_staff('produks',$this->session->id_session);
					$data['home_stat']   = '';
					$data['records'] = $this->Crud_m->view_where_ordering('templates_category',array('templates_cat_status'=>'Publish'),'templates_cat_id','DESC');
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
				}
			$this->load->view('backend/templates/v_update', $data);
		}
	}
	public function produks_delete_temp()
	{

			if ($this->session->level=='1'){
					cek_session_akses('produks',$this->session->id_session);
					$data = array('templates_status'=>'delete');
		      $where = array('templates_id' => $this->uri->segment(3));
					$this->db->update('templates', $data, $where);
				}elseif ($this->session->level=='2'){
					cek_session_akses_admin('produks',$this->session->id_session);
					$data = array('templates_status'=>'delete');
		      $where = array('templates_id' => $this->uri->segment(3));
					$this->db->update('templates', $data, $where);
				}else{
					cek_session_akses_staff('produks',$this->session->id_session);
					$data = array('templates_status'=>'delete');
		      $where = array('templates_id' => $this->uri->segment(3));
					$this->db->update('templates', $data, $where);
				}
			redirect('aspanel/produks');
	}
	public function produks_restore()
	{
		if ($this->session->level=='1'){
				cek_session_akses('produks',$this->session->id_session);
				$data = array('templates_status'=>'Publish');
	      $where = array('templates_id' => $this->uri->segment(3));
				$this->db->update('templates', $data, $where);
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('produks',$this->session->id_session);
				$data = array('templates_status'=>'Publish');
	      $where = array('templates_id' => $this->uri->segment(3));
				$this->db->update('templates', $data, $where);
			}else{
				cek_session_akses_staff('produks',$this->session->id_session);
				$data = array('templates_status'=>'Publish');
	      $where = array('templates_id' => $this->uri->segment(3));
				$this->db->update('templates', $data, $where);
			}
			redirect('aspanel/produks_storage_bin');
	}
	public function produks_delete()
	{
		if ($this->session->level=='1'){
				cek_session_akses('produks',$this->session->id_session);
				$id = $this->uri->segment(3);
				$_id = $this->db->get_where('templates',['templates_id' => $id])->row();
				 $query = $this->db->delete('templates',['templates_id'=>$id]);
			 	if($query){
								 unlink("./assets/frontend/produk/".$_id->templates_gambar);
			 			 }
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('produks',$this->session->id_session);
				$id = $this->uri->segment(3);
				$_id = $this->db->get_where('templates',['templates_id' => $id])->row();
				 $query = $this->db->delete('templates',['templates_id'=>$id]);
			 	if($query){
								 unlink("./assets/frontend/produk/".$_id->templates_gambar);
			 			 }
			}else{
				cek_session_akses_staff('produks',$this->session->id_session);
			}
			redirect('aspanel/produks_storage_bin');
	}

	/*	Bagian untuk Product - Penutup	*/


	/*	Bagian untuk Dat Karyawan - Pembuka	*/
	public function data_karyawan()
	{
		$data['home_stat']   = '';
		if ($this->session->level=='1'){
			cek_session_akses('data_karyawan',$this->session->id_session);
			$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'publish'),'id_user','DESC');
			}elseif ($this->session->level=='2'){
				cek_session_akses_admin('data_karyawan',$this->session->id_session);
				$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'publish','level'=>'3'),'id_user','DESC');
			}else{
				redirect('aspanel/home');
			}
			$this->load->view('backend/data_karyawan/v_daftar', $data);
	}
	public function data_karyawan_storage_bin()
	{
		$data['karyawan_menu_open']   = 'menu-open';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = 'active';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = 'active';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';

			if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'delete'),'id_user','DESC');
				}elseif($this->session->level=='2'){
					$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'delete'),'id_user','DESC');
				}else{
					redirect('aspanel/home');
				}
			cek_session_akses('data_karyawan',$this->session->id_session);
			$this->load->view('backend/data_karyawan/v_daftar_hapus', $data);
	}
	public function data_karyawan_tambahkan()
	{

		if (isset($_POST['submit'])){

					$config['upload_path'] = 'bahan/foto_karyawan/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';

					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './bahan/foto_karyawan/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['width']= 800;
					$config['height']= 800;
					$config['new_image']= './bahan/foto_karyawan/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();


												if ($hasil22['file_name']==''){

												$data = array(
													'username' => $this->input->post('username'),
													'email' => $this->input->post('email'),
													'password' => sha1($this->input->post('password')),
													'user_status' => '1',
													'level' => $this->input->post('user_status'),
													'user_stat' => 'publish',
													'user_post_hari'=>hari_ini(date('w')),
													'user_post_tanggal'=>date('Y-m-d'),
													'user_post_jam'=>date('H:i:s'),
													'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
													'nama' => $this->input->post('nama'));
												}else {
												$data = array(
													'username' => $this->input->post('username'),
													'email' => $this->input->post('email'),
													'password' => sha1($this->input->post('password')),
													'user_status' => '1',
													'level' => $this->input->post('user_status'),
													'user_stat' => 'publish',
													'user_post_hari'=>hari_ini(date('w')),
													'user_post_tanggal'=>date('Y-m-d'),
													'user_post_jam'=>date('H:i:s'),
													'user_gambar'=>$hasil22['file_name'],
													'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
													'nama' => $this->input->post('nama'));
												}
											$id_pelanggan = $this->Crud_m->tambah_user($data);
											$data_user_detail = array(
													'id_user' => $id_pelanggan,
													'user_detail_jekel' => $this->input->post('user_detail_jekel'),
													'user_detail_agama' => $this->input->post('user_detail_agama'),
													'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
													'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
													'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
													'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
													'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
													'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
													'user_detail_divisi' => $this->input->post('user_detail_divisi'),
													'user_detail_ktp' => $this->input->post('user_detail_ktp'));
											$this->Crud_m->tambah_user_detail($data_user_detail);
											redirect('aspanel/data_karyawan');
				}else{
					$data['karyawan_menu_open']   = 'menu-open';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = 'active';
					$data['templates_stat']   = '';
					$data['cat_templates_stat']   = 'active';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

					$data['produk_menu_open']   = '';
		 			$data['produk_category']   = '';
		 			$data['produk']   = '';
		 			$data['services']   = '';

					if ($this->session->level=='1'){
						$data['records'] = $this->Crud_m->view_ordering('user_level','user_level_id','DESC');
						$data['records_divisi'] = $this->Crud_m->view_ordering('divisi','divisi_id','DESC');
						$data['records_kel'] = $this->Crud_m->view_ordering('user_kelamin','user_kelamin_id','DESC');
						$data['records_agama'] = $this->Crud_m->view_ordering('user_agama','user_agama_id','ASC');
						$data['records_kawin'] = $this->Crud_m->view_ordering('user_perkawinan','user_perkawinan_id','ASC');

						$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'delete'),'id_user','DESC');
						}elseif($this->session->level=='2'){
							$data['records'] = $this->Crud_m->view_where_ordering('user_level',array('user_level_id'=>'3'),'user_level_id','DESC');
							$data['records_divisi'] = $this->Crud_m->view_ordering('divisi','divisi_id','DESC');
							$data['records_kel'] = $this->Crud_m->view_ordering('user_kelamin','user_kelamin_id','DESC');
							$data['records_agama'] = $this->Crud_m->view_ordering('user_agama','user_agama_id','ASC');
							$data['records_kawin'] = $this->Crud_m->view_ordering('user_perkawinan','user_perkawinan_id','ASC');
							$data['record'] = $this->Crud_m->view_join_where2_ordering('user','user_level','level','user_level_id',array('user_stat'=>'delete'),'id_user','DESC');
						}else{
							redirect('aspanel/home');
						}
						cek_session_akses('data_karyawan',$this->session->id_session);
					$this->load->view('backend/data_karyawan/v_tambahkan', $data);
				}
	}
	public function data_karyawan_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'bahan/foto_karyawan/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './bahan/foto_karyawan/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['width']= 800;
			$config['height']= 800;
			$config['new_image']= './bahan/foto_karyawan/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			$pass = sha1($this->input->post('password'));


						if ($hasil22['file_name']=='' AND $this->input->post('password')==''){
							$data = array(
								'username' => $this->input->post('username'),
								'email' => $this->input->post('email'),
								'level' => $this->input->post('user_status'),
								'user_update_hari'=>hari_ini(date('w')),
								'user_update_tanggal'=>date('Y-m-d'),
								'user_update_jam'=>date('H:i:s'),
								'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
								'nama' => $this->input->post('nama'));


							$data2 = array(
							'id_user' => $this->input->post('id_user'),
							'user_detail_jekel' => $this->input->post('user_detail_jekel'),
							'user_detail_agama' => $this->input->post('user_detail_agama'),
							'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
							'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
							'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
							'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
							'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
							'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
							'user_detail_divisi' => $this->input->post('user_detail_divisi'),
							'user_detail_ktp' => $this->input->post('user_detail_ktp'));

							$where = array('id_user' => $this->input->post('id_user'));
							$id = $this->db->update('user',$data,$where);
							$id2 = $this->db->update('user_detail',$data2,$where);


						}else if($this->input->post('password')==''){
								$data = array(
									'username' => $this->input->post('username'),
									'email' => $this->input->post('email'),
									'level' => $this->input->post('user_status'),
									'user_update_hari'=>hari_ini(date('w')),
									'user_update_tanggal'=>date('Y-m-d'),
									'user_update_jam'=>date('H:i:s'),
									'user_gambar'=>$hasil22['file_name'],
									'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
									'nama' => $this->input->post('nama'));


								$data2 = array(
								'id_user' => $this->input->post('id_user'),
								'user_detail_jekel' => $this->input->post('user_detail_jekel'),
								'user_detail_agama' => $this->input->post('user_detail_agama'),
								'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
								'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
								'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
								'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
								'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
								'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
								'user_detail_divisi' => $this->input->post('user_detail_divisi'),
								'user_detail_ktp' => $this->input->post('user_detail_ktp'));

								$where = array('id_user' => $this->input->post('id_user'));
								$_image = $this->db->get_where('user',$where)->row();
								$id2 = $this->db->update('user_detail',$data2,$where);
								$query = $this->db->update('user',$data,$where);
								if($query){
									unlink("bahan/foto_karyawan/".$_image->user_gambar);
								}

							}else if($hasil22['file_name']==''){
									$data = array(
										'username' => $this->input->post('username'),
										'email' => $this->input->post('email'),
										'password' => $pass,
										'level' => $this->input->post('user_status'),
										'user_update_hari'=>hari_ini(date('w')),
										'user_update_tanggal'=>date('Y-m-d'),
										'user_update_jam'=>date('H:i:s'),
										'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
										'nama' => $this->input->post('nama'));


									$data2 = array(
									'id_user' => $this->input->post('id_user'),
									'user_detail_jekel' => $this->input->post('user_detail_jekel'),
									'user_detail_agama' => $this->input->post('user_detail_agama'),
									'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
									'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
									'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
									'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
									'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
									'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
									'user_detail_divisi' => $this->input->post('user_detail_divisi'),
									'user_detail_ktp' => $this->input->post('user_detail_ktp'));

									$where = array('id_user' => $this->input->post('id_user'));
									$id = $this->db->update('user',$data,$where);
									$id2 = $this->db->update('user_detail',$data2,$where);


								}else{
							$data = array(
								'username' => $this->input->post('username'),
								'email' => $this->input->post('email'),
								'password' => sha1($this->input->post('password')),
								'level' => $this->input->post('user_status'),
								'user_update_hari'=>hari_ini(date('w')),
								'user_update_tanggal'=>date('Y-m-d'),
								'user_update_jam'=>date('H:i:s'),
								'user_gambar'=>$hasil22['file_name'],
								'id_session'=>md5($this->input->post('email')).'-'.date('YmdHis'),
								'nama' => $this->input->post('nama'));

								$data2 = array(
								'id_user' => $this->input->post('id_user'),
								'user_detail_jekel' => $this->input->post('user_detail_jekel'),
								'user_detail_agama' => $this->input->post('user_detail_agama'),
								'user_detail_tempatlahir' => $this->input->post('user_detail_tempatlahir'),
								'user_detail_tgllahir' => $this->input->post('user_detail_tgllahir'),
								'user_detail_perkawinan' => $this->input->post('user_detail_perkawinan'),
								'user_detail_pendidikan' => $this->input->post('user_detail_pendidikan'),
								'user_detail_tempattinggal' => $this->input->post('user_detail_tempattinggal'),
								'user_detail_no_telp' => $this->input->post('user_detail_no_telp'),
								'user_detail_divisi' => $this->input->post('user_detail_divisi'),
								'user_detail_ktp' => $this->input->post('user_detail_ktp'));

								$where = array('id_user' => $this->input->post('id_user'));
								$_image = $this->db->get_where('user',$where)->row();

								$id2 = $this->db->update('user_detail',$data2,$where);
								$query = $this->db->update('user',$data,$where);
								if($query){
									unlink("bahan/foto_karyawan/".$_image->user_gambar);
								}
							}
						redirect('aspanel/data_karyawan');
		}else{
			if ($this->session->level=='1'){
						 $proses = $this->Crud_m->view_join_where2('user','user_detail','id_user',array('id_session' => $id))->row_array();
				}else{
						$proses = $this->Crud_m->view_join_where2('user','user_detail','id_user',array('id_session' => $id))->row_array();
				}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = 'menu-open';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = 'active';
			$data['templates_stat']   = '';
			$data['cat_templates_stat']   = 'active';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';

			$data['produk_menu_open']   = '';
 			$data['produk_category']   = '';
 			$data['produk']   = '';
 			$data['services']   = '';

			$data['records'] = $this->Crud_m->view_ordering('user_level','user_level_id','DESC');
			$data['records_divisi'] = $this->Crud_m->view_ordering('divisi','divisi_id','DESC');
			$data['records_kel'] = $this->Crud_m->view_ordering('user_kelamin','user_kelamin_id','DESC');
			$data['records_agama'] = $this->Crud_m->view_ordering('user_agama','user_agama_id','ASC');
			$data['records_kawin'] = $this->Crud_m->view_ordering('user_perkawinan','user_perkawinan_id','ASC');
			cek_session_akses('data_karyawan',$this->session->id_session);
			$this->load->view('backend/data_karyawan/v_update', $data);
		}
	}
	function data_karyawan_delete_temp()
	{
			cek_session_akses('data_karyawan',$this->session->id_session);
			$data = array('user_stat'=>'delete');
			$where = array('id_user' => $this->uri->segment(3));
			$this->db->update('user', $data, $where);
			redirect('aspanel/data_karyawan');
	}
	function data_karyawan_restore()
	{
			cek_session_akses('data_karyawan',$this->session->id_session);
			$data = array('user_stat'=>'Publish');
			$where = array('id_user' => $this->uri->segment(3));
			$this->db->update('user', $data, $where);
			redirect('aspanel/data_karyawan_storage_bin');
	}
	public function data_karyawan_delete()
	{
			cek_session_akses('data_karyawan',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('user',['id_user' => $id])->row();
			$query = $this->db->delete('user',['id_user'=> $id]);
			$_id2 = $this->db->get_where('user_detail',['id_user' => $id])->row();
			$query2 = $this->db->delete('user_detail',['id_user'=> $id]);
			if($query){
							 unlink("./bahan/foto_karyawan/".$_id->user_gambar);
		 }
		redirect('aspanel/data_karyawan_storage_bin');
	}
	/*	Bagian untuk Data Karyawan - Penutup	*/





	/*	Bagian untuk templates cat - Pembuka	*/
	public function services()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = 'active';
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('services',array('services_status'=>'publish'),'services_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('services',array('services_post_oleh'=>$this->session->username,'services_status'=>'publish'),'services_id','DESC');
				}
				$this->load->view('backend/services/v_daftar', $data);
	}
	public function services_storage_bin()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = 'menu-open';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = 'active';
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('services',array('services_status'=>'delete'),'services_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('services',array('services_post_oleh'=>$this->session->username,'servicest_status'=>'delete'),'services_id','DESC');
				}
				$this->load->view('backend/services/v_daftar_hapus', $data);
	}
	public function services_tambahkan()
	{
		if (isset($_POST['submit'])){

					$config['upload_path'] = 'bahan/foto_templates/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './bahan/foto_templates/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['quality']= '80%';
					$config['new_image']= './bahan/foto_templates/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('services_keyword')!=''){
								$tag_seo = $this->input->post('services_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('services_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
													'services_post_oleh'=>$this->session->username,
													'services_judul'=>$this->db->escape_str($this->input->post('services_judul')),
													'services_judul_seo'=>$this->mylibrary->seo_title($this->input->post('services_judul')),
													'services_judul_konten'=>$this->db->escape_str($this->input->post('services_judul_konten')),
													'paketharga_id'=>$this->input->post('paketharga_id'),
													'services_desk'=>$this->input->post('services_desk'),
													'services_post_hari'=>hari_ini(date('w')),
													'services_post_tanggal'=>date('Y-m-d'),
													'services_post_jam'=>date('H:i:s'),
													'services_dibaca'=>'0',
													'services_status'=>'publish',
													'services_meta_desk'=>$this->input->post('services_meta_desk'),
													'services_keyword'=>$tag);
											}else{
												$data = array(
													'services_post_oleh'=>$this->session->username,
													'services_judul'=>$this->db->escape_str($this->input->post('services_judul')),
													'services_judul_seo'=>$this->mylibrary->seo_title($this->input->post('services_judul')),
													'services_judul_konten'=>$this->db->escape_str($this->input->post('services_judul_konten')),
													'paketharga_id'=>$this->input->post('paketharga_id'),
													'services_desk'=>$this->input->post('services_desk'),
													'services_post_hari'=>hari_ini(date('w')),
													'services_post_tanggal'=>date('Y-m-d'),
													'services_post_jam'=>date('H:i:s'),
													'services_dibaca'=>'0',
													'services_status'=>'publish',
													'services_gambar'=>$hasil22['file_name'],
													'services_meta_desk'=>$this->input->post('services_meta_desk'),
													'services_keyword'=>$tag);
												}
								$this->As_m->insert('services',$data);
								redirect('aspanel/services');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['templates_stat']   = '';
					$data['cat_templates_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['message_stat']   = '';
					$data['gallery_stat']   = '';
					$data['kehadiran_menu_open']   = '';
					$data['jamkerja_stat']   = '';
					$data['absen_stat']   = '';
					$data['dataabsen_stat']   = '';
					$data['cuti_stat']   = '';
					$data['gaji_stat']   = '';
					$data['pengumuman_stat']   = '';
					$data['konfig_stat']   = '';
					$data['produk_menu_open']   = 'menu-open';
					$data['produk_category']   = '';
					$data['produk']   = '';
					$data['services']   = 'active';
					$data['records'] = $this->Crud_m->view_ordering('paketharga','paketharga_id','DESC');
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/services/v_tambahkan', $data);
				}
	}
	public function services_update()
	{
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'bahan/foto_templates/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './bahan/foto_templates/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['quality']= '80%';
			$config['new_image']= './bahan/foto_templates/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('services_keyword')!=''){
						$tag_seo = $this->input->post('services_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('services_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'services_update_oleh'=>$this->session->username,
											'services_judul'=>$this->db->escape_str($this->input->post('services_judul')),
											'services_judul_seo'=>$this->mylibrary->seo_title($this->input->post('services_judul')),
											'services_judul_konten'=>$this->db->escape_str($this->input->post('services_judul_konten')),
											'paketharga_id'=>$this->input->post('paketharga_id'),
											'services_desk'=>$this->input->post('services_desk'),
											'services_update_hari'=>hari_ini(date('w')),
											'services_update_tanggal'=>date('Y-m-d'),
											'services_update_jam'=>date('H:i:s'),
											'services_meta_desk'=>$this->input->post('services_meta_desk'),
											'services_keyword'=>$tag);
											$where = array('services_id' => $this->input->post('services_id'));
											$this->db->update('services', $data, $where);
						}else{
										$data = array(
											'services_update_oleh'=>$this->session->username,
											'services_judul'=>$this->db->escape_str($this->input->post('services_judul')),
											'services_judul_seo'=>$this->mylibrary->seo_title($this->input->post('services_judul')),
											'services_judul_konten'=>$this->db->escape_str($this->input->post('services_judul_konten')),
											'paketharga_id'=>$this->input->post('paketharga_id'),
											'services_desk'=>$this->input->post('services_desk'),
											'services_update_hari'=>hari_ini(date('w')),
											'services_update_tanggal'=>date('Y-m-d'),
											'services_update_jam'=>date('H:i:s'),
											'services_gambar'=>$hasil22['file_name'],
											'services_meta_desk'=>$this->input->post('services_meta_desk'),
											'services_keyword'=>$tag);
											$where = array('services_id' => $this->input->post('services_id'));
											$_image = $this->db->get_where('services',$where)->row();
											$query = $this->db->update('services',$data,$where);
											if($query){
												unlink("bahan/foto_templates/".$_image->services_gambar);
											}

						}
						redirect('aspanel/services');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('services', array('services_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('services', array('services_id' => $id, 'services_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['templates_stat']   = '';
			$data['cat_templates_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['kehadiran_menu_open']   = '';
				$data['jamkerja_stat']   = '';
				$data['absen_stat']   = '';
				$data['dataabsen_stat']   = '';
				$data['cuti_stat']   = '';
				$data['gaji_stat']   = '';
				$data['pengumuman_stat']   = '';
				$data['konfig_stat']   = '';
				$data['produk_menu_open']   = 'menu-open';
				$data['produk_category']   = '';
				$data['produk']   = '';
				$data['services']   = 'active';
			$data['records'] = $this->Crud_m->view_ordering('paketharga','paketharga_id','DESC');
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/services/v_update', $data);
		}
	}
	function services_delete_temp()
	{
			$data = array('services_status'=>'delete');
			$where = array('services_id' => $this->uri->segment(3));
			$this->db->update('services', $data, $where);
			redirect('aspanel/services');
	}
	function services_restore()
	{
			$data = array('services_status'=>'Publish');
			$where = array('services_id' => $this->uri->segment(3));
			$this->db->update('services', $data, $where);
			redirect('aspanel/services_storage_bin');
	}
	public function services_delete()
	{
			cek_session_akses ('services',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('services',['services_id' => $id])->row();
			 $query = $this->db->delete('services',['services_id'=>$id]);
			if($query){
							 unlink("./bahan/foto_templates/".$_id->paketharga_gambar);
		 }
		redirect('aspanel/services_storage_bin');
	}
	/*	Bagian untuk Product Category - Penutup	*/



	/*	Bagian untuk Divisi - Pembuka	*/
	public function divisi()
	{
		$data['karyawan_menu_open']   = 'menu-open';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = 'active';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = 'active';
		$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';

				if ($this->session->level=='1'){
					cek_session_akses('divisi',$this->session->id_session);
					$data['record'] = $this->Crud_m->view_where_ordering('divisi',array('divisi_status'=>'publish'),'divisi_id','DESC');
					}else{
					}

				$this->load->view('backend/divisi/v_daftar', $data);
	}
	public function divisi_storage_bin()
	{
		$data['karyawan_menu_open']   = 'menu-open';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = 'active';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = '';
		$data['message_stat']   = 'active';
		$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';
		cek_session_akses ('divisi',$this->session->id_session);
				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('divisi',array('divisi_status'=>'delete'),'divisi_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('divisi',array('divisi_post_oleh'=>$this->session->username,'divisi_status'=>'delete'),'divisi_id','DESC');
				}
				$this->load->view('backend/divisi/v_daftar_hapus', $data);
	}
	public function divisi_tambahkan()
	{
		cek_session_akses('divisi',$this->session->id_session);
		if (isset($_POST['submit'])){

									$data = array(
													'divisi_post_oleh'=>$this->session->username,
													'divisi_judul'=>$this->db->escape_str($this->input->post('divisi_judul')),
													'divisi_judul_seo'=>$this->mylibrary->seo_title($this->input->post('divisi_judul')),
													'divisi_desk'=>$this->input->post('divisi_desk'),
													'divisi_post_hari'=>hari_ini(date('w')),
													'divisi_post_tanggal'=>date('Y-m-d'),
													'divisi_post_jam'=>date('H:i:s'),
													'divisi_dibaca'=>'0',
													'divisi_status'=>'publish',
													'divisi_meta_desk'=>$this->input->post('divisi_meta_desk'));

								$this->As_m->insert('divisi',$data);
								redirect('aspanel/divisi');
				}else{
					$data['karyawan_menu_open']   = 'menu-open';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['templates_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = '';
					$data['cat_templates_stat']   = 'active';
					$data['message_stat']   = 'active';
					$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
					$data['produk_menu_open']   = '';
		 			$data['produk_category']   = '';
		 			$data['produk']   = '';
		 			$data['services']   = '';
					cek_session_akses ('divisi',$this->session->id_session);
					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/divisi/v_tambahkan', $data);
				}
	}
	public function divisi_update()
	{
		cek_session_akses('divisi',$this->session->id_session);
		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){
										$data = array(
											'divisi_update_oleh'=>$this->session->username,
											'divisi_judul'=>$this->db->escape_str($this->input->post('divisi_judul')),
											'divisi_judul_seo'=>$this->mylibrary->seo_title($this->input->post('divisi_judul')),
											'divisi_desk'=>$this->input->post('divisi_desk'),
											'divisi_update_hari'=>hari_ini(date('w')),
											'divisi_update_tanggal'=>date('Y-m-d'),
											'divisi_update_jam'=>date('H:i:s'),
											'divisi_meta_desk'=>$this->input->post('divisi_meta_desk'));
											$where = array('divisi_id' => $this->input->post('divisi_id'));
							 				$this->db->update('divisi', $data, $where);

						redirect('aspanel/divisi');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('divisi', array('divisi_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('divisi', array('divisi_id' => $id, 'divisi_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = 'menu-open';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['templates_stat']   = '';
			$data['cat_templates_stat']   = 'active';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = '';
			$data['message_stat']   = 'active';
			$data['gallery_stat']   = ''; 		$data['kehadiran_menu_open']   = ''; 	    $data['jamkerja_stat']   = ''; 	    $data['absen_stat']   = ''; 	    $data['dataabsen_stat']   = ''; 	    $data['cuti_stat']   = ''; 	    $data['gaji_stat']   = ''; 	    $data['pengumuman_stat']   = ''; 	    $data['konfig_stat']   = '';
			$data['produk_menu_open']   = '';
 			$data['produk_category']   = '';
 			$data['produk']   = '';
 			$data['services']   = '';
			cek_session_akses ('divisi',$this->session->id_session);
			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/divisi/v_update', $data);
		}
	}
	function divisi_delete_temp()
	{
      cek_session_akses ('divisi',$this->session->id_session);
			$data = array('divisi_status'=>'delete');
      $where = array('divisi_id' => $this->uri->segment(3));
			$this->db->update('divisi', $data, $where);
			redirect('aspanel/divisi');
	}
	function divisi_restore()
	{
      cek_session_akses ('divisi',$this->session->id_session);
			$data = array('divisi_status'=>'Publish');
      $where = array('divisi_id' => $this->uri->segment(3));
			$this->db->update('divisi', $data, $where);
			redirect('aspanel/divisi_storage_bin');
	}
	public function divisi_delete()
	{
			cek_session_akses ('divisi',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('divisi',['divisi_id' => $id])->row();
			 $query = $this->db->delete('divisi',['divisi_id'=>$id]);
		 	if($query){
							 unlink("./bahan/foto_templates/".$_id->divisi_gambar);
		 }
		redirect('aspanel/divisi_storage_bin');
	}
	/*	Bagian untuk Divisi - Penutup	*/

	/*	Bagian untuk Blogs - Pembuka	*/
	public function blogs()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = 'active';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
		$data['jamkerja_stat']   = '';
		$data['absen_stat']   = '';
		$data['dataabsen_stat']   = '';
		$data['cuti_stat']   = '';
		$data['gaji_stat']   = '';
		$data['pengumuman_stat']   = '';
		$data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_status'=>'publish'),'blogs_id','DESC');
				}elseif ($this->session->level=='2'){
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_status'=>'publish'),'blogs_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_post_oleh'=>$this->session->username,'blogs_status'=>'publish'),'blogs_id','DESC');
				}
				$this->load->view('backend/blogs/v_daftar', $data);
	}
	public function blogs_storage_bin()
	{
		$data['karyawan_menu_open']   = '';
		$data['home_stat']   = '';
		$data['identitas_stat']   = '';
		$data['profil_stat']   = '';
		$data['sliders_stat']   = '';
		$data['templates_stat']   = '';
		$data['cat_templates_stat']   = '';
		$data['slider_stat']   = '';
		$data['blogs_stat']   = 'active';
		$data['message_stat']   = '';
		$data['gallery_stat']   = '';
		$data['kehadiran_menu_open']   = '';
		$data['jamkerja_stat']   = '';
		$data['absen_stat']   = '';
		$data['dataabsen_stat']   = '';
		$data['cuti_stat']   = '';
		$data['gaji_stat']   = '';
		$data['pengumuman_stat']   = '';
		$data['konfig_stat']   = '';
		$data['produk_menu_open']   = '';
		$data['produk_category']   = '';
		$data['produk']   = '';
		$data['services']   = '';

				if ($this->session->level=='1'){
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_status'=>'delete'),'blogs_id','DESC');
				}else{
						$data['record'] = $this->Crud_m->view_where_ordering('blogs',array('blogs_post_oleh'=>$this->session->username,'blogs_status'=>'delete'),'blogs_id','DESC');
				}
				$this->load->view('backend/blogs/v_daftar_hapus', $data);
	}
	public function blogs_tambahkan()
	{

		if (isset($_POST['submit'])){

					$config['upload_path'] = 'assets/frontend/blogs/';
					$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
					$this->upload->initialize($config);
					$this->upload->do_upload('gambar');
					$hasil22=$this->upload->data();
					$config['image_library']='gd2';
					$config['source_image'] = './assets/frontend/blogs/'.$hasil22['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= FALSE;
					$config['new_image']= './assets/frontend/blogs/'.$hasil22['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					if ($this->input->post('blogs_keyword')!=''){
								$tag_seo = $this->input->post('blogs_keyword');
								$tag=implode(',',$tag_seo);
						}else{
								$tag = '';
						}
					$tag = $this->input->post('blogs_keyword');
					$tags = explode(",", $tag);
					$tags2 = array();
					foreach($tags as $t)
					{
						$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
						$a = $this->db->query($sql)->result_array();
						if(count($a) == 0){
							$data = array('keyword_nama'=>$this->db->escape_str($t),
									'keyword_username'=>$this->session->username,
									'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
									'count'=>'0');
							$this->As_m->insert('keyword',$data);
						}
						$tags2[] = $this->mylibrary->seo_title($t);
					}
					$tags = implode(",", $tags2);
					if ($hasil22['file_name']==''){
									$data = array(
													'blogs_post_oleh'=>$this->session->username,
													'blogs_judul'=>$this->db->escape_str($this->input->post('blogs_judul')),
													'blogs_judul_seo'=>$this->mylibrary->seo_title($this->input->post('blogs_judul')),
													'blogs_desk'=>$this->input->post('blogs_desk'),
													'blogs_post_hari'=>hari_ini(date('w')),
													'blogs_post_tanggal'=>date('Y-m-d'),
													'blogs_post_jam'=>date('H:i:s'),
													'blogs_dibaca'=>'0',
													'blogs_status'=>'publish',
													'blogs_meta_desk'=>$this->input->post('blogs_meta_desk'),
													'blogs_keyword'=>$tag);
											}else{
												$data = array(
													'blogs_post_oleh'=>$this->session->username,
													'blogs_judul'=>$this->db->escape_str($this->input->post('blogs_judul')),
													'blogs_judul_seo'=>$this->mylibrary->seo_title($this->input->post('blogs_judul')),
													'blogs_desk'=>$this->input->post('blogs_desk'),
													'blogs_post_hari'=>hari_ini(date('w')),
													'blogs_post_tanggal'=>date('Y-m-d'),
													'blogs_post_jam'=>date('H:i:s'),
													'blogs_dibaca'=>'0',
													'blogs_status'=>'publish',
													'blogs_gambar'=>$hasil22['file_name'],
													'blogs_meta_desk'=>$this->input->post('blogs_meta_desk'),
													'blogs_keyword'=>$tag);
												}
								$this->As_m->insert('blogs',$data);
								redirect('aspanel/blogs');
				}else{
					$data['karyawan_menu_open']   = '';
					$data['home_stat']   = '';
					$data['identitas_stat']   = '';
					$data['profil_stat']   = '';
					$data['sliders_stat']   = '';
					$data['templates_stat']   = '';
					$data['cat_templates_stat']   = '';
					$data['slider_stat']   = '';
					$data['blogs_stat']   = 'active';
					$data['message_stat']   = '';
					$data['gallery_stat']   = '';
					$data['kehadiran_menu_open']   = '';
					$data['jamkerja_stat']   = '';
					$data['absen_stat']   = '';
					$data['dataabsen_stat']   = '';
					$data['cuti_stat']   = '';
					$data['gaji_stat']   = '';
					$data['pengumuman_stat']   = '';
					$data['konfig_stat']   = '';
					$data['produk_menu_open']   = '';
					$data['produk_category']   = '';
					$data['produk']   = '';
					$data['services']   = '';

					$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
					$this->load->view('backend/blogs/v_tambahkan', $data);
				}
	}
	public function blogs_update()
	{

		$id = $this->uri->segment(3);
		if (isset($_POST['submit'])){

			$config['upload_path'] = 'assets/frontend/blogs/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
			$this->upload->initialize($config);
			$this->upload->do_upload('gambar');
			$hasil22=$this->upload->data();
			$config['image_library']='gd2';
			$config['source_image'] = './assets/frontend/blogs/'.$hasil22['file_name'];
			$config['create_thumb']= FALSE;
			$config['maintain_ratio']= FALSE;
			$config['new_image']= './assets/frontend/blogs/'.$hasil22['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			if ($this->input->post('blogs_keyword')!=''){
						$tag_seo = $this->input->post('blogs_keyword');
						$tag=implode(',',$tag_seo);
				}else{
						$tag = '';
				}
			$tag = $this->input->post('blogs_keyword');
			$tags = explode(",", $tag);
			$tags2 = array();
			foreach($tags as $t)
			{
				$sql = "select * from keyword where keyword_nama_seo = '" . $this->mylibrary->seo_title($t) . "'";
				$a = $this->db->query($sql)->result_array();
				if(count($a) == 0){
					$data = array('keyword_nama'=>$this->db->escape_str($t),
							'keyword_username'=>$this->session->username,
							'keyword_nama_seo'=>$this->mylibrary->seo_title($t),
							'count'=>'0');
					$this->As_m->insert('keyword',$data);
				}
				$tags2[] = $this->mylibrary->seo_title($t);
			}
			$tags = implode(",", $tags2);
						if ($hasil22['file_name']==''){
										$data = array(
											'blogs_update_oleh'=>$this->session->username,
											'blogs_judul'=>$this->db->escape_str($this->input->post('blogs_judul')),
											'blogs_judul_seo'=>$this->mylibrary->seo_title($this->input->post('blogs_judul')),
											'blogs_desk'=>$this->input->post('blogs_desk'),
											'blogs_update_hari'=>hari_ini(date('w')),
											'blogs_update_tanggal'=>date('Y-m-d'),
											'blogs_update_jam'=>date('H:i:s'),
											'blogs_meta_desk'=>$this->input->post('blogs_meta_desk'),
											'blogs_keyword'=>$tag);
											$where = array('blogs_id' => $this->input->post('blogs_id'));
											$this->db->update('blogs', $data, $where);
						}else{
										$data = array(
											'blogs_update_oleh'=>$this->session->username,
											'blogs_judul'=>$this->db->escape_str($this->input->post('blogs_judul')),
											'blogs_judul_seo'=>$this->mylibrary->seo_title($this->input->post('blogs_judul')),
											'blogs_desk'=>$this->input->post('blogs_desk'),
											'blogs_update_hari'=>hari_ini(date('w')),
											'blogs_update_tanggal'=>date('Y-m-d'),
											'blogs_update_jam'=>date('H:i:s'),
											'blogs_gambar'=>$hasil22['file_name'],
											'blogs_meta_desk'=>$this->input->post('blogs_meta_desk'),
											'blogs_keyword'=>$tag);
											$where = array('blogs_id' => $this->input->post('blogs_id'));
											$_image = $this->db->get_where('blogs',$where)->row();
											$query = $this->db->update('blogs',$data,$where);
											if($query){
												unlink("assets/frontend/blogs/".$_image->blogs_gambar);
											}

						}
						redirect('aspanel/blogs');
		}else{
			if ($this->session->level=='1'){
					 $proses = $this->As_m->edit('blogs', array('blogs_id' => $id))->row_array();
			}elseif($this->session->level=='2'){
				$proses = $this->As_m->edit('blogs', array('blogs_id' => $id))->row_array();
			}else{
					$proses = $this->As_m->edit('blogs', array('blogs_id' => $id, 'blogs_post_oleh' => $this->session->username))->row_array();
			}
			$data = array('rows' => $proses);
			$data['karyawan_menu_open']   = '';
			$data['home_stat']   = '';
			$data['identitas_stat']   = '';
			$data['profil_stat']   = '';
			$data['sliders_stat']   = '';
			$data['templates_stat']   = '';
			$data['cat_templates_stat']   = '';
			$data['slider_stat']   = '';
			$data['blogs_stat']   = 'active';
			$data['message_stat']   = '';
			$data['gallery_stat']   = '';
			$data['kehadiran_menu_open']   = '';
			$data['jamkerja_stat']   = '';
			$data['absen_stat']   = '';
			$data['dataabsen_stat']   = '';
			$data['cuti_stat']   = '';
			$data['gaji_stat']   = '';
			$data['pengumuman_stat']   = '';
			$data['konfig_stat']   = '';
			$data['produk_menu_open']   = '';
			$data['produk_category']   = '';
			$data['produk']   = '';
			$data['services']   = '';

			$data['tag'] = $this->Crud_m->view_ordering('keyword','keyword_id','DESC');
			$this->load->view('backend/blogs/v_update', $data);
		}
	}
	function blogs_delete_temp()
	{

			$data = array('blogs_status'=>'delete');
			$where = array('blogs_id' => $this->uri->segment(3));
			$this->db->update('blogs', $data, $where);
			redirect('aspanel/blogs');
	}
	function blogs_restore()
	{
			$data = array('blogs_status'=>'Publish');
			$where = array('blogs_id' => $this->uri->segment(3));
			$this->db->update('blogs', $data, $where);
			redirect('aspanel/blogs_storage_bin');
	}
	public function blogs_delete()
	{
			cek_session_akses ('blogs',$this->session->id_session);
			$id = $this->uri->segment(3);
			$_id = $this->db->get_where('blogs',['blogs_id' => $id])->row();
			 $query = $this->db->delete('blogs',['blogs_id'=>$id]);
			if($query){
							 unlink("./assets/frontend/blogs/".$_id->blogs_gambar);
		 }
		redirect('aspanel/blogs_storage_bin');
	}
	/*	Bagian untuk Blogs - Penutup	*/



}
