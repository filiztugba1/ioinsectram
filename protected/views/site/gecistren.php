  <form action="?" method="get">
    
    <label for="firm">Firma Seçin<label>
    <select name="firm" id="firm">
      <option value="1">1-Safran( branchlar dahil )</option>
    </select>
<br><br>
    <label for="monitor">Monitör Tipi<label>
    <select name="monitor" id="monitor">
      <option value="6x27">CI(6) => ID(27)</option>
      <option value="12x19">LFT(12) => EFK(19)</option>
      <option value="10x25">RM(10) => RM - TOXIC(25)</option>
      <option value="8x23">LT(8) => LT - GLUEBOARD(23)</option>
    <!--  <option value="9x20">MT(9) =>  X-Lure(20)</option>-->
    </select>
      <br>
      <br>
      
    <input type="submit" value="Submit">
</form>
<br>   
    
<?php
      ini_set('memory_limit', '25G');
   ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
      if (isset($_GET['monitor'])){        /// post edildiyse
//Önce firm ve branch idleri aldık
        $firm=Firm::model()->findAll(array('condition'=>'id='.$_GET['firm'].' or parentid='.$_GET['firm']));
        $firmarr=[];
        foreach ($firm as $item){
          $firmarr[]=$item->id;
        }
//adığımız firm ve branch idler ile client ve client branchları aldık
        $firmarr=implode(',',$firmarr);
        $clients=Client::model()->findAll(array('condition'=>'mainfirmid in ('.$firmarr.') or firmid in ('.$firmarr.')'));
        $clientsarr=[];
        foreach ($clients as $item2){
          $clientsarr[]=$item2->id;
        }
        $clientsarr=implode(',',$clientsarr);
        
        
        
 // aldığımız client listesi ile Monitoring sayfasından veri çekiyoruz       
        $changes=$_GET['monitor'];
        $changes=explode('x',$changes);
        /////CI 6-> ID 27
        $monitoring=Monitoring::model()->findAll(array('condition'=>'mtypeid='.$changes[0].' and clientid in ('.$clientsarr.') '));
        foreach ($monitoring as $monitor){
          ///CI bulunursa bunları yap
          if ($monitor->mtypeid==6){
            $monitor->mtypeid=27;
            $monitor->update();
               //echo '<br><br>';
          }
          
              ///lft bulunursa bunları yap
          if ($monitor->mtypeid==12){
            $monitor->mtypeid=19;
            $monitor->update();
               //echo '<br><br>';
          }
          
              ///RM bulunursa bunları yap
          if ($monitor->mtypeid==10){
            $monitor->mtypeid=25;
            $monitor->update();
               //echo '<br><br>';
          }
              ///LT bulunursa bunları yap
          if ($monitor->mtypeid==8){
            $monitor->mtypeid=23;
            $monitor->update();
               //echo '<br><br>';
          }
          
              ///MT bulunursa bunları yap
       /*   if ($monitor->mtypeid==9){
            $monitor->mtypeid=20;
            $monitor->update();
               //echo '<br><br>';
          }*/
          
          ///Başka bulunursa bulunursa bunları yap
          //   //print_r($monitor);
        }
        
        
        
        
        
        $mobileworkordermonitors=Mobileworkordermonitors::model()->findAll(array('condition'=>'monitortype='.$changes[0].' and clientid in ('.$clientsarr.') and clientbranchid in ('.$clientsarr.') '));
       // //print_r($mobileworkordermonitors);
        foreach ($mobileworkordermonitors as $mobileworkordermonitor){
          ///CI bulunursa bunları yap
          if ($mobileworkordermonitor->monitortype==6){
            $mobileworkordermonitor->monitortype=27;
            $mobileworkordermonitor->update();
            //print_r($mobileworkordermonitor);
               //echo '<br><br>';
          }
          ///LFT bulunursa bunları yap
          if ($mobileworkordermonitor->monitortype==12){
            $mobileworkordermonitor->monitortype=19;
            $mobileworkordermonitor->update();
            //print_r($mobileworkordermonitor);
               //echo '<br><br>';
          }
          ///RM bulunursa bunları yap
          if ($mobileworkordermonitor->monitortype==10){
            $mobileworkordermonitor->monitortype=25;
            $mobileworkordermonitor->update();
            //print_r($mobileworkordermonitor);
               //echo '<br><br>';
          }
          ///LT bulunursa bunları yap
          if ($mobileworkordermonitor->monitortype==8){
            $mobileworkordermonitor->monitortype=23;
            $mobileworkordermonitor->update();
            //print_r($mobileworkordermonitor);
               //echo '<br><br>';
          }
           /*  
          ///MT bulunursa bunları yap
          if ($mobileworkordermonitor->monitortype==9){
            $mobileworkordermonitor->monitortype=20;
            $mobileworkordermonitor->update();
            //print_r($mobileworkordermonitor);
               //echo '<br><br>';
          }*/
          
                    
          ///Başka bulunursa bulunursa bunları yap
       //   //print_r($monitor);
        }
        
        
        
        
        
        $mobileworkorderdatas=Mobileworkorderdata::model()->findAll(array('condition'=>'monitortype='.$changes[0].' and clientid in ('.$clientsarr.') and clientbranchid in ('.$clientsarr.') '));
       // //print_r($mobileworkordermonitors);
        foreach ($mobileworkorderdatas as $mobileworkorderdata){
          ///CI bulunursa bunları yap
          if ($mobileworkorderdata->monitortype==6){
            $mobileworkorderdata->monitortype=27;
            if ($mobileworkorderdata->petid==23){/// Sark
              $mobileworkorderdata->petid=81;
            }
            
            $mobileworkorderdata->update();
            //print_r($mobileworkorderdata);
               //echo '<br><br>';
          }
               ///LFT bulunursa bunları yap
          if ($mobileworkorderdata->monitortype==12){
            $mobileworkorderdata->monitortype=19;
            
            if ($mobileworkorderdata->petid==26){/// karasinek
              $mobileworkorderdata->petid=73;
            }
            
            if ($mobileworkorderdata->petid==28){/// güve
              $mobileworkorderdata->petid=76;
            }
            
            if ($mobileworkorderdata->petid==30){/// arı
              $mobileworkorderdata->petid=75;
            }
            
            if ($mobileworkorderdata->petid==32){/// kelebek
              $mobileworkorderdata->petid=77;
            }
            
            $mobileworkorderdata->update();
            //print_r($mobileworkorderdata);
               //echo '<br><br>';
          }
                    
             ///RM bulunursa bunları yap
          if ($mobileworkorderdata->monitortype==10){
            $mobileworkorderdata->monitortype=25;

            $mobileworkorderdata->update();
            //print_r($mobileworkorderdata);
               //echo '<br><br>';
          }
          
             ///RM bulunursa bunları yap
          if ($mobileworkorderdata->monitortype==8){
            $mobileworkorderdata->monitortype=23;

            $mobileworkorderdata->update();
            //print_r($mobileworkorderdata);
               //echo '<br><br>';
          }
          
          ///Başka bulunursa bulunursa bunları yap
       //   //print_r($monitor);
        }
        /*
                  ///MT bulunursa bunları yap
          if ($mobileworkorderdata->monitortype==9){
            $mobileworkorderdata->monitortype=20;
            
            if ($mobileworkorderdata->petid==45){/// pirinç biti
              $mobileworkorderdata->petid=99;
            }
            
            if ($mobileworkorderdata->petid==46){/// testereli böcek
              $mobileworkorderdata->petid=101;
            }
            
            if ($mobileworkorderdata->petid==47){/// tatlı kurt
              $mobileworkorderdata->petid=91;
            }
            
            $mobileworkorderdata->update();
            //print_r($mobileworkorderdata);
               //echo '<br><br>';
          }
        
        */
        
        
        // monitoring //
        //print_r($_GET);
        //echo '<br><br>';
        //print_r($firmarr);
        //echo '<br><br>';
        //print_r($clientsarr);
        //echo '<br><br>';
        //  //print_r($monitoring);
        
        
      }
  


?>