<?php
App::uses('AppController', 'Controller');
/**
 * Inputsettingpivots Controller
 *
 */
class  LaporanvouchersController extends AppController
{
    public $components = array('Function', 'Paginator');
    public function index()
    {
        echo $this->Function->cekSession($this);
    }

    public function getData()
    {
        $this->autoRender = false;
        $this->loadModel('Asset');
        $this->loadModel('User');
        $this->loadModel('Vdb');
        //$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 

        $hm = $_POST['hal'];
        $fungsi = $_POST['fungsi'];
        $filterNamaKegiatan = $_POST['filterNamaKegiatan'];
        $filterTglKegiatan = $_POST['filterTglKegiatan'];
        $filterJmlVoucher = $_POST['filterJmlVoucher'];
        $filterNilaiVoucher = $_POST['filterNilaiVoucher'];
        $filterEdVoucher = $_POST['filterEdVoucher'];
        // var_dump($_POST);
        // exit();

        $limit = 10;
        if (empty($hm) || $hm == 1) {
            $start = 0;
        } else {
            $start = ($hm - 1) * $limit;
        }

        if (!empty($filterTglKegiatan)) {
            $dateFormat = date('Y-m-d', strtotime($filterTglKegiatan)); //ubah dmy ke  ymd
            // var_dump($dateFormat);
            // exit();
            $filterTglKegiatan = "AND v.`tglKegiatan` = '$dateFormat'";
        }

        if (!empty($filterEdVoucher)) {
            $dateFormat = date('Y-m-d', strtotime($filterEdVoucher)); //ubah dmy ke  ymd
            $filterEdVoucher = "AND v.`edVoucher` = '$dateFormat'";
        }

        if (!empty($filterJmlVoucher)) {
            $filterJmlVoucher = "HAVING jmlVoucher = '$filterJmlVoucher'";
        }

        //status //AND v.`stsVoucher` = 'true'

        $sql = "SELECT *, COUNT(v.`noVoucher`) jmlVoucher, GROUP_CONCAT(v.`noVoucher`) kodeVoucher FROM dpfdplnew.`vouchers` v WHERE v.`namaKegiatan` LIKE '%$filterNamaKegiatan%' $filterTglKegiatan $filterEdVoucher  GROUP BY v.`namaKegiatan`, v.`kodeKeg` $filterJmlVoucher ORDER BY v.`kodeKeg`";

        $querysql = $this->User->query($sql);

        $jumQuery = count($querysql);
        $sum = ceil($jumQuery / $limit);
        /* -----------------------------Navigasi Record ala google style ----------------------------- */
        $linkHal = $this->pageNavMulti($hm, $sum, $limit, $fungsi);
        /* -----------------------------End Navigasi Record ala google style ----------------------------- */
        $queryTampil = $this->User->query($sql . " limit $start, $limit");
        $n = $start + 1;

        $txtData = '';
        if ($jumQuery == 0 || $jumQuery == Null) {
            $txtData .= "
                <tr>
                     <td colspan='10' style='text-align:center;'><div class='alert alert-success' role='alert' style='margin-bottom: 0;'><strong>Data Kosong</strong></div></td>
                </tr>";
        } else {
            foreach ($queryTampil as $data) {
                $id = $data['v']['id'];
                $namaKegiatan = $data['v']['namaKegiatan'];
                $kodeKeg = $data['v']['kodeKeg'];
                $tglKegiatan = $data['v']['tglKegiatan'];
                $jmlVoucher = $data[0]['jmlVoucher'];
                $nilai = $data['v']['nilai'];
                $edVoucher = $data['v']['edVoucher'];
                $stsVoucher = $data['v']['stsVoucher'];
                $kodeVouchers = $data[0]['kodeVoucher'];

                if ($stsVoucher == 'true') {
                    $btnVoucher = "<button type='button' class='btn btn-danger btn-sm btnSet' data-set='$namaKegiatan" . "|" . "$tglKegiatan" . "|" . "$kodeKeg'>Nonaktifkan voucher</button>";
                    $stsVoucher = "<span class='label label-primary'>AKTIF</span>";
                } else {
                    $btnVoucher = "<button type='button' class='btn btn-default btn-sm' disabled>Nonaktifkan voucher</button>";
                    $stsVoucher = "<span class='label label-default'>TIDAK AKTIF</span>";
                }
                $kodeVoucher = explode(",", $kodeVouchers);
                $nmr = 1;
                $txtVoucher = "";
                $nmrVcr = 1;
                foreach ($kodeVoucher as $dataVoucher) {
                    $txtVoucher .= "<tr>
                            <td>$nmrVcr</td>
                            <td>$dataVoucher</td>
                            <td>Rp. " . number_format($nilai, 0, ',', '.') . "</td>
                            <td>" . date('d-m-Y', strtotime($edVoucher)) . "</td>
                        </tr>";
                    $nmrVcr++;
                }


                $txtData .= "
                <tr class='panel-heading'>
                <td style='vertical-align:middle'class='text-center'>$n</td>
                <td class='text-center' style='vertical-align:middle'>
                    <a data-toggle='collapse' data-parent='#accordion' href='#collapse$n' style='color:#66A594;padding:0' onmouseover='colorin(this)' onmouseout='normalcolor(this)'><i class='caretIcon fa fa-chevron-circle-down fa-lg' aria-hidden='true'></i> </a>
                </td>
                <td style='vertical-align:middle' id='tdNamaKeg" . $n . "' >" . $namaKegiatan . "</td>
                <td style='vertical-align:middle' id='tdKodeKeg" . $n . "' class='text-center'>" . $kodeKeg . "</td>
                <td style='vertical-align:middle' id='tdTglKeg" . $n . "' class='text-center'>" . date('d-m-Y', strtotime($tglKegiatan)) . "</td>
                <td style='vertical-align:middle' id='tdJmlVoucher" . $n . "' class='text-center'>" . number_format($jmlVoucher, 0, ',', '.') . "</td>
                <td style='vertical-align:middle' id='tdStatusVoucher" . $n . "' class='text-center'>" . $stsVoucher . "</td>
                <td id='btn" . $n . "' class='text-center'>$btnVoucher</td></tr>";
                $txtData .= " 
                <tr class='trEven' style='height:0px;'>
                            <td colspan='12' style='background-color:#FFF; border-top:unset;padding:unset;' class='zeroPadding passive'>
                                <div id='collapse$n' class='collapse out' style='padding:10px;background-color: cornsilk'>
                                    <div class='row'>
                                        <div class='col-md-2 col-md-offset-2'>
                                        <div class='form-group'>
                                            <label class='control-label'> <i class='fa fa-search fa-fw'></i> FILTER BY: </label>
                                        </div>
                                        <div class='input-group'>
                                            <input type='text' id='filterKodeVoc" . $n . "' class='form-control' placeholder='Kode Voucher' style='font-size: 12px;'>
                                       
                                        <span class='input-group-btn'>
                                            <button class='btn btn-default cariVoc' onclick=getKodeVoc('" . $n . "') type='button'><i class='fa fa-search fa-fw'></i>CARI</button>
                                        </span>
                                    </div>
                                        </div>
                                        <div class='col-md-8 col-md-offset-2'>
                                            <div class='panel panel-default' style='border-radius: 5px;margin-bottom:10px;margin-top:10px;'>
                                            <div class='panel-heading'>
                                            <div class='row'>
                                            <div class='col-md-2'>
                                                <i class='fa fa-th-list fa-fw'></i> LIST VOUCHER
                                            </div>
                                            <div class='col-md-10 text-right'>
                                                <button type='button' class='btn btn-danger btn-sm btnPDF' onclick=\"cetakPDF('" . $n . "','" . $namaKegiatan . "')\" id='btnPDF' target='_blank' style='display:;'><i class='fa fa-file-pdf-o'> </i> PDF</button>
                                                <button type='button' class='btn btn-primary btn-sm' id='btnEXCEL' target='_blank'><i class='fa fa-file-excel-o'> </i> EXCEL</button>
                                            </div>
                                        </div>
                                            </div>
                                                <div class='panel-body'  style='height:340px;max-height: 340px;overflow-y:auto;padding:0;'>
                                                    <table class='table tableDetail table-bordered'>
                                                        <thead>
                                                            <tr class='active'>
                                                                <th>NO.</th>
                                                                <th>KODE VOUCHER</th>
                                                                <th>NILAI</th>
                                                                <th>ED VOUCHER</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            $txtVoucher
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>";
                $n++;
            }
        }
        echo $txtData . "!" . $linkHal;
    }

