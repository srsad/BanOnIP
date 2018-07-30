<?php
/** @var modX $modx */
switch ($modx->event->name) {

    case 'OnManagerPageBeforeRender':
        /** @var modManagerController $controller */
        if ($controller->config['controller'] == 'index'){
            if ($banonip = $modx->getService('BanOnIP', 'BanOnIP', MODX_CORE_PATH . 'components/banonip/model/')) {
                $controller->addLexiconTopic('banonip:default');
                $banonip->loadJS($modx->controller);
            }
        }
        break;
    case 'OnWebPagePrerender':
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $arr_ip = explode('.', $ip);
        $ip_1 = $arr_ip[0] . '.';
        $ip_2 = $arr_ip[0] . '.' . $arr_ip[1] . '.';
        $ip_3 = $arr_ip[0] . '.' . $arr_ip[1] . '.' . $arr_ip[2] . '.';
        $ban = false;

        if($banonip = $modx->getService('BanOnIP', 'BanOnIP', MODX_CORE_PATH . 'components/banonip/model/')){
            $q = $modx->newQuery('BanOnIPItem');
            $q->where([
                'name:LIKE' => "%{$ip_1}%",
                'active' => true,
            ]);
            $q->sortby('id', 'ASC');
            $items = $modx->getCollection('BanOnIPItem', $q);

            foreach($items as $item){
                switch($item){
                    case ($item->get('name') === $ip):
                        $ban = true;
                        break;
                    case (stristr($item->get('name'), $ip_1) == true && $item->get('b') == true):
                        $ban = true;
                        break;
                    case (stristr($item->get('name'), $ip_2) == true && $item->get('c') == true):
                        $ban = true;
                        break;
                    case (stristr($item->get('name'), $ip_3) == true && $item->get('d') == true):
                        $ban = true;
                        break;
                }

                if($ban == true){
                    $error_tpl = '<html><head> <title>Error 403 - forbidden</title><style type="text/css">body {margin: 50px;background: #eee;}.message {padding: 10px;border: 2px solid #f22;background: #f99;margin: 0 auto;font: 120%/1em sans-serif;text-align: center;}</style></head><body><div class="message"> 403 Forbidden </div></body>';
                    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
                    echo $error_tpl;
                    exit();
                    break;
                }
                
            }

        }

        break;
}
return;