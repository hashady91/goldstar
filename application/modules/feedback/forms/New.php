<?php 
class Feedback_Form_New extends Cl_Form
{
	public function init()
	{
		parent::init();
		$this->fieldList = array('uname', 'umail', 'uphone', 'to', 'content', 'title','status');
		$this->setCbHelper('Feedback_Form_Helper');
		
	}
	public function setStep($step, $currentRow = null)
	{
		parent::setStep($step, $currentRow);
	}
	
    protected function _formFieldsConfigCallback()
    {
        $ret = array(
        	'to' => array(
        		'type' => 'Select',
            		'options' => array(
            				'label' => 'Gửi đến',
            				'required' => true,
            		),
            		'multiOptionsCallback' => array('getToAdrees')
        	),
        	'uname' => array(
        		'type' => 'Text',
        		'options' => array(
        			'label' => "Tên",
        			'required' => true,
        			'filters' => array('StringTrim', 'StripTags'),
        			'validators' => array('NotEmpty'),
        		),
        	),
        	'umail' => array(
        		'type' => 'Text',
        		'options' => array(
        			'label' => "Email",
        			'required' => true,
        			'filters' => array('StringTrim', 'StripTags'),
        			'validators' => array('NotEmpty'),
        		),
        	),
        		'uphone' => array(
        				'type' => 'Text',
        				'options' => array(
        						'label' => "Điện thoại",
        						'required' => true,
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        				),
        		),
        		'title' => array(
        				'type' => 'Text',
        				'options' => array(
        						'label' => "Tiêu đề",
        						'required' => true,
        						'filters' => array('StringTrim', 'StripTags'),
        						'validators' => array('NotEmpty'),
        				),
        		),
        	'content' => array(
        		'type' => 'Textarea',
        		'options' => array(
        	        'label' => "Nộidung",
        	        'class' => 'isEditor',
    	    		'filters' => array('StringTrim', 'NodePost'),
        			'prefixPath' => array(
        				"filter" => array (
        					"Filter" => "Filter/"
        				)
        			)
        		),
        	),
            'status' => array(
            		'type' => 'Select',
            		'options' => array(
            				'label' => 'Status',
            				'required' => true,
            		),
            		'multiOptionsCallback' => array('getStatus')
            ),
        );
        return $ret;
    }
    /**TODO: hook here if needed
    public function customIsValid($data)
    {
        return array('success' => false, 'err' => "If customIsValid exist. You must implement it");
    }
    */
}