    public function getKodeVoc()
    {
        $this->autoRender = false;
        $this->loadModel('Asset');
        $this->loadModel('User');
        $this->loadModel('Vdb');


        // var_dump($_POST);
        $idRecord = $_POST['idRecord'];
        $filterKodeVoc = $_POST['filterKodeVoc'];
        // $idRecord = $_POST['idRecord'];
        var_dump($idRecord);
        var_dump($filterKodeVoc);
    }

    public function cetakPDF()
    {
        $this->autoRender = false;
        $this->loadModel('Asset');
        $this->loadModel('User');
        $this->loadModel('Vdb');

        // var_dump($_POST);
        $filterNamaKegiatan = $_POST['filterNamaKegiatan'];
        $filterTglKegiatan = $_POST['filterTglKegiatan'];
        $filterJmlVoucher = $_POST['filterJmlVoucher'];
        $filterNilaiVoucher = $_POST['filterNilaiVoucher'];
        $filterEdVoucher = $_POST['filterEdVoucher'];

        if (!empty($filterTglKegiatan)) {
            $dateFormat = date('Y-m-d', strtotime($filterTglKegiatan)); //ubah dmy ke  ymd
            // var_dump($dateFormat);
            // exit();
            $filterTglKegiatan = "AND v.`tglKegiatan` = '$dateFormat'";
        }

        if (!empty($filterEdVoucher)) {
            $dateFormat = date('Y-m-d', strtotime($filterEdVoucher)); //ubah dmy ke  ymd
            $filterEdVoucher = "AND v.`edVoucher` = '$dateFormat'";
        }

        if (!empty($filterJmlVoucher)) {
            $filterJmlVoucher = "HAVING jmlVoucher = '$filterJmlVoucher'";
        }

        $sql = "SELECT *, COUNT(v.`noVoucher`) jmlVoucher, GROUP_CONCAT(v.`noVoucher`) kodeVoucher FROM dpfdplnew.`vouchers` v WHERE v.`namaKegiatan` LIKE '%$filterNamaKegiatan%' $filterTglKegiatan $filterEdVoucher  GROUP BY v.`namaKegiatan`, v.`kodeKeg` $filterJmlVoucher ORDER BY v.`kodeKeg`";

        $queryRecord = $this->User->query($sql);
        foreach ($queryRecord as $data) {
            $kodeVouchers = $data[0]['kodeVoucher'];
            $nilai = $data['v']['nilai'];
            $kodeVoucher = explode(",", $kodeVouchers);
            $edVoucher = $data['v']['edVoucher'];
            $nmr = 1;
            $txtVoucher = "";
            $nmrVcr = 1;
            foreach ($kodeVoucher as $dataVoucher) {
                $txtVoucher .= "<tr>
                        <td>$nmrVcr</td>
                        <td>$dataVoucher</td>
                        <td>Rp. " . number_format($nilai, 0, ',', '.') . "</td>
                        <td>" . date('d-m-Y', strtotime($edVoucher)) . "</td>
                    </tr>";
                $nmrVcr++;
            }
        }

        $this->set("queryRecord", $queryRecord);
        $this->set("nilai", $nilai);
        $this->set("kodeVoucher", $kodeVoucher);
        $this->set("edVoucher", $edVoucher);
        $this->render('pdf');

        // $this->render('pdf');
    }

