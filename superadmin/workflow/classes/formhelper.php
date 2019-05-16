<?php 
class Form{
	public $request=array();
	public $errordata=array();
	public $inputname=array();
	public $extattr=array();
	public $attr=array(
	
			'type'=>'text',
			'value'=>'',
			'id'=>'',
			'class'=>array(),
			'options'=>array(),
		
	);
	
	function __construct(){
		global $requestdata,$errorformdata;		
		$this->request = $_REQUEST;               
		$this->errordata=$errorformdata;
                
	}
	
	
	function input($name,$attr=array(),$extattr=array()){	
	$html='';
		if(empty($name))
			return false;
		$this->inputname=$name;
		if(!empty($attr))
			$this->attr=$attr;			
		if(!empty($this->request[$name]))
			$this->attr['value']=$this->request[$name];
		if(!empty($extattr))
			$this->extattr=$extattr;
			
		$html .='<div class="input '.$this->attr['type'].'">';
		$html .=$this->inputField();
		if(!empty($this->errordata[$this->inputname])){
			$html .='<span class="error-message">'.$this->errordata[$this->inputname].'</span>';
			
		}
		$html .='</div>';
		return	$html;
	}
	
	private function inputField(){	
		
		if($this->attr['type']=='select')
			return $this->inputSelect();
		else if($this->attr['type']=='textarea')
			return $this->inputTextarea();
		else if($this->attr['type']=='checkbox')
			return $this->inputcheckbox();
		else if($this->attr['type']=='radio')
			return $this->inputradio();
		else
			return $this->inputnormal();
		
		
	}
	
	private function inputnormal(){
		$html='';
		$attr='';
		
		$attr=$this->makeAttributeString($this->removeAttribute($this->attr,array('options')));
		
		$html .='<input '.$attr.' name="'.$this->inputname.'" >';
		return $html;
		
	}
	private function inputSelect(){
		$html=$attr='';	
		$value=$this->attr['value'];
		$selectvalue=!empty($this->attr['selected'])?$this->attr['selected']:'';
		if(empty($this->request[$this->inputname]) AND !empty($selectvalue))
			$this->request[$this->inputname]=$selectvalue;
		$attr=$this->makeAttributeString($this->removeAttribute($this->attr,array('options','type','value','selected')));
		$html .='<select '.$attr.' name="'.$this->inputname.'">';
		if(!empty($this->attr['empty']))
		$html .='<option value="">'.$this->attr['empty'].'</option>';
		if(!empty($this->attr['options'])){			
			foreach($this->attr['options'] as $k=>$val){
				$select='';
				if($this->request[$this->inputname]==$k){
					$select='selected="selected"';					
				}
								
				$html .='<option value="'.$k.'" '.$select.'>'.$val.'</option>';
			}
		}		
		$html .='</select>';
		return $html;
		
		
	}
	private function inputTextarea(){
		
		$html='';
		$attr=$value='';
		
		$attr=$this->makeAttributeString($this->removeAttribute($this->attr,array('options','value')));
		if(!empty($this->request[$this->inputname]))
			$value=$this->request[$this->inputname];
		elseif($this->attr['value'])
			$value=$this->attr['value'];		
		$html .='<textarea '.$attr.' name="'.$this->inputname.'" >'.$value.'</textarea>';
		
		return $html;
	}
	private function inputradio(){		
		$html='';
		$attr=$value='';
		$options=$this->attr['options'];
		$checked=!empty($this->attr['checked'])?$this->attr['checked']:'';
		$attr=$this->makeAttributeString($this->removeAttribute($this->attr,array('options','value')));
		if(!empty($this->request[$this->inputname]))
			$value=$this->request[$this->inputname];
		elseif(!empty($checked))
			$value=$checked;
                
                if(!empty($options)){
                     
                    foreach($options as $k=>$option){
                          $check=(in_array($k,$value))?'checked="checked"':'';
                        $html .='<label>'.$option.'</label><input type="radio" '.$attr.' name="'.$this->inputname.'"  value="'.$k.'"  '.$check.'>';
                    }
                }
		
		
		return $html;
	}
	private function inputcheckbox(){
		
		$html='';
		$attr=$value='';
		$options=$this->attr['options'];
		$checked=!empty($this->attr['checked'])?$this->attr['checked']:'';

		$attr=$this->makeAttributeString($this->removeAttribute($this->attr,array('options','value','checked')));
		if(!empty($this->request[$this->inputname]))
			$value[]=$this->request[$this->inputname];		
		elseif(!empty($checked))
			$value=$checked;

                if(!empty($options)){
                     
                    foreach($options as $k=>$option){
                        $check=(in_array($k,$value))?'checked="checked"':'';
                        $html .='<label>'.$option.'</label><input type="checkbox" '.$attr.' name="'.$this->inputname.'[]"  value="'.$k.'"  '.$check.'>';
                    }
                }
		
		
		return $html;
	}
	
private function removeAttribute($attr=array(),$remove=array()){
		
		if(!empty($attr) AND !empty($remove)){			
			foreach($remove as $val){
				
				unset($attr[$val]);
			}
		}
		
		return $attr;
		
	}
	
	private function makeAttributeString($attr){
		$str='';
		if(!empty($attr)){
			
			foreach($attr as $k=>$val){
				
				if(!is_array($val)){
					
					$str .=$k.'="'.$val.'"';
					
				}
			}
		}
		
		return $str;
	}
	
	
}
global $requestdata;
$FormHelper= new Form();

?>
