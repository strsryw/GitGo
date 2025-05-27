$(document).ready(function(){
    $(this).on('click', '.caretIcon', function() {
        $(this).toggleClass('fa-chevron-circle-up  fa-chevron-circle-down');
     })
     $("#tblVoucher").on('click','.btnSet',function(e){
        e.preventDefault();
        var dataset=$(this).attr('data-set');
        var url="Laporanvouchers/setnonaktif";
        var dataPecah=dataset.split("|")
        var konfirmasi=confirm("Apakah anda akan menonaktifkan voucher untuk kegiatan\n"+dataPecah[0]+" dengan kode kegiatan "+dataPecah[2]+"?...")
        dataset=dataPecah[0]+dataPecah[1]+dataPecah[2]
        if(konfirmasi){
            $.ajax({
                url:url,
                dataType:"text",
                type:"POST",
                data:({dataset:dataset}),
                async:false,
                success:function(returnVal){
                    if(returnVal=='sukses'){
                        alert('Kode Voucher untuk kode kegiatan "'+dataPecah[2]+'" berhasil dinonaktifkan.');
                        onloadHandler();
                    }else{
                        alert('Kode Voucher gagal di nonaktifkan, harap set nonaktif kembali\nTerima kasih...');
                    }
                }
            })
        }
     })
    $("#filterTglKegiatan").datepicker({
        setDate: new Date(),
        minDate: +1,
        firstDay: 1,
        defaultDate: "d",
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {
            var min = $(this).datepicker('getDate'); // Get selected date
            min.setDate(min.getDate() + 1);
           $("#edVoucher").datepicker('option', 'minDate', min || '0'); // Set other min, default to today
        }
    }); 
    $("#filterEdVoucher").datepicker({
        setDate: new Date(),
        minDate: '0',
        firstDay: 1,
        defaultDate: "d",
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onSelect: function( selectedDate ) {}
    }); 
    // $('#tblVoucher tbody').on('click','.btnPDF', function(e){
    //     // alert('lalalala');
    //     document.Laporanvoucher.action = 'Laporanvouchers/cetakPDF';
    //     document.Laporanvoucher.target ='_blank';
    //     document.Laporanvoucher.submit();

    // });
    
    // $("#btnSimpan").on('click',function(e){
    //     e.preventDefault();
    //     var  namaKegiatan=document.getElementById('namaKegiatan').value;
    //     var  tglKegiatan=document.getElementById('tglKegiatan').value;
    //     var  jmlVoucher=document.getElementById('jmlVoucher').value;
    //     var  nilaiVoucher=document.getElementById('nilaiVoucher').value;
    //     var  edVoucher=document.getElementById('edVoucher').value;

    //     if(namaKegiatan==''){
    //         alert('Isikan nama kegiatan');
    //         $("#namaKegiatan").focus();
    //         return
    //     }
    //     if(tglKegiatan==''){
    //         alert('Isikan tanggal kegiatan');
    //         $("#tglKegiatan").focus();
    //         return
    //     }
    //     if(jmlVoucher==''){
    //         alert('Isikan jumlah voucher');
    //         $("#jmlVoucher").focus();
    //         return
    //     }
    //     if(nilaiVoucher==''){
    //         alert('Isikan nilai voucher');
    //         $("#nilaiVoucher").focus();
    //         return
    //     }
    //     if(edVoucher==''){
    //         alert('Isikan expired date voucher');
    //         $("#edVoucher").focus();
    //         return
    //     }

    //     var url="Laporanvouchers/simpan";
    //     var konfirmasi=confirm("Apakah data yang diinputkan sudah benar?...");
    //     if(konfirmasi){
    //         $.ajax({
    //             url:url,
    //             type:"post",
    //             dataType:"text",
    //             async:false,
    //             data:({
    //                 namaKegiatan:namaKegiatan,
    //                 tglKegiatan:tglKegiatan,
    //                 jmlVoucher:jmlVoucher,
    //                 nilaiVoucher:nilaiVoucher,
    //                 edVoucher:edVoucher
    //             }),
    //             success:function(returnVal){
    //                 //console.log(returnVal);return
    //                 if(returnVal=='sukses'){
    //                     alert('Kode Voucher berhasil di generate');
    //                     onloadHandler();
    //                 }else{
    //                     alert('Kode Voucher gagal di generate, harap generate ulang\nTerima kasih...');
    //                 }
                    
    //             }
    //         })
    //     }
    // })
    onloadHandler();
    // $('#btnTes').on('click', function(e){
    //     // var output = 'Laporanvisitrekaps/cetakEx';
    //     document.Laporanvoucher.action = 'Laporanvouchers/cetakPDF';
    //     document.Laporanvoucher.target ='_blank';
    //     document.Laporanvoucher.submit();
    // });
});
function onloadHandler(){
    // document.getElementById('namaKegiatan').value='';
    // document.getElementById('tglKegiatan').value='';
    // document.getElementById('jmlVoucher').value='';
    // document.getElementById('nilaiVoucher').value='';
    // document.getElementById('edVoucher').value='';
    getData(1);
    // getKodeVoc();
}

