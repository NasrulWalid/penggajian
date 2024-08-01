<?php

class DataAbsensi extends CI_Controller{

    public function __construct(){
        parent::__construct();

        if($this->session->userdata('hak_akses') != '2') {
            $this->session->flashdata('pesan','<div class ="alert alert-danger alert-dismissible fade show" role="alert"><strong>
            Anda Belum Login </strong> <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span></button> </div>');
            redirect('welcome');
        }
    }
    public function index()
    {
        $data['title'] = "Data Absensi";
        $nik= $this->session->userdata('nik');
        $data['absensi'] = $this->db->query("SELECT data_pegawai.nama_pegawai, data_pegawai.nik,data_kehadiran.bulan,data_kehadiran.nama_jabatan,data_kehadiran.hadir,data_kehadiran.sakit,data_kehadiran.alpha,data_kehadiran.id_kehadiran
        FROM data_pegawai
        INNER JOIN data_kehadiran on data_kehadiran.nik=data_pegawai.nik
        INNER JOIN data_jabatan on data_jabatan.nama_jabatan=data_pegawai.jabatan
        WHERE data_kehadiran.nik='$nik'
        ORDER BY data_kehadiran.bulan DESC")->result();
        $this->load->view('templates_pegawai/header',$data);
        $this->load->view('templates_pegawai/sidebar');
        $this->load->view('pegawai/dataabsensi',$data);
        $this->load->view('templates_pegawai/footer');
    }
}
?>