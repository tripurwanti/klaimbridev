<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$tgl_skrg     = date("d");
$bln_sekarang = date("m");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");

/*$loadurl = "http://localhost/askrindowebnew/p2/new/";*/
//$loadurl = "http://localhost/askrindowebnew/p2/new/"; //-> HTTP
$loadurl = "https://localhost/askrindowebnew/p2/new/"; //-> HTTPS

function lang($paramlang, $fieldid, $fielden){
	if ($paramlang=='id') {
		return $fieldid;
	} else {
		return $fielden;
	}
}

function urlpost($string) {
	$kecilin = strtolower($string);
	return preg_replace('/[^A-Za-z0-9]/','-',$kecilin);
}

/*untuk menu dan segala isinya yang berkaitan dengan perubahan bahasa*/
$txtmenuberanda = 				lang($_GET[lang], 'Beranda', 'Home');
$txtmenutentangkami =			lang($_GET[lang], 'Tentang Kami', 'About Us');
$txtmenuanajemen = 				lang($_GET[lang], 'Manajemen', 'Management');
$txtmenuperusahaan =			lang($_GET[lang], 'Perusahaan', 'Company');
$txtmenuvisimisi = 				lang($_GET[lang], 'Visi & Misi', 'Vision & Mission');
$txtmenubudayaperusahaan =		lang($_GET[lang], 'Budaya Perusahaan', 'Corporate Culture');
$txtmenumaknalogo =				lang($_GET[lang], 'Makna Logo', 'Logo Meaning');
$txtmenustruktur =				lang($_GET[lang], 'Struktur Organisasi', 'Organizational Structure');
$txtmenutanggungjawab = 		lang($_GET[lang], 'Tanggung Jawab Sosial Perusahaan', 'Corporate Social Responsibility');
$txtmenumars =	 				lang($_GET[lang], 'Mars Askrindo', 'Askrindo Anthem');
$txtmenuanakperusahaan =		lang($_GET[lang], 'Anak Perusahaan', 'Of Subsidiaries');
$txtmenugalerifoto =			lang($_GET[lang], 'Galeri Foto', 'Photo Gallery');
$txtmenukinerja = 				lang($_GET[lang], 'Kinerja', 'Performance');
$txtmenukeuangan = 				lang($_GET[lang], 'Keuangan', 'Financial');
$txtmenulapikhtisar = 			lang($_GET[lang], 'Laporan Ikhtisar', 'Financial Highlights');
$txtmenulapkeuanganberjalan = 	lang($_GET[lang], 'Laporan Keuangan Berjalan', 'Financial Report');
$txtmenulaptahunan = 			lang($_GET[lang], 'Laporan Tahunan', 'Annual Report');
$txtmenupenghargaan = 			lang($_GET[lang], 'Penghargaan', 'Award');
$txtmenugcg = 					lang($_GET[lang], 'GCG', 'GCG');
$txtmenuwbs = 					lang($_GET[lang], 'WBS', 'WBS');
$txtmenukpku = 					lang($_GET[lang], 'KPKU', 'KPKU');
$txtmenuproduk = 				lang($_GET[lang], 'Produk', 'Product');
$txtmenupenjaminankur = 		lang($_GET[lang], 'Penjaminan KUR', 'KUR Guarantee');
$txtmenuasuransikredit = 		lang($_GET[lang], 'Asuransi Kredit', 'Credit Insurance');
$txtmenusuretybond = 			lang($_GET[lang], 'Surety Bond', 'Surety Bond');
$txtmenuaskredag = 				lang($_GET[lang], 'Askredag', 'Credit Management Services');
$txtmenureasuransi = 			lang($_GET[lang], 'Reasuransi', 'Reinsurance');
$txtmenuasuransiumum = 			lang($_GET[lang], 'Asuransi Umum', 'General Insurance');
$txtmenucustomsbond = 			lang($_GET[lang], 'Customs Bond', 'Customs Bond');
$txtmenukontrabankgaransi = 	lang($_GET[lang], 'Kontra Bank Garansi', 'Guarantee Bank');
$txtmenukantor = 				lang($_GET[lang], 'Kantor', 'Office');
$txtmenukantorpelayanan = 		lang($_GET[lang], 'Kantor Pelayanan', 'Branch Office');
$txtmenureferensi = 			lang($_GET[lang], 'Referensi', 'Reference');
$txtmenukliping = 				lang($_GET[lang], 'Kliping', 'Clipping');
$txtmenuundang2terkait = 		lang($_GET[lang], 'Undang-undang Terkait', 'Legislation Related');
$txtmenuartikel = 				lang($_GET[lang], 'Artikel', 'Article');
$txtmenuhubungikami = 			lang($_GET[lang], 'Hubungi Kami', 'Contact Us');
$txtmenupetalokasi = 			lang($_GET[lang], 'Peta Lokasi', 'Location Map');
$txtmenupeluang = 				lang($_GET[lang], 'Peluang', 'Opportunity');
$txtmenukarir = 				lang($_GET[lang], 'Lowongan Kerja', 'Job Vacancy');
$txtmenupengadaanbarang = 		lang($_GET[lang], 'Pengadaan Barang', 'Procurement');
$txtmenubalinntb =	 			lang($_GET[lang], 'Wilayah Bali dan NTB', 'Region Bali and NTB');
$txtmenujawa =		 			lang($_GET[lang], 'Wilayah Jawa', 'Region Jawa');
$txtmenukalimantan = 			lang($_GET[lang], 'Wilayah Kalimantan', 'Region Kalimantan');
$txtmenumalukunpapua = 			lang($_GET[lang], 'Wilayah Maluku dan Papua', 'Region Maluku and Papua');
$txtmenusulawesi =	 			lang($_GET[lang], 'Wilayah Sulawesi', 'Region Sulawesi');
$txtmenusumatra =	 			lang($_GET[lang], 'Wilayah Sumatra', 'Region Sumatra');
$txtmenumitrakerja =	 		lang($_GET[lang], 'Mitra Kerja', 'Partners');
$txtmenubkr =	 				lang($_GET[lang], 'Bank Rekanan', 'Bank Partners');
$txtmenublr =	 				lang($_GET[lang], 'Bengkel Rekanan', 'Workshop Partners');
$txtmenureasuradur =	 		lang($_GET[lang], 'Reasuradur', 'Reasuradur');
$txtmenupemeringkatan =	 		lang($_GET[lang], 'Pemeringkatan', 'Rating');

?>
