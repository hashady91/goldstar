<?php 
class New_Form_New extends Cl_Form
{
	public function init()
	{
		parent::init();
		$this->fieldList = array('avatar','name', 'content', 'status', 'description',
					 'tags', 'author', 'source','parent_category_iid', 'is_hot');
		$this->setCbHelper('New_Form_Helper');
		
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
        			'label' => "Tên New",
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
        	        'label' => "Nội dung tin",
        	        'class' => 'isEditor',
    	    		'filters' => array('StringTrim', 'StoryPost'),
        			'prefixPath' => array(
        				"filter" => array (
        					"Filter" => "Filter/"
        				)
        			)
        		),
        	),
        	'description' => array(
        		'type' => 'Textarea',
        		'options' => array(
        			'label' => "Mô tả tin",
        			'class' => 'isEditor',
        			'filters' => array('StringTrim', 'StoryPost'),
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
        	'source' => array(
        		'type' => 'Text',
        		'options' => array(
        			'label' => "Nguồn",
        			'required' => true,
    	    		'filters' => array('StringTrim', 'StripTags'),
                    'validators' => array('NotEmpty'),
        		),
        	),
        	'author' => array(
        		'type' => 'Text',
        		'options' => array(
        			'label' => "Tác giả",
        			'required' => true,
    	    		'filters' => array('StringTrim', 'StripTags'),
                    'validators' => array('NotEmpty'),
        		),
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
        	'is_hot' => array(
        			'type' => 'Select',
        			'permission' => 'root',
        			'options' => array(
        				'label' => 'Có là hot không?(hot, best, new, normal)',
        				'required' => true,
        			),
        			'multiOptionsCallback' => array('getHotStatus'),
        			'defaultValue' => 'normal'
        	),
        	'is_original' => array(
        		'type' => 'Select',
        		'options' => array(
        			'label' => 'Bản gốc?',
        			'required' => true,
        		),
        		'multiOptionsCallback' => array('getOriginal')
        	),
        	'avatar' => array(
        			'type' => 'Hidden',
        			'options' => array(
        					'class' => 'cl_upload',
        					'filters' => array('StringTrim', 'StripTags')
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
