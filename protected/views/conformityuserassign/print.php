
<?php
// echo "<img src='/uploads/grafik/".$_POST['grafik']."' border='0'>";

$ilkclient=$_POST['cbid'];
$startdate=strTotime("01.01.2019");
$finishdate=time();

if(isset($_GET) && isset($_GET['type']) && isset($_GET['firmid']) && isset($_GET['branchid']) && isset($_GET['clientid']) && isset($_GET['clientbranchid']))
{
  $ax= User::model()->userobjecty('');
  $ax->type=$_GET['type'];
  $ax->firmid=$_GET['firmid'];
  $ax->branchid=$_GET['branchid'];
  $ax->clientid=$_GET['clientid'];
  $ax->clientbranchid=$_GET['clientbranchid'];
  $ilkclient=$_GET['clientbranchid'];
  $startdate=strTotime(date("d.m.y",strtotime("-7 day")));

  //$startdate=strTotime("01.01.2019");
}
else {
  User::model()->login();
  $ax= User::model()->userobjecty('');
}

if(isset($_POST['startdate']))
{
   $startdate=strTotime($_POST['startdate'].' 00:00:00');
}

if(isset($_POST['finishdate']))
{
    $finishdate=strTotime($_POST['finishdate'].' 23:59:59');
}
if($ax->type==26)
{
  $userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$ax->clientbranchid));
}
else if($ax->type==27)
{
  $userss=User::model()->findAll(array("condition"=>"id=".$ax->id));

}
else if($ax->type==22)
{
  $userss=User::model()->findAll(array("condition"=>"firmid=".$ax->firmid." and branchid=".$ax->branchid." and clientid=".$ax->clientid." and clientbranchid=".$ilkclient));
}

$useridd=$userss[0]->id;



foreach($userss as $userssx)
	{

														$aciksay=0;
														$kapalisay=0;
														$bekliyorsay=0;
														$conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate,"order"=>"sendtime asc","group"=>"conformityid"));
														$say+= count($conformityuserassign);
														
														if($conformityuserassign)
														{
															$uygunsuzlukBas='';
															
															$acikUygunsuzluklarTr='';
															$bekliyenUygunsuzluklarTr='';
															$kapaliUygunsuzluklarTr='';
															foreach($conformityuserassign as $conformityuserassignx)
															{
																$conformity=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid,"order"=>"id desc"));

																$gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
																$deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));
		
																	if(!$gerigonderme)
																	{
																		$conformityname=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid));
																		$status=intval($conformity->statusid);
																		
																		$uygunsuzlukBas.="<tr>";
																			$uygunsuzlukBas.="<td>".(($userssx->name=='' && $userssx->surname=='')?$userssx->username:$userssx->name.' '.$userssx->surname)."</td>";
																			$uygunsuzlukBas.="<td>".$conformityname->numberid."</td>";
																			$depart=Departments::model()->find(array('condition'=>'id='.$conformityname->departmentid));
																			
																			$uygunsuzlukBas.="<td>".($depart?$depart->name:'-')."</td>";
																			if($conformityname->subdepartmentid!=='' && $conformityname->subdepartmentid!==null)
																			{
																						$subdepart=Departments::model()->find(array('condition'=>'id='.$conformityname->subdepartmentid));
																					$uygunsuzlukBas.="<td>".($subdepart?$subdepart->name:'-')."</td>";
																				
																			}
																			$uygunsuzlukBas.="<td>".$conformityname->definition."</td>";	
																			$uygunsuzlukBas.="<td>".$conformityname->definition."</td>";	
																			$uygunsuzlukBas.="<td>".$conformityname->suggestion.' '.t('Degree')."</td>";	
																			$uygunsuzlukBas.="<td>".date('d-m-Y',$conformityuserassignx->sendtime)."</td>";
																			
																		if(in_array($status,[5]))
																		{
																			$aciksay++;
																				
																			$uygunsuzlukBas.="<td>1</td>";	
																			$uygunsuzlukBas.="<td>0</td>";	
																			$uygunsuzlukBas.="<td>0</td>";
																		}
																		if(in_array($status,[2,3,4,6]))
																		{
																			$bekliyorsay++;
																			$uygunsuzlukBas.="<td>0</td>";	
																			$uygunsuzlukBas.="<td>1</td>";	
																			$uygunsuzlukBas.="<td>0</td>";
																		}
																		
																			if(in_array($status,[1]))
																			{
																				$kapalisay++;
																				$uygunsuzlukBas.="<td>0</td>";	
																					$uygunsuzlukBas.="<td>0</td>";
																					$uygunsuzlukBas.="<td>1</td>";	
																			}
																			
																			$uygunsuzlukBas.="</tr>";
																	}
															}
															$acikuy1=$aciksay;
															$bekleyenuy1=$bekliyorsay;
															$kapaliuy1=$kapalisay;
															$toplam1=$aciksay+$kapalisay+$bekleyenuy1;
															$yaz .= $uygunsuzlukBas;
														
														}
															
															$yaz .='<tr>
																<td style="color: red;">';
																
																if($userssx->name=='' && $userssx->surname==''){
																	$yaz .= $userssx->username;
																	}else{
																		$yaz .= $userssx->name.' '.$userssx->surname;
																		}
																		$yaz .=' '.t('Toplam');
																		$yaz .='</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td style="color: red;">'.$acikuy1.'</td>
																<td style="color: red;">'.$bekleyenuy1.'</td>
																<td style="color: red;">'.$kapaliuy1.'</td>
															</tr>';
														
															
													}
													
													
													
													
