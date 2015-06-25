<?php

namespace maksyutin\mediaelement;

use yii\web\AssetBundle;

/**
 * Asset bundle
 *
 */
class MediaAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'build/mediaelementplayer'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'build/mediaelement-and-player'
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets/mediaelement');
        $this->setupAssets();

        parent::init();
    }

    /**
     * Sets the source path if empty
     * @param string $path the path to be set
     */
    protected function setSourcePath($path)
    {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $path;
        }
    }

    /**
     * Set up CSS and JS asset arrays based on the base-file names
     * @param string $type whether 'css' or 'js'
     * @param array $files the list of 'css' or 'js' basefile names
     */
    protected function setupAssets()
    {
        $type='js';
        foreach ($this->js as $js) {
            $srcJsFiles[] = "{$js}.{$type}";
            $minJsFiles[] = "{$js}.min.{$type}";
        }

        $type='css';
        foreach ($this->css as $css) {
            $srcCssFiles[] = "{$css}.{$type}";
            $minCssFiles[] = "{$css}.min.{$type}";
        }

        $this->js = YII_DEBUG ? $srcJsFiles : $minJsFiles;
        $this->css = YII_DEBUG ? $srcCssFiles : $minCssFiles;
    }
}
