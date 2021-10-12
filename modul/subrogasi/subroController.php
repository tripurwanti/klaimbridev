<?php
error_reporting(1);
define('SITE_ROOT', dirname(__FILE__));

include '../../config/excel_reader2.php';
include '../../config/SpreadsheetReader.php';
include '../../config/library.php';
include "subroModel.php";

class subroController
{
    public $model;
    public function __construct()
    {
        $this->model = new subroModel();
    }

    public function getListSubro()
    {
        $listDataSubro = $this->model->getListSubro();
        include "subroView.php";
    }

    public function exportToExcel()
    {
        $listDataSubro = $this->model->getListSubro();
        include "exportExcelView.php";
    }

    public function getListRejectionSubro()
    {
        $dataPenolakanSubro = $this->model->getListRejectionSubro();
        include "penolakanSubroView.php";
    }

    public function getListSubroFileRC()
    {
        $listSubroFileRC = $this->model->getListSubroFileRC();
        include "listRCSubroView.php";
    }

    // public function getListSubroDataRC($idFile)
    // {
    //     $listSubroDataRC = $this->model->getListSubroFileRC($idFile);
    //     include "listDataRCSubroView.php";
    // }

    public function uploadRCSubroView()
    {
        include "uploadRCSubroView.php";
    }
}
