<?php
class Form
{
	
	public $controller; 
	public $errors;
	public $data; 

	public function __construct($controller=null)
	{
		$this->controller = $controller; 
	}

	public function input($name,$label,$options = array(),$collabel='col-xs-2',$colinput='col-xs-6')
	{
		$error = false; 
		$classError = ''; 
		if(isset($this->errors[$name])){
			$error = $this->errors[$name];
			$classError = ' has-error'; 
		}
		if(!isset($this->data->$name)){
			$value = ''; 
		}else{
			$value = $this->data->$name; 
		}
		if($label == 'hidden'){
			return '<input type="hidden" name="'.$name.'" value="'.$value.'">'; 
		}
		$html = '<div class="form-group '.$classError.' "> 
				<label for="input'.$name.'" class = "control-label '.$collabel.'"> '.$label.' </label>
				<div class = "'.$colinput.'">';
		$attr = ' '; 
		foreach($options as $k=>$v){ if(($k!='type')&&($k!='options')){
			$attr .= " $k=\"$v\""; 
		}}
		if(!isset($options['type']) && !isset($options['options'])){
			$html .= '<input type="text" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';
		}elseif(isset($options['options'])){
			$html .= '<select id="input'.$name.'" name="'.$name.'">';
			foreach($options['options'] as $k=>$v){
				$html .= '<option value="'.$k.'" '.($k==$value?'selected':'').'>'.$v.'</option>'; 
			}
			$html .= '</select>'; 
		}elseif($options['type'] == 'textarea'){
			$html .= '<textarea id="input'.$name.'" name="'.$name.'"'.$attr.'>'.$value.'</textarea>';
		}elseif($options['type'] == 'checkbox'){
			$html .= '<input type="hidden" name="'.$name.'" value="0"><input type="checkbox" name="'.$name.'" value="1" '.(empty($value)?'':'checked').'>'; 
		}elseif($options['type'] == 'file'){
			$html .= '<input type="file" class="input-file" id="input'.$name.'" name="'.$name.'"'.$attr.'>';
		}elseif($options['type'] == 'password'){
			$html .= '<input type="password" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';
		}
		if($error){
			$html .= '<span class="message-error">'.$error.'</span>';
		}
		$html .= '</div></div>';
		return $html; 
	}

}