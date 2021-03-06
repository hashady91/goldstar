<?php 
class Video_Form_New extends Cl_Form
{
	public function init()
	{
		parent::init();
		$this->fieldList = array(/*'avatar',*/'name', 'content', 'status', 'url',
					 'tags','parent_category_iid');
		$this->setCbHelper('Video_Form_Helper');
		
	}
	public function setStep($step, $currentRow = null)
	{
		parent::setStep($step, $currentRow);
	}
	
    protected function _formFieldsConfigCallback()
    {
        $ret = array(
        	'name' => array(
        		'type' => 'Text',
        		'options' => array(
        			'label' => "Tên Video",
        			'required' => true,
    	    		'filters' => array('StringTrim', 'StripTags'),
                    'validators' => array('NotEmpty'),
        		),
                //'permission' => 'update_task'
        	),
        	'tags' => $this->generateFormElement('tags', 'Tags','', array(
        		'data-url' => '/suggest.php?node=tag&addnew=1',
        		'permission' => 'new_tag'
        	)),
        	'content' => array(
        		'type' => 'Textarea',
        		'options' => array(
        	        'label' => "Nội dung video",
        	        'class' => 'isEditor',
    	    		'filters' => array('StringTrim', 'NodePost'),
        			'prefixPath' => array(
        				"filter" => array (
        					"Filter" => "Filter/"
        				)
        			)
        		),
        	),
        		'parent_category_iid' => array(
        				'type' => 'Select',
        				'options' => array(
        						'label' => "Chuyên mục cha",
        						'filters' => array('StringTrim','StripTags'),
        						'prefixPath' => array(
        								"filter" => array (
        										"Filter" => "Filter/"
        								)
        						),
        				),
        				'multiOptionsCallback' => array('getParentCategoryList'),
        				'defaultValue' => 'NoParent'
        		),
            'status' => array(
            		'type' => 'Select',
            		'permission' => 'root',
            		'options' => array(
            				'label' => 'Trạng thái',
            				'required' => true,
            		),
            		'multiOptionsCallback' => array('getStatus')
            ),
        	'avatar' => array(
        			'type' => 'Hidden',
        			'options' => array(
        					'class' => 'cl_upload',
        					'filters' => array('StringTrim', 'StripTags')
        			),
        	),
        	'url' => array(
        		'type' => 'Text',
        		'options' => array(
        			'label' => 'Url',
        			'placeholder' => "E.g http://www.youtube.com/watch?v=fkm7eMqiuSw",
        			'required' => true,
        			'filters' => array('StringTrim', 'StripTags'),
        			'validators' => array('NotEmpty'),
        		),
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
