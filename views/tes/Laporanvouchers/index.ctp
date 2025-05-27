<?php
echo $this->Html->script('h1laporanvoucher.js');
echo $this->Html->script('bundle.min.js');
?>
<style>
    /* Select Pure Auto complate */
    .select-wrapper {
        margin: auto;
        max-width: 500px;
        width: calc(100% - 40px);
    }

    .select-pure__select {
        background: #fff;
        align-items: center;
        border-radius: 3px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        color: #363b3e;
        cursor: pointer;
        display: flex;
        font-size: 16px;
        font-weight: 500;
        justify-content: left;
        min-height: 34px;
        padding: 5px 10px;
        position: relative;
        transition: 0.2s;
        width: 100%;
    }

    .select-pure__options {
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #363b3e;
        display: none;
        left: 0;
        max-height: 221px;
        overflow-y: scroll;
        position: absolute;
        top: 35px;
        width: 100%;
        z-index: 5;
    }

    .select-pure__select--opened .select-pure__options {
        display: block;
    }

    .select-pure__option {
        background: #fff;
        border-bottom: 1px solid #e4e4e4;
        box-sizing: border-box;
        /* height: 44px;*/
        line-height: 20px;
        padding: 10px;
    }

    .select-pure__option--selected {
        color: #e4e4e4;
        cursor: initial;
        pointer-events: none;
    }

    .select-pure__option--hidden {
        display: none;
    }

    .select-pure__selected-label {
        background: #5e6264;
        border-radius: 4px;
        color: #fff;
        cursor: initial;
        display: inline-block;
        margin: 5px 10px 5px 0;
        padding: 3px 7px;
    }

    .select-pure__selected-label:last-of-type {
        margin-right: 0;
    }

    .select-pure__selected-label i {
        cursor: pointer;
        display: inline-block;
        margin-left: 7px;
    }

    .select-pure__selected-label i:hover {
        color: #e4e4e4;
    }

    .select-pure__autocomplete {
        background: #faebcc;
        border-bottom: 1px solid #e4e4e4;
        border-left: none;
        border-right: none;
        border-top: none;
        box-sizing: border-box;
        font-size: 16px;
        outline: none;
        padding: 10px;
        width: 100%;
        margin-bottom: 0 !important
    }

    .ui-datepicker select.ui-datepicker-month,
    .ui-datepicker select.ui-datepicker-year {
        width: 49%;
        color: black;
        height: 20px;
    }

    /* End Select Pure Auto complate */
    #linkHal1 ul {
        margin: 0 !important;
    }

    @media only screen and (min-width: 1200px) {
        #modalBagan {
            width: 70%;
            margin-left: 15%;
            margin-top: 2%;
            margin-bottom: 2%;
        }
    }

    #modalBagan .well {
        height: 100%;
        border-radius: unset;
        border-top: 0;
        border-bottom: 0;
    }

    .form-control {
        font-size: 12px;
    }

    #tblVoucher tbody tr th,
    .table tbody tr:hover td,
    .table tbody tr:hover th {
        background-color: unset !important
    }

    /* #tblVoucher tbody tr:nth-child(even) td{padding:unset;} */
    #tblVoucher tbody tr td>a {
        color: darkslategray !important;
        font-size: 12px;
        padding: 2px;
        margin-right: 4px;
    }

    #tblVoucher .tableDetail th {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    #tblVoucher .tableDetail tr th {
        text-align: center;
        vertical-align: middle;
        background: #f5f5f5 !important;
        border-bottom: unset;
    }

    #tblVoucher .tableDetail thead {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    #tblVoucher .tableDetail th[scope=row] {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        z-index: 1;
    }

    #tblVoucher .tableDetail th[scope=row] {
        vertical-align: top;
        color: inherit;
    }

    #tblVoucher .tableDetail th[scope=head] {
        left: 0;
        z-index: 3;
    }

    #tblVoucher .tableDetail tr td {
        text-align: center;
        vertical-align: middle;
        border-bottom: unset;
    }
</style>
<form action="" id="Laporanvoucher" name="Laporanvoucher" method="post">
    <div class="row">
        <blockquote>Laporan Voucher</blockquote>

        <div class="col-md-4">
            <div class="well ">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="thaun" class="col-sm-3 control-label">Nama Kegiatan</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-align-justify" aria-hidden="true"></i></span>
                                <input id="filterNamaKegiatan" name="filterNamaKegiatan" class="form-control" required="true" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bulan" class="col-sm-3 control-label">Tanggal Kegiatan</label>
                        <div class="col-sm-9 ">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                <input id="filterTglKegiatan" name="filterTglKegiatan" class="form-control" required="true" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bulan" class="col-sm-3 control-label">Jumlah Voucher</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-circle" aria-hidden="true"></i></span>
                                <input id="filterJmlVoucher" name="filterJmlVoucher" class="form-control text-right" required="true" type="text" onKeyUp="upAngka(this)">
                            </div>
                        </div>
                    </div>
                    <!-- <button type="button" class='btn btn-default btn-sm' id="btnTes"> <i class="fa fa-search fa-fw"></i> CARI</button> -->

                    <div class="form-group">
                        <label for="bulan" class="col-sm-3 control-label">Nilai Voucher</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tag" aria-hidden="true"></i></span>
                                <input id="filterNilaiVoucher" name="filterNilaiVoucher" class="form-control text-right" required="true" type="text" onKeyUp="upAngka(this)">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bulan" class="col-sm-3 control-label">Exp Date Voucher</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                <input id="filterEdVoucher" name="filterEdVoucher" class="form-control" required="true" type="text">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group" style="margin-bottom: 0">
                        <label for="bulan" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <button type="button" class="btn btn-primary btn-sm" id="btnSimpan" onclick='getData(1)' style="margin-bottom:0"> <i class="fa fa-plus-circle "></i> CARI</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- table generate -->
    <div class="row">
        <hr>
        <div class="col-md-12">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-2"><label class="control-label"><i class="fa fa-th-list fa-fw"></i> LIST KEGIATAN</label></div>
                        </div>
                    </div>
                    <div class="panel-body" style="padding-top:0;padding-bottom:0;">
                        <div class="row table-responsive">
                            <table id='tblVoucher' cellpadding="0" cellspacing="0" width="100%" class="table " style="margin-bottom:0;">
                                <thead>
                                    <tr class="active">
                                        <th width="2%" style="text-align:center;vertical-align:middle">No</th>
                                        <th width="2%" style="text-align:center;vertical-align:middle"></th>
                                        <th width="20%" style="text-align:center;vertical-align:middle">NAMA KEGIATAN</th>
                                        <th width="5%" style="text-align:center;vertical-align:middle">KODE KEG.</th>
                                        <th width="10%" style="text-align:center;vertical-align:middle">TANGGAL</th>
                                        <th width="8%" style="text-align:center;vertical-align:middle">JML. VOUCHER</th>
                                        <th width="12%" style="text-align:center;vertical-align:middle">STS VOUCHER</th>
                                        <th width="4%" style="text-align:center;vertical-align:middle">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <!-- <td colspan="13" style="text-align:center; background-color:#fff !important;">
                                        <div class="alert alert-success" role="alert" style="margin-bottom: 0;"><strong>Empty Data</strong></div>
                                    </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-xs-6">Untuk melihat kode voucer tekan icon <i class='caretIcon fa fa-chevron-circle-down fa-lg' aria-hidden='true'></i></div>
                            <div class="col-xs-6 text-right">
                                <nav aria-label="Page navigation example " id="linkHal1" style="display:block">...</nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>