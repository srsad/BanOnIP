<?php

class BanOnIP
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/banonip/';
        $assetsUrl = MODX_ASSETS_URL . 'components/banonip/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('banonip', $this->config['modelPath']);
        $this->modx->lexicon->load('banonip:default');
    }

    public function loadJS(modManagerController $controller){
        if ($controller->config['namespace_name'] === 'formit'){
            $controller->addHtml('<script type="text/javascript"> 
                var BanOnIP_connector_url = "' . $this->config['connectorUrl'] . '";
                </script>');
            $controller->addLastJavascript(MODX_ASSETS_URL . 'components/banonip/js/mgr/sections/formit.js');
        }

    }

}