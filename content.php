<?php
error_reporting(0);
//$dataquser = mysql_fetch_array(mysql_query("SELECT * FROM intrask_user WHERE id_intrask_user = '$_SESSION[iduser]'"));
// Bagian Home
$mod = $_GET['module'];

if ($mod == 'home') {
	include "modul/home.php";
} elseif ($mod == 'klaim') {
	if ($_SESSION['username'] == 'admin') {
		include "modul/klaim_admin.php";
	} else {
		include "modul/klaim_new.php";
	}
} elseif ($mod == 'refund') {
	include "modul/refund.php";
} elseif ($mod == 'download') {
	include "modul/dl.php";
} elseif ($mod == 'klaim_admin') {
	include "modul/klaim_admin.php";
} elseif ($mod == 'user') {
	include "modul/user.php";
} elseif ($mod == 'klaim_new') {
	include "modul/klaim_new.php";
} elseif ($mod == 'upload') {
	include "modul/upload.php";
} elseif ($mod == 'listData') {
	include "modul/listRC.php";
} elseif ($mod == 'rekon') {
	include "modul/table_rekon.php";
} elseif ($mod == 'detail') {
	include "modul/detail_rekon2.php";
} elseif ($mod == 'subroMonitoring') {
	include "modul/subrogasi/dataSubrogasiView.php";
}
// include "modul/subrogasi/subroController.php";
// $controller = new subroController();
// $controller->getListSubro();
else if ($mod == 'batalklaim') {
	include "modul/batalklaim/listBatalKlaimView.php";
} else if ($mod == 'pengembaliandana') {
	include "modul/batalklaim/monitoringPengembalianDanaView.php";
} elseif ($mod == 'subroRejection') {
	include "modul/subrogasi/penolakanSubroView.php";
} elseif ($mod == 'subroUploadRC') {
	include "modul/subrogasi/uploadRCSubroView.php";
} elseif ($mod == 'listRCSubrogasi') {
	include "modul/subrogasi/listRCSubrogasiView.php";
} elseif ($mod == 'listRCReconSubrogasi') {
	include "modul/subrogasi/listRCReconSubrogasiView.php";
} elseif ($mod == 'reportRC') {
	include "modul/subrogasi/listReportRCSubrogasiView.php";
} elseif ($mod == 'doUploadRC') {
	include "modul/subrogasi/upload_rc.php";
} elseif ($mod == 'detailDataRC') {
	include "modul/subrogasi/dataRCSubroView.php";
} elseif ($mod == 'correction') {
	include "modul/subrogasi/correctionSubroView.php";
} elseif ($mod == 'correctionClaim') {
	include "modul/claim/correctionClaimView.php";
} elseif ($mod == 'claimUploadRC') {
	include "modul/claim/uploadRCClaimView.php";
} elseif ($mod == 'claimListRC') {
	include "modul/claim/listRCClaimView.php";
} elseif ($mod == 'detailDataRCClaim') {
	include "modul/claim/listDataRCClaimView.php";
} elseif ($mod == 'claimListReportReconRC') {
	include "modul/claim/listReportReconRCClaimView.php";
} elseif ($mod == 'listRCClaimConfirmation') {
	include "modul/pengajuanclaim/listRCClaimConfirmationView.php";
} elseif ($mod == 'contact_us_general') {
	include "modul/contact_us/general.php";
} elseif ($mod == 'contact_us_wbs') {
	include "modul/contact_us/wbs.php";
} elseif ($_GET['module'] == 'kategori_informasi') {
	include "modul/kategori_informasi/kategori_informasi.php";
} elseif ($_GET['module'] == 'informasi') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/informasi/informasi.php";
} elseif ($_GET['module'] == 'forum') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/forum/forum.php";
} elseif ($_GET['module'] == 'ketentuan') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/ketentuan/ketentuan.php";
} elseif ($_GET['module'] == 'blog') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/blog/blog.php";
} elseif ($_GET['module'] == 'galeri') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/galeri/galeri.php";
} elseif ($_GET['module'] == 'pesan') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/pesan/pesan.php";
} elseif ($_GET['module'] == 'profil') {
	include "modul/profil/profil.php";
} elseif ($_GET['module'] == 'link') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/link/link.php";
} elseif ($_GET['module'] == 'soon') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/soon/soon.php";
} elseif ($_GET['module'] == 'inventaris') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/inventaris/inventaris.php";
} elseif ($_GET['module'] == 'live') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/live/live.php";
} elseif ($_GET['module'] == 'berita_kita') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/berita_kita/berita_kita.php";
} elseif ($_GET['module'] == 'member') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/member/member.php";
} elseif ($_GET['module'] == 'laporan') {
	if ($dataquser['blokir_intrask_user'] == '2') {
		die("<script>alert('Selamat datang di Intranet Askrindo. \\nSilahkan lengkapi data diri Anda dengan benar dan sesuai. \\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['hp_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan nomor HP untuk keperluan Askrindo SMS Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['email_intrask_user'] == '') {
		die("<script>alert('Anda belum mengisikan email untuk keperluan Askrindo Email Services.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	} elseif ($dataquser['foto_intrask_user'] == 'avatar.jpg') {
		die("<script>alert('Anda belum mengubah foto Anda.\\nTerima kasih. \\n\\nIntranet Askrindo.');location.href = 'media.php?module=profil&uid=" . $_SESSION[iduser] . "&p=atur'</script>");
	}
	include "modul/laporan/laporan.php";
} elseif ($_GET['module'] == 'kelas') {
	if ($_SESSION['leveluser'] == 'siswa') {
		include "administrator/modul/mod_kelas/kelas.php";
	}
}