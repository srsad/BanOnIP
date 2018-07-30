<?php

class BanOnIPItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'BanOnIPItem';
    public $classKey = 'BanOnIPItem';
    public $languageTopics = ['banonip'];

    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));

        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('banonip_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('banonip_item_err_ae'));
        } elseif (filter_var($name, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false){
            $this->modx->error->addField('name', $this->modx->lexicon('banonip_item_err_ip'));
        }

        return parent::beforeSet();
    }

}

return 'BanOnIPItemCreateProcessor';