<?php

/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Clastic\MediaBundle\ElFinder\Driver;

use Clastic\MediaBundle\ElFinder\ElFinderEvent;
use FM\ElFinderPHP\Driver\ElFinderVolumeDriver;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * ElFinderVolumeClasticFileSystem.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class ElFinderVolumeClasticFileSystem extends ElFinderVolumeDriver
{
    /**
     * @var ElFinderVolumeDriver
     */
    private $driver;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param ElFinderVolumeDriver     $driver
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ElFinderVolumeDriver $driver, EventDispatcherInterface $dispatcher)
    {
        $this->driver = $driver;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc).
     */
    public function driverId()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->driverId();
    }

    /**
     * {@inheritdoc).
     */
    public function id()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->id();
    }

    /**
     * {@inheritdoc).
     */
    public function debug()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->debug();
    }

    /**
     * {@inheritdoc).
     */
    public function mount(array $opts)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->mount($opts);
    }

    /**
     * {@inheritdoc).
     */
    public function umount()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        $this->driver->umount();
    }

    /**
     * {@inheritdoc).
     */
    public function error()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->error();
    }

    /**
     * {@inheritdoc).
     */
    public function getMimeTable()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->getMimeTable();
    }

    /**
     * {@inheritdoc).
     */
    public function setMimesFilter($mimes)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        $this->driver->setMimesFilter($mimes);
    }

    /**
     * {@inheritdoc).
     */
    public function root()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->root();
    }

    /**
     * {@inheritdoc).
     */
    public function defaultPath()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->defaultPath();
    }

    /**
     * {@inheritdoc).
     */
    public function options($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->options($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function getOptionsPlugin($name = '')
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->getOptionsPlugin($name);
    }

    /**
     * {@inheritdoc).
     */
    public function commandDisabled($cmd)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->commandDisabled($cmd);
    }

    /**
     * {@inheritdoc).
     */
    public function mimeAccepted($mime, $mimes = array(), $empty = true)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->mimeAccepted($mime, $mimes, $empty);
    }

    /**
     * {@inheritdoc).
     */
    public function isReadable()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->isReadable();
    }

    /**
     * {@inheritdoc).
     */
    public function copyFromAllowed()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->copyFromAllowed();
    }

    /**
     * {@inheritdoc).
     */
    public function path($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->path($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function realpath($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->realpath($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function removed()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->removed();
    }

    /**
     * {@inheritdoc).
     */
    public function resetRemoved()
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        $this->driver->resetRemoved();
    }

    /**
     * {@inheritdoc).
     */
    public function closest($hash, $attr, $val)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->closest($hash, $attr, $val);
    }

    /**
     * {@inheritdoc).
     */
    public function file($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->file($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function dir($hash, $resolveLink = false)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->dir($hash, $resolveLink);
    }

    /**
     * {@inheritdoc).
     */
    public function scandir($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->scandir($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function ls($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->ls($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function tree($hash = '', $deep = 0, $exclude = '')
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->tree($hash, $deep, $exclude);
    }

    /**
     * {@inheritdoc).
     */
    public function parents($hash, $lineal = false)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->parents($hash, $lineal);
    }

    /**
     * {@inheritdoc).
     */
    public function tmb($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->tmb($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function size($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->size($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function open($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->open($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function close($fp, $hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        $this->driver->close($fp, $hash);
    }

    /**
     * {@inheritdoc).
     */
    public function mkdir($dst, $name)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->mkdir($dst, $name);
    }

    /**
     * {@inheritdoc).
     */
    public function mkfile($dst, $name)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->mkfile($dst, $name);
    }

    /**
     * {@inheritdoc).
     */
    public function rename($hash, $name)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->rename($hash, $name);
    }

    /**
     * {@inheritdoc).
     */
    public function duplicate($hash, $suffix = 'copy')
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->duplicate($hash, $suffix);
    }

    /**
     * {@inheritdoc).
     */
    public function upload($fp, $dst, $name, $tmpname)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->upload($fp, $dst, $name, $tmpname);
    }

    /**
     * {@inheritdoc).
     */
    public function paste($volume, $src, $dst, $rmSrc = false)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->paste($volume, $src, $dst, $rmSrc);
    }

    /**
     * {@inheritdoc).
     */
    public function getContents($hash)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->getContents($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function putContents($hash, $content)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->putContents($hash, $content);
    }

    /**
     * {@inheritdoc).
     */
    public function extract($hash, $makedir = null)
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        return $this->driver->extract($hash, $makedir);
    }

    /**
     * {@inheritdoc).
     */
    public function archive($hashes, $mime, $name = '')
    {
        $this->dispatcher
            ->dispatch('elfinder.'.__METHOD__, new ElFinderEvent(func_get_args()));

        $this->driver->archive($hashes, $mime, $name);
    }

    /**
     * {@inheritdoc).
     */
    public function resize($hash, $width, $height, $x, $y, $mode = 'resize', $bg = '', $degree = 0, $jpgQuality = null)
    {
        return $this->driver->resize($hash, $width, $height, $x, $y, $mode, $bg, $degree, $jpgQuality);
    }

    /**
     * {@inheritdoc).
     */
    public function rm($hash)
    {
        return $this->driver->rm($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function search($q, $mimes, $hash = null)
    {
        return $this->driver->search($q, $mimes, $hash);
    }

    /**
     * {@inheritdoc).
     */
    public function dimensions($hash)
    {
        return $this->driver->dimensions($hash);
    }

    /**
     * {@inheritdoc).
     */
    public function getContentUrl($hash, $options = array())
    {
        return $this->driver->getContentUrl($hash, $options);
    }

    /**
     * {@inheritdoc).
     */
    public function getTempPath()
    {
        return $this->driver->getTempPath();
    }

    /**
     * {@inheritdoc).
     */
    public function getUploadTaget($baseTargetHash, $path, &$result)
    {
        return $this->driver->getUploadTaget($baseTargetHash, $path, $result);
    }

    /**
     * {@inheritdoc).
     */
    public function uniqueName($dir, $name, $suffix = ' copy', $checkNum = true, $start = 1)
    {
        return $this->driver->uniqueName($dir, $name, $suffix, $checkNum, $start);
    }

    /**
     * All required methods we don't need as we are wrapping the driver.
     */
    protected function _dirname($path)
    {
    }
    protected function _basename($path)
    {
    }
    protected function _joinPath($dir, $name)
    {
    }
    protected function _normpath($path)
    {
    }
    protected function _relpath($path)
    {
    }
    protected function _abspath($path)
    {
    }
    protected function _path($path)
    {
    }
    protected function _inpath($path, $parent)
    {
    }
    protected function _stat($path)
    {
    }
    protected function _subdirs($path)
    {
    }
    protected function _dimensions($path, $mime)
    {
    }
    protected function _scandir($path)
    {
    }
    protected function _fopen($path, $mode = 'rb')
    {
    }
    protected function _fclose($fp, $path = '')
    {
    }
    protected function _mkdir($path, $name)
    {
    }
    protected function _mkfile($path, $name)
    {
    }
    protected function _symlink($source, $targetDir, $name)
    {
    }
    protected function _copy($source, $targetDir, $name)
    {
    }
    protected function _move($source, $targetDir, $name)
    {
    }
    protected function _unlink($path)
    {
    }
    protected function _rmdir($path)
    {
    }
    protected function _save($fp, $dir, $name, $stat)
    {
    }
    protected function _getContents($path)
    {
    }
    protected function _filePutContents($path, $content)
    {
    }
    protected function _extract($path, $arc)
    {
    }
    protected function _archive($dir, $files, $name, $arc)
    {
    }
    protected function _checkArchivers()
    {
    }
    protected function _chmod($path, $mode)
    {
    }
}
