<?php

class dataPegawai extends CI_Controller{

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
        $data['title'] = "Data Pegawai";
        $data['pegawai'] = $this->penggajianmodel->get_data('data_pegawai')->result();
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/datapegawai',$data);
        $this->load->view('templates_admin/footer');
    }
    public function tambah_data()
    {
        $data['title'] = "Tambah Data Pegawai";
        $data['jabatan'] = $this->penggajianmodel->get_data('data_jabatan')->result();
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/formtambahpegawai',$data);
        $this->load->view('templates_admin/footer');
    }
    public function tambah_data_aksi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE) {
            $this->tambah_data();
        }else{
            $nik            = $this->input->post('nik');
            $nama_pegawai   = $this->input->post('nama_pegawai');
            $jenis_kelamin  = $this->input->post('jenis_kelamin');
            $tanggal_masuk  = $this->input->post('tanggal_masuk');
            $jabatan        = $this->input->post('jabatan');
            $status         = $this->input->post('status');
            $hak_akses         = $this->input->post('hak_akses');
            $username         = $this->input->post('username');
            $password         = md5($this->input->post('password'));
            $photo          = $_FILES['photo']['name'];
            if($photo=''){}else{
                $config ['upload_path'] = './assets/photo';
                $config ['allowed_types'] ='jpg|jpeg|png|tiff';
                $this->load->library('upload',$config);
                if(!$this->upload->do_upload('photo')){
                    echo "Photo Gagal diupload";
                }else{
                    $photo=$this->upload->data('file_name');
                }
            }
            
            $data = array(
                'nik'               => $nik,
                'nama_pegawai'      => $nama_pegawai,
                'jenis_kelamin'     => $jenis_kelamin,
                'jabatan'           => $jabatan,
                'tanggal_masuk'     => $tanggal_masuk,
                'status'            => $status,
                'hak_akses'         => $hak_akses,
                'username'         => $username,
                'password'         => $password,
                'photo'             => $photo,   
            );
            $this->penggajianmodel->insert_data($data, 'data_pegawai');
            $this->session->set_flashdata('pesan','<div class ="alert alert-success alert-dismissible fade show" role="alert"><strong>
            Data berhasil ditambahkan </strong> <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/datapegawai');
        }
    }
    public function update_data($id)
    {
        $where = array('id_pegawai' => $id);
        $data['title'] = 'Update Data Pegawai';
        $data['jabatan'] = $this->penggajianmodel->get_data('data_jabatan')->result();
        $data['pegawai'] = $this->db->query("SELECT * FROM data_pegawai WHERE id_pegawai='$id'")->result();
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/formupdatepegawai',$data);
        $this->load->view('templates_admin/footer');
    }
    public function update_data_aksi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE) {
            $this->update_data();
        }else{
            $id            = $this->input->post('id_pegawai');
            $nik            = $this->input->post('nik');
            $nama_pegawai   = $this->input->post('nama_pegawai');
            $jenis_kelamin  = $this->input->post('jenis_kelamin');
            $tanggal_masuk  = $this->input->post('tanggal_masuk');
            $jabatan        = $this->input->post('jabatan');
            $status         = $this->input->post('status');
            $hak_akses         = $this->input->post('hak_akses');
            $username         = $this->input->post('username');
            $password         = md5($this->input->post('password'));
            $photo          = $_FILES['photo']['name'];
            if($photo){
                $config ['upload_path'] = './assets/photo';
                $config ['allowed_types'] ='jpg|jpeg|png|tiff';
                $this->load->library('upload',$config);
                if($this->upload->do_upload('photo')){
                    $photo=$this->upload->data('file_name');
                    $this->db->set('photo',$photo);
                }else{
                    echo $this->upload->display_errors();
                }
            }
            
            $data = array(
                'nik'               => $nik,
                'nama_pegawai'      => $nama_pegawai,
                'jenis_kelamin'     => $jenis_kelamin,
                'jabatan'           => $jabatan,
                'tanggal_masuk'     => $tanggal_masuk,
                'status'            => $status,  
                'hak_akses'            => $hak_akses,
                'username'         => $username,
                'password'         => $password, 
            );

            $where = array(
                'id_pegawai' => $id
            );

            $this->penggajianmodel->update_data('data_pegawai',$data,$where);
            $this->session->set_flashdata('pesan','<div class ="alert alert-success alert-dismissible fade show" role="alert"><strong>
            Data berhasil diupdate </strong> <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/datapegawai');
        }
    }
    public function _rules()
    {
        $this->form_validation->set_rules('nik','nik','required');
        $this->form_validation->set_rules('nama_pegawai','nama_pegawai','required');
        $this->form_validation->set_rules('jenis_kelamin','jenis_kelamin','required');
        $this->form_validation->set_rules('tanggal_masuk','tanggal_masuk','required');
        $this->form_validation->set_rules('jabatan','jabatan','required');
        $this->form_validation->set_rules('jabatan','jabatan','required');
    }
    public function delete_data($id)
    {
        $where = array('id_pegawai' => $id);
        $this->penggajianmodel->delete_data($where, 'data_pegawai');
        $this->session->set_flashdata('pesan','<div class ="alert alert-danger alert-dismissible fade show" role="alert"><strong>
            Data berhasil diHapus! </strong> <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/datapegawai');
    }
    
}
?>