// foreach($userss as $userssx)
// {

  // $aciksay=0;
  // $kapalisay=0;

  // $conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"recipientuserid=".$userssx->id." and returnstatustype=1 and sendtime>=".$startdate." and sendtime<=".$finishdate,"order"=>"id desc","group"=>"conformityid"));
  // if($conformityuserassign)
  // {

    // foreach($conformityuserassign as $conformityuserassignx)
    // {
      // $gerigonderme=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
      // $deadlineverme=Conformityactivity::model()->findAll(array("condition"=>"conformityid=".$conformityuserassignx->conformityid));

      // if((!$gerigonderme && !$deadlineverme) || (!$gerigonderme && $deadlineverme))
      // {
        // $conformityname=Conformity::model()->find(array("condition"=>"id=".$conformityuserassignx->conformityid));
        // $usernamesurname='';
        // $depName='';
        // $subName='';
        // $conUser=0;
        // $conUser2=0;
        // $conresim='';
      // if($userssx->name=='' && $userssx->surname==''){$usernamesurname=$userssx->username;}else{$usernamesurname=$userssx->name.' '.$userssx->surname;}
      // $depart=Departments::model()->find(array('condition'=>'id='.$conformityname->departmentid));
      // if($depart){$depName=$depart->name;}else {$depName='-';}
      // $subdepart=Departments::model()->find(array('condition'=>'id='.$conformityname->subdepartmentid));
      // if($subdepart){$subName=$subdepart->name;}else {$subName='-';}
      // $conformityuserassign=Conformityuserassign::model()->findAll(array("condition"=>"parentid=".$conformityuserassignx->id));
      // if($conformityuserassign){$conUser=0;}else {$conUser=1;}
      // if($conformityuserassign){$conUser2=1;}else {$conUser2=0;}
      // if($conformityname->filesf)
      // {
          // $conresim=$conformityname->filesf;
      // }
      // else{
      	// $conresim="/images/nophoto.png";
      // }

      // if(!$gerigonderme && !$deadlineverme)
      // {
        // $aciksay++;
      // }

      // if(!$gerigonderme && $deadlineverme)
      // {
        // $kapalisay++;
      // }
      // }
      // $acikuy1=$aciksay;
      // $kapaliuy1=$kapalisay;
      // $toplam1=$aciksay+$kapalisay;
        // $yaz .="<tr>
        // <td colspan='5'>".$usernamesurname."</td>
        // <td colspan='2'>".$conformityname->numberid."</td>
        // <td colspan='2'>".$depName."</td>
        // <td colspan='2'>".$subName."</td>
        // <td colspan='2'>".$conformityname->definition."</td>
        // <td colspan='2'>".$conformityname->suggestion."</td>
        // <td colspan='1'>".$conformityname->priority.' '.t('Degree')."</td>
        // <td colspan='1'>".date('d-m-Y',$conformityuserassignx->sendtime)."</td>
        // <td colspan='1'>".$conUser."</td>
        // <td colspan='1'>".$conUser2."</td>
      // </tr>";
    // }
      // $yaz .="<tr>
      // <td style='color: red;' colspan='5'>".$usernamesurname." ".t('Toplam')."</td>
      // <td colspan='2'></td>
      // <td colspan='2'></td>
      // <td colspan='2'></td>
      // <td colspan='2'></td>
      // <td colspan='2'></td>
      // <td colspan='1'></td>
      // <td colspan='1'></td>
      // <td style='color: red;' colspan='1'>".$acikuy1."</td>
      // <td style='color: red;' colspan='1'>".$kapaliuy1."</td>
    // </tr>";

  // }