    // public function simpan()
    // {
    //     $this->autoRender = false;
    //     $this->loadModel('Asset');
    //     $this->loadModel('User');
    //     $this->loadModel('Vdb');
    //     //$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
    //     try {
    //         $dataSource = $this->User->getdatasource();
    //         $dataSource->begin();
    //         date_default_timezone_set('Asia/Jakarta');
    //         $namaKegiatan   = $_POST["namaKegiatan"];
    //         $tglKegiatan    = $_POST["tglKegiatan"];
    //         $jmlVoucher     = $_POST["jmlVoucher"];
    //         $nilaiVoucher   = $_POST["nilaiVoucher"];
    //         $edVoucher      = $_POST["edVoucher"];

    //         //generate kode kegiatan;
    //         $kodeKeg = "";
    //         // $getQueryVoucer=$this->User->query("SELECT kodeKeg FROM dpfdplnew.`vouchers` GROUP BY `kodeKeg`");// qry dengan group by
    //         // $jmlKeg=count($getQueryVoucer); // cari jumlah kegiatan dari count query group by, kemudian tentukan kode keg baru

    //         $getQueryVoucer = $this->User->query("SELECT kodeKeg FROM dpfdplnew.`vouchers` ORDER BY id DESC LIMIT 1");
    //         if (count($getQueryVoucer) < 1) {
    //             $kodeKeg = '01';
    //         } else {
    //             $getyKodeKeg = $getQueryVoucer[0]['vouchers']['kodeKeg'];
    //             $getKodeKeg = (int)$getyKodeKeg + 1;
    //             $kodeKeg = (int)$getKodeKeg < 10 ? '0' . $getKodeKeg : $getKodeKeg;

    //             // if($getKodeKeg<10){
    //             //     $kodeKeg='0'.$getKodeKeg;
    //             // }else{
    //             //     $kodeKeg=$getKodeKeg;
    //             // }
    //         }


