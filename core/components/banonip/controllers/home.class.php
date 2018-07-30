<?php

/**
 * The home manager controller for BanOnIP.
 *
 */
class BanOnIPHomeManagerController extends modExtraManagerController
{
    /** @var BanOnIP $BanOnIP */
    public $BanOnIP;


    /**
     *
     */
    public function initialize()
    {
        $this->BanOnIP = $this->modx->getService('BanOnIP', 'BanOnIP', MODX_CORE_PATH . 'components/banonip/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['banonip:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('banonip');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->BanOnIP->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->BanOnIP->config['jsUrl'] . 'mgr/banonip.js');
        $this->addJavascript($this->BanOnIP->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->BanOnIP->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->BanOnIP->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->BanOnIP->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->BanOnIP->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->BanOnIP->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
            BanOnIP.config = ' . json_encode($this->BanOnIP->config) . ';
            BanOnIP.config.connector_url = "' . $this->BanOnIP->config['connectorUrl'] . '";
            Ext.onReady(function() {MODx.load({ xtype: "banonip-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="banonip-panel-home-div"></div>';
        return '';
    }
}