// }







$clientparent=Client::model()->findByPk($ilkclient);
$clientparent=Client::model()->findByPk($clientparent->parentid);
$client=Client::model()->findByPk($ilkclient);
if($firm->image)
{
    $resim=$firm->image;
}
else if($clientparent->image)
{
	$resim=$clientparent->image;
}
else{
	$resim="/images/nophoto.png";
}

$grafikimg="<img src='/uploads/grafik/".$_POST['grafik']."' border='0'>";

/*<meta http-equiv="Content-Type" content="text/html; charset=utf-8">*/
$html="<html><head></head><body><style>
.f12
{
	font-size:12px;
}td,th{
	border:1px solid #333333;

}
th {
font-family:Arial;
}
td {
font-family:Arial;
}
</style><table border='0'  width='100%' cellpadding='0' cellspacing='0'>
                        <thead>

                        <tr>
                          <td width='100' align='center' colspan='3'>
                             <img src='".$resim."' border='0' width='75px'>
                          </td>
                          <td colspan='17' align='center'>
                            <b><h2>".t('Açık ve kapalı uygunsuzluk raporu')."</h2></b>
                          </td>
                        </tr>
                        <tr>
                          <td colspan='20'>".t('Client Name')." : <b>".$clientparent->name."</b></td>
                        </tr>

                        <tr>
                          <td colspan='20'>".t('Date').":".Date('Y-m-d',$startdate).' / '.Date('Y-m-d',$finishdate)."</td>
                        </tr>
                          <tr>
                          <th colspan='5'>".t('ATANAN YETKİLİ ADI')."</th>
                          <th colspan='2'>".t('NON-CONFORMITY NO')."</th>
                          <th colspan='2'>".t('DEPARTMENT')."</th>
                          <th colspan='2'>".t('SUB-DEPARTMENT')."</th>
                          <th colspan='2'>".t('TANIM')."</th>
                          <th colspan='2'>".t('ÖNERİ')."</th>
                          <th colspan='1'>".t('ÖNCELİK')."</th>
                          <th colspan='1'>".t('UYGUNSUZLUK ATAMA TARİHİ')."</th>
                          <th colspan='1'>".t('Açık Uygunsuzluk')."</th>
						  <th colspan='1'>".t('Bekleyen Uygunsuzluklar')."</th>
                          <th colspan='1'>".t('Kapalı Uygunsuzluk')."</th>
                          </tr>
                        </thead>
                        <tbody>
                         ".$yaz."
                        </tbody>
                      </table>";
					  ?>
