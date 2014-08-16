<?php 
class User_Form_Login extends Cl_Form_User_Login
{
    public function init()
    {
        parent::init();
        $this->setCbHelper("User_Form_Helper");
        if (method_exists($this, "_customFormFieldsConfig"))
            $this->_formFieldsConfig = array_merge($this->_formFieldsConfig, $this->_customFormFieldsConfig());
    
    }
    
    protected function _customFormFieldsConfig()
    {
         return array(
            	'lname' => array(
            		'type' => 'Text',
            		'options' => array(
            			'label' => "Tên đăng nhập",
            			'required' => true,
        	    		'filters' => array('StringTrim', 'StripTags')
            		),
            	),
            	'mail' => array(
            		'type' => 'Text',
            		'options' => array(
            			'label' => "Email",
            			'order' => 2,
            			'required' => true,
        	    		'filters' => array('StringTrim', 'StripTags'),
                        'validators' => array(
        					array(
        				    	'validator'   => 'Regex',
        				        'breakChainOnFailure' => false,
        				        'options'     => array( 
        				        'pattern' => '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$/',
        				        	'messages' => array(
        				            	Zend_Validate_Regex::NOT_MATCH => "Địa chỉ email không đúng"
        				     	    )
        				    	)
        					),
        	    			array(
        			            'validator' => 'StringLength',
        			           	'options' => array(
        			               'min' => 6
        			            )
        			        )
        	    		),
            		),
            	),
            	'pass' => array(
                    'type' => 'Password',
            		'options' => array(
            			'label' => "Mật khẩu",
            			'required' => true,
        	    		'filters' => array('StringTrim', 'StripTags'),
                        
            		),
                ),
            	'remember' => array(
            		'type' => 'Checkbox',
            		'options' => array(
            			'label' => "Duy trì đăng nhập",
            		),
                    'defaultValue' => true
            	),
            	'b' => array(
            			'type' => 'Hidden',
            	),
            );
        }
}