    //         //var_dump($_POST);exit();
    //         // menghilangkan karakter number
    //         $jmlVoucher = preg_replace("/[^0-9]/", "", $jmlVoucher);
    //         $nilaiVoucher = preg_replace("/[^0-9]/", "", $nilaiVoucher);
    //         $colVc = [];
    //         for ($n = 0; $n < $jmlVoucher; $n++) {
    //             $randStr = $this->random_strings(8);
    //             if (in_array($randStr, $colVc)) {
    //                 $n--;
    //             } else {
    //                 $colVc[] = $randStr;
    //             }
    //         }
    //         $uniqueValues = array_unique($colVc);

    //         if (count($uniqueValues) == (int)$jmlVoucher) {
    //             $queryInsert = "";
    //             foreach ($uniqueValues as $nomorVoucher) {
    //                 $nomorVoucher = $nomorVoucher . $kodeKeg;
    //                 $queryInsert .= "('$namaKegiatan','$kodeKeg','" . date('Y-m-d', strtotime($tglKegiatan)) . "','$nomorVoucher','$nilaiVoucher','" . date('Y-m-d', strtotime($edVoucher)) . "','true'),";
    //             }
    //             $queryInsert = rtrim($queryInsert, ", ");
    //             $queryInsert = "INSERT INTO dpfdplnew.`vouchers`(namaKegiatan,kodeKeg,tglKegiatan,noVoucher,nilai,edVoucher,stsVoucher)VALUES" . $queryInsert;
    //             //var_dump($queryInsert);exit();
    //             $this->User->query($queryInsert);
    //             echo "sukses";
    //         } else {
    //             echo "gagal";
    //         }

    //         $dataSource->commit();
    //     } catch (Exception $e) {
    //         var_dump($e->getTrace());
    //         $dataSource->rollback();
    //     }
    // }
    //nonaktifkan voucer kegiatan
    public function setnonaktif()
    {
        $this->autoRender = false;
        $this->loadModel('Asset');
        $this->loadModel('User');
        $this->loadModel('Vdb');
        //$this->User->query("SET @@sql_mode='NO_ENGINE_SUBSTITUTION'"); 
        try {
            $dataSource = $this->User->getdatasource();
            $dataSource->begin();
            date_default_timezone_set('Asia/Jakarta');

            $dataset = $_POST['dataset'];
            $qryUpdate = "UPDATE dpfdplnew.`vouchers` SET stsVoucher='false' WHERE CONCAT(namaKegiatan,tglKegiatan,kodeKeg)='$dataset'";
            $this->User->query($qryUpdate);
            echo 'sukses';
            $dataSource->commit();
        } catch (Exception $e) {
            var_dump($e->getTrace());
            $dataSource->rollback();
        }
    }

    //fungsi pengambilan karakter random
    function random_strings($length_of_string)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }



    // pagination
    public function pageNavMulti($curHal, $maxHal, $jmlTampil, $fungsi)
    {
        $linkHal = '';
        $angka = '';
        $halTengah = round($jmlTampil / 2);
        if ($maxHal > 1) {
            if ($curHal > 1) {
                $previous = $curHal - 1;
                $linkHal = $linkHal . "<ul class='pagination'><li class='page-item'><a class='page-link' onclick='" . $fungsi . "(1)'> First</a></li>";
                $linkHal = $linkHal . "<li class='page-item'><a class='page-link' onclick='" . $fungsi . "($previous)'>Prev</a></li>";
            } elseif (empty($curHal) || $curHal == 1) {
                $linkHal = $linkHal . "<ul class='pagination'><li class='page-item'><a class='page-link'>First</a></li><li class='page-item'><a class='page-link'>Prev</a></li> ";
            }

            for ($i = $curHal - ($halTengah - 1); $i < $curHal; $i++) {
                if ($i < 1)
                    continue;
                $angka .= "<li class='page-item'><a class='page-link' onclick='" . $fungsi . "($i)'>$i</a></li>";
            }
            $angka .= "<li class='page-item active'><span class='page-link'><b >$curHal</b> <span class='sr-only'>(current)</span></span></li>";
            for ($i = $curHal + 1; $i < ($curHal + $halTengah); $i++) {
                if ($i > $maxHal)
                    break;
                $angka .= "<li class='page-item'><a class='page-link' onclick='" . $fungsi . "($i)'>$i</a></li> ";
            }
            $linkHal = $linkHal . $angka;
            if ($curHal < $maxHal) {
                $next = $curHal + 1;
                $linkHal = $linkHal . "<li class='page-item'><a class='page-link'onclick='" . $fungsi . "($next)'>Next </a></li><li class='page-item'>
				<a class='page-link' onclick='" . $fungsi . "($maxHal)'>Last</a></li> </ul>";
            } else {
                $linkHal = $linkHal . " <li class='page-item'><a class='page-link'>Next</a></li><li class='page-item'><a class='page-link'>Last</a></li></ul>";
            }
        }
        return $linkHal;
    }
}
