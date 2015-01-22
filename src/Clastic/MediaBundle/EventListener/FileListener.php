<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MediaBundle\EventListener;

use Clastic\AliasBundle\Entity\Alias;
use Clastic\MediaBundle\Entity\File;
use Clastic\NodeBundle\Event\NodeCreateEvent;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\ValueHolderInterface;

/**
 * NodeListener
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class FileListener implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof File) {
            $this->hydrateRecord($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof File) {
            $this->hydrateRecord($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof File) {
            $this->upload($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof File) {
            $this->upload($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof File) {
            $this->upload($entity);
        }
    }

    private function hydrateRecord(File $file)
    {
        if (null !== $file->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $file->setPath($filename . '.' . $file->getFile()->guessExtension());
            $file->setSize($file->getFile()->getSize());
            $file->setName($file->getFile()->getClientOriginalName());
            $file->setMeta(array(
                'extension' => $file->getFile()->guessExtension(),
            ));
        }
    }

    private function upload(File $file)
    {
        if (null === $file->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $file->getFile()->move($this->getUploadRootDir(), $file->getPath());

        // check if we have an old image
        if (isset($file->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$file->temp);
            // clear the temp image path
            $file->temp = null;
        }
        $file->file = null;
    }

    private function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
}
