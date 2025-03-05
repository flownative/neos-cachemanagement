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
    protected array $cacheConfiguration;

    /**
     * @Flow\InjectConfiguration(path="ui")
     * @var array
     */
    protected array $uiSettings;

    /**
     * @return void
     * @throws \Neos\Cache\Exception\NoSuchCacheException
     */
    public function indexAction(): void
    {
        $this->view->assign('caches', $this->getCacheConfiguration());
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
    public function flushAction(string $cacheIdentifier): void
    {
        if(array_key_exists($cacheIdentifier, $this->getCacheConfiguration())) {
            $this->cacheManager->getCache($cacheIdentifier)->flush();
            $this->addFlashMessage('Successfully flushed the cache "%s".', 'Cache cleared', Message::SEVERITY_OK, [$cacheIdentifier], 1448033946);
        }else{
            $this->addFlashMessage('Cache "%s" is not configured for flushing.', 'Not configured', Message::SEVERITY_ERROR, [$cacheIdentifier], 1550221927);
        }
        $this->redirect('index');
    }

    /**
     * Get a list of cache configurations with backend type
     * Removes empty values from the cache configuration
     *
     * @return array
     * @throws \Neos\Cache\Exception\NoSuchCacheException
     */
    protected function getCacheConfiguration(): array
    {
        $cacheConfiguration = $this->cacheConfiguration;

        if ($this->uiSettings['hideCachesWithoutLabel'] ?? false) {
            $cacheConfiguration = array_filter($cacheConfiguration, function ($value) {
                return !!$value;
            });
        }

        foreach ($cacheConfiguration as $cacheIdentifier => $configuration) {
            if (is_array($configuration) && array_key_exists('hidden', $configuration) && $configuration['hidden'] === true) {
                unset($cacheConfiguration[$cacheIdentifier]);
                continue;
            }

            $cacheConfiguration[$cacheIdentifier]['backendType'] = get_class($this->cacheManager->getCache($cacheIdentifier)->getBackend());
        }

        return $cacheConfiguration;
    }
}
