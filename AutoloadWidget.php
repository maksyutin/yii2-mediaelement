<?php
namespace maksyutin\mediaelement;

use maksyutin\mediaelement\MediaAsset;
use yii\BaseYii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is just an example.
 */
class AutoloadWidget extends \yii\base\Widget
{
    const IS_AUDIO = 'audio';
    const IS_VIDEO = 'video';

    public $width;
    public $height;
    public $mediafile;
    public $tag = self::IS_VIDEO;
    public $modal;
    public $autoplay = false;
    public $title = false;

    public $options;

    public $playerOptions = [];
    private $defaultOptions = [];

    private $_mediaAsset;

    /**
     * @var array {mediaelement options}.
     */
    public $settings = [];
    private $defaultSettings = [];

    /**
     * @var array Default settings array
     */
    private $_defaultSettings;

    public function init()
    {

        parent::init();
        $view = Yii::$app->getView();

        $this->registerAssets();
        $view->registerJs($this->getJs(), View::POS_READY);

        $this->defaultOptions = [
            'defaultVideoWidth' => 480,             // if the <video width> is not specified, this is the default
            'defaultVideoHeight' => 270,            // if the <video height> is not specified, this is the default
            'videoWidth' => -1,                     // if set, overrides <video width>
            'videoHeight' => -1,                    // if set, overrides <video height>
            'audioWidth' => 400,                    // width of audio player
            'audioHeight' => 30,                    // height of audio player
            'startVolume' => 0.8,                   // initial volume when the player starts
            'loop' => false,                        // useful for <audio> player loops
            'enableAutosize' => true,               // enables Flash and Silverlight to resize to content size
            'features' => ['playpause', 'progress', 'current', 'duration', 'tracks', 'volume', 'fullscreen'], // the order of controls you want on the control bar (and other plugins below)
            'alwaysShowControls' => false,          // Hide controls when playing and mouse is not over the video
            'iPadUseNativeControls' => false,       // force iPad's native controls
            'iPhoneUseNativeControls' => false,     // force iPhone's native controls
            'AndroidUseNativeControls' => false,    // force Android's native controls
            'alwaysShowHours' => false,             // forces the hour marker (##:00:00)
            'showTimecodeFrameCount' => false,      // show framecount in timecode (##:00:00:00)
            'framesPerSecond' => 25,                // used when showTimecodeFrameCount is set to true
            'enableKeyboard' => true,               // turns keyboard support on and off for this instance
            'pauseOtherPlayers' => true,            // when this player starts, it will pause other players
            'keyActions' => []                      // array of keyboard commands
        ];

        if (!empty($this->playerOptions)) {
            $this->playerOptions = ArrayHelper::merge($this->playerOptions, $this->defaultOptions);
        }

        $this->settings['title'] = (isset($this->title)) ? $this->title : false;
        $this->settings['mediafile'] = (isset($this->mediafile)) ? $this->mediafile : $this->_mediaAsset->baseUrl . '/media/other.mp4';

        $this->settings['width'] = (isset($this->width)) ? $this->width : false;
        $this->settings['height'] = (isset($this->height)) ? $this->height : false;

        $this->settings['modal'] = ($this->modal) ? true : false;

    }

    public function run()
    {

        if ($this->settings['modal']) {
            $output = self::modal_view();
        } else {
            $output = self::view();
        }

        return $output;
    }

    public function embed_video()
    {

        $output = '<div class="embed-responsive embed-responsive-16by9">';

        $output .= Html::tag('video', '', [
            'src' => $this->settings['mediafile'],
            'width' => $this->settings['width'],
            'height' => $this->settings['height'],
            'id' => $this->id,
//            'style' => 'background: white;',
            'controls' => "controls",
            'preload' => "none"
        ]);

        $output .= '</div>';

        return $output;
    }

    public function modal_view()
    {

        $modal_id = "myModal" . $this->id;

        $modal_btn = Html::a($this->settings['title'], null, [
            'class' => "btn btn-default btn",
            'data-toggle' => "modal",
            'data-target' => "#" . $modal_id,
            'type' => "button"
        ]);


        $output = '<div class="modal fade" id="' . $modal_id . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

        $output .= ($this->settings['title']) ? '<h4 class="modal-title" id="myModalLabel">' . $this->title . '</h4>' : ' ';
        $output .= '            </div>
                                <div class="modal-body" id="mediaModal' . $this->id . '">';
        $output .= $this->embed_video();
        $output .= '            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                                </div>
                            </div>
                        </div>
                    </div>';

        return ($this->settings['title']) ? $modal_btn . $output : $output;
    }

    public function view()
    {
        $output = $this->embed_video();
        return $output;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $this->_mediaAsset = MediaAsset::register($view);
    }

    private function getJs()
    {
        $js = [];

//        $this->playerOptions[
//                'defaultVideoWidth' => 480,
//                'defaultVideoHeight' => 270,
//            ]

//        $js [] = '$('#mediaModalw0').width()';
        $js [] = 'var player = new MediaElementPlayer("#' . $this->id . '", []);';
//        $js [] = '$("video,audio").mediaelementplayer();';
//        $js [] = 'player.pause();';
//        $js [] = 'player.setSrc("mynewfile.mp4");';
//        $js [] = 'player.play();';

//        $js [] = 'var v = document.getElementsByTagName("video")[0];
//        $js [] = 'new MediaElement(v, {success: function(media) {';
//        $js [] = 'media.stop();';
//        $js [] = '}});';

        return implode("\n", $js);
    }

}