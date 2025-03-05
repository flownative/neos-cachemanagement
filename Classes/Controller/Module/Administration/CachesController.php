<?php
namespace Flownative\Neos\CacheManagement\Controller\Module\Administration;

/*
 * This file is part of the Flownative.Neos.CacheManagement package.
 *
 * (c) Robert Lemke / Flownative - www.flownative.com
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Error\Messages\Message;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cache\CacheManager;
use Neos\Neos\Controller\Module\AbstractModuleController;

/**
 * A Cache Management module controller
 */
class CachesController extends AbstractModuleController
{

    /**
     * @Flow\Inject
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @Flow\InjectConfiguration(path="caches")
     * @var array
     */
    protected $cacheConfiguration;

    /**
     * @Flow\InjectConfiguration(path="ui")
     * @var array
     */
    protected array $uiSettings;

    /**
     * @return void
     * @throws \Neos\Cache\Exception\NoSuchCacheException
     */
    public function indexAction()
    {
        foreach ($this->cacheConfiguration as $cacheIdentifier => $label) {
            $this->cacheConfiguration[$cacheIdentifier]['backendType'] = get_class($this->cacheManager->getCache($cacheIdentifier)->getBackend());
        }
        $this->view->assign('caches', $this->cacheConfiguration);
        $this->view->assign('uiSettings', $this->uiSettings);
    }

    /**
     * Create a new user
     *
     * @param string $cacheIdentifier
     * @Flow\Validate(argumentName="cacheIdentifier", type="\Neos\Flow\Validation\Validator\NotEmptyValidator")
     * @return void
     * @throws \Neos\Cache\Exception\NoSuchCacheException
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     */
    public function flushAction($cacheIdentifier)
    {
        if(array_key_exists($cacheIdentifier, $this->cacheConfiguration)) {
            $this->cacheManager->getCache($cacheIdentifier)->flush();
            $this->addFlashMessage('Successfully flushed the cache "%s".', 'Cache cleared', Message::SEVERITY_OK, [$cacheIdentifier], 1448033946);
        }else{
            $this->addFlashMessage('Cache "%s" is not configured for flushing.', 'Not configured', Message::SEVERITY_ERROR, [$cacheIdentifier], 1550221927);
        }
        $this->redirect('index');
    }
}
