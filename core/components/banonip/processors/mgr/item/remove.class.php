<?php

class BanOnIPItemRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'BanOnIPItem';
    public $classKey = 'BanOnIPItem';
    public $languageTopics = ['banonip'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('banonip_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var BanOnIPItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('banonip_item_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'BanOnIPItemRemoveProcessor';