<?php
include("config/koneksi_askred.php");

class subroModel
{
    public function getListSubro()
    {
        //        $listSubro = mssql_query("SELECT * FROM askred_subrogation_validation");
        $listSubro = mssql_query("SELECT *,  a.created_date as tanggalpengajuan, c.nama_program as namaprogram, a.f_id_program as fidprogram, a.nomor_peserta as nopeserta, b.created_date as tgl_realisasi FROM askred_subrogation_validation a LEFT JOIN askred_subrogation_flag b ON a.urutan_pengajuan = b.urutan_pengajuan_subrogasi LEFT JOIN askred_program c ON a.f_id_program = c.f_id_program");
        return $listSubro;
    }

    public function getListRejectionSubro()
    {
        $penolakanSubro = mssql_query("SELECT * FROM askred_pending WHERE service = 'SubrogationValidation'");
        return $penolakanSubro;
    }

    public function getListSubroFileRC()
    {
        //        $listSubro = mssql_query("SELECT * FROM askred_subrogation_validation");
        $listSubroFileRC = mssql_query("SELECT fr.*, 
        (SELECT COUNT(*) FROM mapping_rc_bri mrb WHERE fr.id = mrb.id_file_rc AND mrb.ismatch = '1') as total_match,
        (SELECT COUNT(*) FROM mapping_rc_bri mrb WHERE fr.id = mrb.id_file_rc AND mrb.ismatch = '0') as total_unmatch,
        (SELECT COUNT(*) FROM mapping_rc_bri mrb WHERE fr.id = mrb.id_file_rc AND mrb.ismatch = '2') as total_double
        FROM file_rc fr");
        return $listSubroFileRC;
    }

    public function getListSubroFileRC($idFile)
    {
        $listDataRCSubro = mssql_query("SELECT * FROM mapping_rc_bri WHERE id_file_rc = '" . $idFile . "'");
        return $listDataRCSubro;
    }
}
