<?php

class BanOnIPItemFormitProcessor extends modProcessor {
    public $objectType = 'BanOnIPItem';
    public $classKey = 'BanOnIPItem';

    /**
     * @return mixed|string
     */
    public function process()
    {
        $id = $this->getProperty('id');
        $ip = $this->getProperty('ip');
        $method = $this->getProperty('method');
        $result = '';

        if($method === 'unban'){
            if ($unban = $this->modx->getObject('BanOnIPItem', $id)){
                $unban->set('active', false);
                $unban->save();
                $result = $this->modx->lexicon('banonip_item_result_unban', array( 'ip' => $ip));
            }
        }

        if (in_array($method, ['fullban', 'D_ban', 'C_ban', 'B_ban'])){

            $arr_ip = explode('.', $ip);
            $ip_1 = $arr_ip[0] . '.';
            $ip_2 = $arr_ip[0] . '.' . $arr_ip[1] . '.';
            $ip_3 = $arr_ip[0] . '.' . $arr_ip[1] . '.' . $arr_ip[2] . '.';
            $ban = false;

            $q = $this->modx->newQuery($this->classKey);
            $q->where([
                'name:LIKE' => "%{$ip_1}%",
            ]);
            $q->sortby('id', 'ASC');
            $items = $this->modx->getCollection($this->classKey, $q);
            $els = [];
            foreach($items as $item){
                $els[] = $item->get('name');

                switch($item){
                    case ($item->get('name') === $ip && $method === 'fullban'):
                        $ban = true;
                        break;
                    case (stristr($item->get('name'), $ip_1) == true && $method === 'B_ban'):
                        $ban = true;
                        break;
                    case (stristr($item->get('name'), $ip_2) == true && $method === 'C_ban'):
                        $ban = true;
                        break;
                    case (stristr($item->get('name'), $ip_3) == true && $method === 'D_ban'):
                        $ban = true;
                        break;
                }

                if($ban === true){
                    // баним
                    $item->set('active', true);
                    switch ($method) {
                        case 'B_ban':
                            $item->set('b', true);
                            $item->set('c', true);
                            $item->set('d', true);
                            $status = $method;
                            break;
                        case 'C_ban':
                            $item->set('b', false);
                            $item->set('c', true);
                            $item->set('d', true);
                            $status = $method;
                            break;
                        case 'D_ban':
                            $item->set('b', false);
                            $item->set('c', false);
                            $item->set('d', true);
                            $status = $method;
                            break;
                        case 'fullban':
                            $item->set('b', false);
                            $item->set('c', false);
                            $item->set('d', false);
                            $status = $method;
                            break;
                    }

                    $item->save();
                    $result = $this->modx->lexicon('banonip_item_result_ban', array( 'ip' => $ip));
                    break;
                }

            }

            // создаем новый объект
            if (empty($status)) {
                $c = $this->modx->newObject($this->classKey);
                $c->set('name', $ip);
                $c->set('description', $this->modx->lexicon('banonip_cif'));
                switch ($method) {
                    case 'B_ban':
                        $c->set('b', true);
                    case 'C_ban':
                        $c->set('c', true);
                    case 'D_ban':
                        $c->set('d', true);
                        break;
                }

                $c->save();
                $result = $this->modx->lexicon('banonip_item_result_ban', array( 'ip' => $ip));
            }

        }

        return json_encode(array(
            'success' => true,
            'results' => array(
                'message' => $result,
            )
        ));

    }
}
return 'BanOnIPItemFormitProcessor';
