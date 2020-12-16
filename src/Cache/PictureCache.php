<?php


namespace App\Cache;


use App\Repository\PictureRepository;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class PictureCache
{
    /**
     * @var FilesystemAdapter
     */
    private $cache;
    /**
     * @var PictureRepository
     */
    private $pictureRepository;

    public function __construct(PictureRepository $pictureRepository)
    {
        $this->cache = new FilesystemAdapter();
        $this->pictureRepository = $pictureRepository;
    }

    public function allPicsCache(string $item, int $expiresAfter)
    {
        /**
         * @var CacheItemInterface $element
         */
        $element = $this->cache->getItem($item);
        $this->cache->delete($item);

        if (!$element->isHit()) {
            $datas = $this->pictureRepository->findAll();
            $element->set($datas);
            $element->expiresAfter($expiresAfter);
            $this->cache->save($element);
        }
        return $element->get();
    }

    public function pageCache(string $page, string $item, int $expiresAfter)
    {
        /**
         * @var CacheItemInterface $element
         */
        $element = $this->cache->getItem($item);
        $this->cache->delete($item);
        if (!$element->isHit()) {
            $datas = $this->pictureRepository->findNotNull($page);
            $element->set($datas);
            $element->expiresAfter($expiresAfter);
            $this->cache->save($element);
        }
        return $element->get();
    }

    public function deleteCache(string $item)
    {
        $this->cache->delete($item);
    }
}