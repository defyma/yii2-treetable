<?php

/**
 * @copyright Copyright &copy; Arno Slatius 2017
 * @package yii2-treetable
 * @version 1.0.2
 *
 * 29-03-2021 (defy): add registerCss
 */

namespace defyma\treetable;

use \Yii;
use yii\grid\GridView;
use yii\helpers\Json;
use defyma\treetable\TreetableAsset;

class Treetable extends GridView
{
    /**
    * @var array configuration options for the treetable() component
    */
    public $treetableOptions = ['expandable' => true, 'indent' => 0];

    /**
    * @var boolean load default theme
    */
    public $treetableTheme = false;

    /**
     * @var integer a counter used to generate [[id]] for widgets.
     * @internal
     */
    public static $counter = 0;

	/**
	 * Initializes the widget
     *
     * Register the assets and activate the jquery.treetable() on the table
	 */
	public function init() {

        /* Register the assets */
        TreetableAsset::register($this->view, $this->treetableTheme);

        /* Determine table id */
        if (in_array('id', $this->tableOptions))
            $id = $this->tableOptions['id'];
        else
            $this->tableOptions['id'] = 'treetable' . static::$counter++;;

        /* Activate the jquery code */
        $options = Json::htmlEncode($this->treetableOptions);
        $this->view->registerJs("$('#".$this->tableOptions['id']."').treetable(".$options.");");
        $css = file_get_contents(Yii::getAlias('@vendor') . '/defyma/yii2-treetable/css/treetable.css');
        $this->view->registerCss($css);

        parent::init();
	}
}
