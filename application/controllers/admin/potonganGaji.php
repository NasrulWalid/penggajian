<?php

class PotonganGaji extends CI_Controller{
  public function __construct(){
    parent::__construct();

    if($this->session->userdata('hak_akses') != '1') {
        $this->session->set_flashdata('pesan','<div class ="alert alert-danger alert-dismissible fade show" role="alert"><strong>
    Anda Belum Login </strong> <button type="button" class="close" data-dismiss="alert" aria-label="close">
    <span aria-hidden="true">&times;</span></button> </div>');
            redirect('Welcome');
    }
}

	public function index()
	{
		$data['title'] = "Setting Potongan Gaji";
		$data['pot_gaji'] = $this->penggajianmodel->get_data('potongan_gaji')->result();
		$this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/potongangaji',$data);
        $this->load->view('templates_admin/footer');
	}

	public function tambah_data()
	{
		$data['title'] = "Tambah Potongan Gaji";
		$this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/formpotongangaji',$data);
        $this->load->view('templates_admin/footer');
	}

	public function tambah_data_aksi(){
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$this->tambah_data();
		}else{
			$potongan		= $this->input->post('potongan');
			$jml_potongan	= $this->input->post('jml_potongan');

			$data   = array(
                'potongan'  =>  $potongan,
                'jml_potongan'    =>  $jml_potongan,
            );

            $this->penggajianmodel->insert_data($data,'potongan_gaji');
            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data berhasil ditambahkan!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('admin/potonganGaji');
		}
	}

	public function update_data($id)
    {
        $where = array('id' => $id);
        $data['pot_gaji'] = $this->db->query("SELECT * FROM potongan_gaji WHERE id='$id'")->result();
        $data['title'] = "Update Potongan Gaji";
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/updatepotongangaji',$data);
        $this->load->view('templates_admin/footer');
    }

    public function update_data_aksi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE) {
            $this->update_data();
        }else{
            $id             =  $this->input->post('id');
            $potongan   =  $this->input->post('potongan');
            $jml_potongan     =  $this->input->post('jml_potongan');

            $data   = array(
                'potongan'  =>  $potongan,
                'jml_potongan'    =>  $jml_potongan,
            );

            $where  = array(
                'id'    =>   $id
            );

            $this->penggajianmodel->update_data('potongan_gaji',$data,$where);
            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data berhasil diupdate!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('admin/potonganGaji');
        }
    }

	public function deleteData($id)
    {
        $where = array('id' => $id);
        $this->penggajianmodel->delete_data($where, 'potongan_gaji');
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data berhasil dihapus!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('admin/potonganGaji');
    }

	public function _rules()
	{
		$this->form_validation->set_rules('potongan', 'jenis_potongan','required');
		$this->form_validation->set_rules('jml_potongan', 'jml_potongan','required');
	}
}

?>