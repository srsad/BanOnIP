<?php

class BanOnIPItemGetItemProcessor extends modProcessor
{
    public $objectType = 'BanOnIPItem';
    public $classKey = 'BanOnIPItem';

    /**
     * @return mixed
     */
    public function process()
    {

        $ip = trim($this->getProperty('ip'));
        $arr_ip = explode('.', $ip);
        $ip_1 = $arr_ip[0] . '.';
        $ip_2 = $arr_ip[0] . '.' . $arr_ip[1] . '.';
        $ip_3 = $arr_ip[0] . '.' . $arr_ip[1] . '.' . $arr_ip[2] . '.';
        $ban = false;
        $id = '';

        if (!empty($ip)) {
            $c = $this->modx->newQuery('BanOnIPItem');
            $c->where([
                'name:LIKE' => "%{$ip_1}%",
                'active' => true,
            ]);

            $full_arr = $this->modx->getCollection('BanOnIPItem', $c);
            if(!empty($full_arr)){
                foreach($full_arr as $item){
                    switch(!empty($item)){
                        case ($item->get('name') === $ip):
                            $ban = true;
                            break;
                        case ($item->get('b') == 1 && stristr($item->get('name'), $ip_1) == true):
                            $ban = true;
                            break;
                        case ($item->get('c') == 1 && stristr($item->get('name'), $ip_2) == true):
                            $ban = true;
                            break;
                        case ($item->get('d') == 1 && stristr($item->get('name'), $ip_3) == true):
                            $ban = true;
                            break;
                    }

                    if($ban === true){
                        $id = $item->get('id');
                        break;
                    }

                }

            }

        }

        return json_encode(array(
            'success' => true,
            'results' => array(
                'ban' => $ban,
                'id'  => $id
            )
        ));

    }


}

return 'BanOnIPItemGetItemProcessor';