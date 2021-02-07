<?php 

class MYPDF extends TCPDF { 

	public function Header() {        

	}   
	
	public function Footer() {            
	
	}
	
}

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(APP_NAME);
$pdf->SetTitle('Transaksi - Print Pdf');
$pdf->SetSubject('Transaksi - Print Pdf');
$pdf->SetKeywords('Transaksi - Print Pdf');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins('10', '10', '10', '10'); 
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('', '', 11);

$pdf->AddPage();

$html = '<style type="text/css">          
			
			.content{                
				font-size:10px;                
				font-family:"Arial";                
				color:#291576;            
			}  
			.content-1{                
				font-size:11px;                
				font-family:"Arial";            
			}
			.top{               
				border-top:1px solid #000;             
			}            
			
			.left{               
				border-left:1px solid #FFF;            
			}            
			
			.left-black{                
				border-left:1px solid #000;            
			} 
			.right{				
				border-right:1px solid #000;			
			}  
			.bottom{                
				border-bottom:1px solid #000;            
			} 
			</style>';

$html .= '<table width="100%" border="0" height="20%"  cellspacing="0" cellpadding="0">'        
		. '<tr>'            
		.'<td><img src="'.$logo.'"width="100"></td>'            
		.'<td align="right"><br><br><br><label class="content">'.$perusahaan['alamat'].'<br>Telp '.$perusahaan['telp'].' | '.$perusahaan['web'].'</label></td>'        
		. '</tr>'       
		. '</table><br><br><br>';

$html .= '<table class="content-1">
		<tr>
			<th class="left-black top bottom">NO.</th>
			<th class="left-black top bottom">TANGGAL</th>
			<th class="left-black top bottom">INSTANSI</th>
			<th class="left-black top bottom">JENIS DOKUMEN</th>
			<th class="left-black top bottom">PENERIMA</th>
			<th class="left-black top bottom">PENERIMA BARANG</th>
			<th class="left-black top bottom">KEC / DESA</th>
			<th class="left-black top bottom">ALAMAT</th>
			<th class="left-black top bottom">LOKASI</th>
			<th class="left-black top bottom">KETERANGAN</th>
			<th class="left-black top bottom right">CATATAN</th>
		</tr>';

$no = 1;
foreach ($transaksi as $key => $value) {
	$tgl    = tgl_indo($value['trans_tanggal']);

	$html   .= '<tr>'            
	.'<td align="center" class="left-black bottom" height="18">'.$no.'</td>'            
	.'<td class="left-black bottom" align="center">'.$tgl.'</td>'            
	.'<td class="left-black bottom">'.$value['instansi_nama'].'</td>' 
	.'<td class="left-black bottom">'.$value['jdok_nama'].'</td>' 
	.'<td class="left-black bottom">'.$value['trans_penerima'].'</td>'          
	.'<td class="left-black bottom">'.$value['trans_penerima_barang'].'</td>' 
	.'<td class="left-black bottom">'.$value['kec_nama'].'/'.$value['desa_nama'].'</td>' 
	.'<td class="left-black bottom">'.$value['trans_alamat'].'</td>' 
	.'<td class="left-black bottom">'.$value['trans_lokasi'].'</td>' 
	.'<td class="left-black bottom">'.$value['trans_keterangan'].'</td>' 
	.'<td class="left-black bottom right">'.$value['trans_catatan'].'</td>' 
	.'</tr>';   
	$no++;
}
$html   .= '</table><br>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
$pdf->Output('Daftar_Transaksi_Cetak_Pdf.pdf', 'I');