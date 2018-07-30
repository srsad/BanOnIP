<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/BanOnIP/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/banonip')) {
            $cache->deleteTree(
                $dev . 'assets/components/banonip/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/banonip/', $dev . 'assets/components/banonip');
        }
        if (!is_link($dev . 'core/components/banonip')) {
            $cache->deleteTree(
                $dev . 'core/components/banonip/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/banonip/', $dev . 'core/components/banonip');
        }
    }
}

return true;