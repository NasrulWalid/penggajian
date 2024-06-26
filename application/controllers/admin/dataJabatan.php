<?php

class DataJabatan extends CI_Controller{
    
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
        $data['title'] = "Data jabatan";
        $data['jabatan'] = $this->penggajianmodel->get_data('data_jabatan') ->result();
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/datajabatan',$data);
        $this->load->view('templates_admin/footer');
    }

    public function tambah_data()
    {
        $data['title'] = "Tambah data jabatan";
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/tambahdatajabatan',$data);
        $this->load->view('templates_admin/footer');
    }
    public function tambah_data_aksi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE){
            $this->tambah_data();
        } else {
            $nama_jabatan = $this->input->post('nama_jabatan');
            $gaji_pokok = $this->input->post('gaji_pokok');
            $tunjangan_transport = $this->input->post('tunjangan_transport');
            $uang_makan = $this->input->post('uang_makan');
            
            $data = array (
                
                'nama_jabatan' => $nama_jabatan,
                'gaji_pokok' => $gaji_pokok,
                'tunjangan_transport' => $tunjangan_transport,
                'uang_makan' => $uang_makan,
            );

            $this->penggajianmodel->insert_data($data, 'data_jabatan');
            $this->session->set_flashdata('pesan','<div class ="alert alert-success alert-dismissible fade show" role="alert"><strong>
            Data berhasil ditambahkan </strong> <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/dataJabatan');
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_jabatan','nama jabatan','required');
        $this->form_validation->set_rules('gaji_pokok','gaji pokok','required');
        $this->form_validation->set_rules('tunjangan_transport','tunjangan transport','required');
        $this->form_validation->set_rules('uang_makan','uang makan','required');
    }

    public function update_data($id)
    {
        $where = array('id_jabatan' => $id);
        $data['jabatan'] = $this->db->query("SELECT * FROM data_jabatan WHERE id_jabatan='$id'")->result();
        $data['title'] = "Update data jabatan";
        $this->load->view('templates_admin/header',$data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/updatedatajabatan',$data);
        $this->load->view('templates_admin/footer');
    }
    public function update_data_aksi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE){
            $this->update_data();
        } else {
            $id                     = $this->input->post('id_jabatan');
            $nama_jabatan           = $this->input->post('nama_jabatan');
            $gaji_pokok             = $this->input->post('gaji_pokok');
            $tunjangan_transport    = $this->input->post('tunjangan_transport');
            $uang_makan             = $this->input->post('uang_makan');
            
            $data = array(
                'nama_jabatan' => $nama_jabatan,
                'gaji_pokok' => $gaji_pokok,
                'tunjangan_transport' => $tunjangan_transport,
                'uang_makan' => $uang_makan,
            );

            $where = array(
                'id_jabatan' => $id
            );

            $this->penggajianmodel->update_data('data_jabatan',$data,$where);
            $this->session->set_flashdata('pesan','<div class ="alert alert-success alert-dismissible fade show" role="alert"><strong>
            Data berhasil diupdate! </strong> <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/dataJabatan');
        }

    }
    public function delete_data($id)
    {
        $where = array('id_jabatan' => $id);
        $this->penggajianmodel->delete_data($where, 'data_jabatan');
        $this->session->set_flashdata('pesan','<div class ="alert alert-danger alert-dismissible fade show" role="alert"><strong>
            Data berhasil diHapus! </strong> <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('admin/dataJabatan');
    }
    
    
}

?>