function getData(hal){
    curHal=hal;
    filterNamaKegiatan = document.getElementById('filterNamaKegiatan').value;
    filterTglKegiatan = document.getElementById('filterTglKegiatan').value;
    filterJmlVoucher = document.getElementById('filterJmlVoucher').value;
    filterNilaiVoucher = document.getElementById('filterNilaiVoucher').value;
    filterEdVoucher = document.getElementById('filterEdVoucher').value;
    // console.log(filterNamaKegiatan);
    // console.log(filterTglKegiatan);
    // console.log(filterJmlVoucher);
    // console.log(filterNilaiVoucher);
    // console.log(filterEdVoucher);
    // alert(filterNamaKegiatan);
    //console.log(txtPelanggaranBBF)
    var url="Laporanvouchers/getData";

    $.ajax({
        url:url,
        type:"POST",
        data:({filterNamaKegiatan:filterNamaKegiatan,
            filterTglKegiatan:filterTglKegiatan,
            filterJmlVoucher:filterJmlVoucher,
            filterNilaiVoucher:filterNilaiVoucher,
            filterEdVoucher:filterEdVoucher,
            hal:hal,
            fungsi:'getData'}),
            dataType: "text",
        success:function(result){
            // console.log(result);return
            result=result.split("!");
            $('#tblVoucher').children('tbody:first').html(result[0]);
            if(result[1].trim().length!=0){
                document.getElementById('linkHal1').style.display='';
                document.getElementById('linkHal1').innerHTML=result[1];
            }else{
                document.getElementById('linkHal1').style.display='none';
            }
        }
    })
    
}
function getKodeVoc(idRecord){ //filter kode voucher
    // alert(idRecord);
    // idRecord = $(this).attr('data-id');
    console.log(idRecord); 
    
    var filterKodeVoc = document.getElementById('filterKodeVoc'+idRecord).value;
    // alert(filterKodeVoc);
    var url = 'Laporanvouchers/getKodeVoc';
    $.ajax({
        url:url,
        type:'post',
        data:({idRecord:idRecord,
            filterKodeVoc:filterKodeVoc}),
        dataType:'text',
        success:function(result){
            console.log(result);
        }
    });
   
}
function cetakPDF(idRecord,kegiatan){
    // alert('tes');
    var url = 'Laporanvouchers/cetakPDF';
    console.log(idRecord);
    console.log(kegiatan);
    document.Laporanvoucher.action = url;
    document.Laporanvoucher.target ='_blank';
    document.Laporanvoucher.submit();
}

function colorin(x) {
    x.style.color = "#00516f";
}

function normalcolor(x) {
    x.style.color = "#66A594";
}
function upAngka(str){
	if(str.value=="-"){
		str.value=0;
		}
	if(parseInt(str.value)<0){
		str.value=str.value*(-1);
		}

	var re = /^[0-9-',']*$/;
	if (!re.test(str.value)) {
		str.value = str.value.replace(/[^0-9-',']/g,"");
				
	}
	if(str.value==""||str.value=="NaN"){
		str.value=""
	}else{
	str.value=formatCurrency(str.value,",",".", 0)
	//formatNumberField(str);
	}
	//hitungHargaSat(str,itemId)
}

function formatCurrency(amount, decimalSeparator, thousandsSeparator, nDecimalDigits){  
	amount=amount+'';
	amount=amount.replace(",",".");
    var num = parseFloat( amount ); //convert to float  

    //default values  
    decimalSeparator = decimalSeparator || '.';  
    thousandsSeparator = thousandsSeparator || ',';  
    nDecimalDigits = nDecimalDigits == null? 2 : nDecimalDigits;  
  
    var fixed = num.toFixed(nDecimalDigits); //limit or add decimal digits  
    //separate begin [$1], middle [$2] and decimal digits [$4]  
    var parts = new RegExp('^(-?\\d{1,3})((?:\\d{3})+)(\\.(\\d{' + nDecimalDigits + '}))?$').exec(fixed);   
 
    if(parts){ //num >= 1000 || num < = -1000  
        return parts[1] + parts[2].replace(/\d{3}/g, thousandsSeparator + '$&') + (parts[4] ? decimalSeparator + parts[4] : '');  
    }else{  
        return fixed.replace('.', decimalSeparator);  
    }  
} 