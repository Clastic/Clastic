<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\MediaBundle\ElFinder\Driver;

use FM\ElFinderPHP\Driver\ElFinderVolumeDriver;

/**
 * ElFinderVolumeClasticFileSystem
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
     * @param ElFinderVolumeDriver $driver
     */
    public function __construct(ElFinderVolumeDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * {@inheritdoc)
     */
    public function driverId()
    {
        return $this->driver->driverId();
    }

    /**
     * {@inheritdoc)
     */
    public function id()
    {
        return $this->driver->id();
    }

    /**
     * {@inheritdoc)
     */
    public function debug()
    {
        return $this->driver->debug();
    }

    /**
     * {@inheritdoc)
     */
    public function mount(array $opts)
    {
        return $this->driver->mount($opts);
    }

    /**
     * {@inheritdoc)
     */
    public function umount()
    {
        return $this->driver->umount();
    }

    /**
     * {@inheritdoc)
     */
    public function error()
    {
        return $this->driver->error();
    }

    /**
     * {@inheritdoc)
     */
    public function getMimeTable()
    {
        return $this->driver->getMimeTable();
    }

    /**
     * {@inheritdoc)
     */
    public function setMimesFilter($mimes)
    {
        $this->driver->setMimesFilter($mimes);
    }

    /**
     * {@inheritdoc)
     */
    public function root()
    {
        return $this->driver->root();
    }

    /**
     * {@inheritdoc)
     */
    public function defaultPath()
    {
        return $this->driver->defaultPath();
    }

    /**
     * {@inheritdoc)
     */
    public function options($hash)
    {
        return $this->driver->options($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function getOptionsPlugin($name = '')
    {
        return $this->driver->getOptionsPlugin($name);
    }

    /**
     * {@inheritdoc)
     */
    public function commandDisabled($cmd)
    {
        return $this->driver->commandDisabled($cmd);
    }

    /**
     * {@inheritdoc)
     */
    public function mimeAccepted($mime, $mimes = array(), $empty = true)
    {
        return $this->driver->mimeAccepted($mime, $mimes, $empty);
    }

    /**
     * {@inheritdoc)
     */
    public function isReadable()
    {
        return $this->driver->isReadable();
    }

    /**
     * {@inheritdoc)
     */
    public function copyFromAllowed()
    {
        return $this->driver->copyFromAllowed();
    }

    /**
     * {@inheritdoc)
     */
    public function path($hash)
    {
        return $this->driver->path($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function realpath($hash)
    {
        return $this->driver->realpath($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function removed()
    {
        return $this->driver->removed();
    }

    /**
     * {@inheritdoc)
     */
    public function resetRemoved()
    {
        $this->driver->resetRemoved();
    }

    /**
     * {@inheritdoc)
     */
    public function closest($hash, $attr, $val)
    {
        return $this->driver->closest($hash, $attr, $val);
    }

    /**
     * {@inheritdoc)
     */
    public function file($hash)
    {
        return $this->driver->file($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function dir($hash, $resolveLink = false)
    {
        return $this->driver->dir($hash, $resolveLink);
    }

    /**
     * {@inheritdoc)
     */
    public function scandir($hash)
    {
        return $this->driver->scandir($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function ls($hash)
    {
        return $this->driver->ls($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function tree($hash = '', $deep = 0, $exclude = '')
    {
        return $this->driver->tree($hash, $deep, $exclude);
    }

    /**
     * {@inheritdoc)
     */
    public function parents($hash, $lineal = false)
    {
        return $this->driver->parents($hash, $lineal);
    }

    /**
     * {@inheritdoc)
     */
    public function tmb($hash)
    {
        return $this->driver->tmb($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function size($hash)
    {
        return $this->driver->size($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function open($hash)
    {
        return $this->driver->open($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function close($fp, $hash)
    {
        $this->driver->close($fp, $hash);
    }

    /**
     * {@inheritdoc)
     */
    public function mkdir($dst, $name)
    {
        return $this->driver->mkdir($dst, $name);
    }

    /**
     * {@inheritdoc)
     */
    public function mkfile($dst, $name)
    {
        return $this->driver->mkfile($dst, $name);
    }

    /**
     * {@inheritdoc)
     */
    public function rename($hash, $name)
    {
        return $this->driver->rename($hash, $name);
    }

    /**
     * {@inheritdoc)
     */
    public function duplicate($hash, $suffix = 'copy')
    {
        return $this->driver->duplicate($hash, $suffix);
    }

    /**
     * {@inheritdoc)
     */
    public function upload($fp, $dst, $name, $tmpname)
    {
        return $this->driver->upload($fp, $dst, $name, $tmpname);
    }

    /**
     * {@inheritdoc)
     */
    public function paste($volume, $src, $dst, $rmSrc = false)
    {
        return $this->driver->paste($volume, $src, $dst, $rmSrc);
    }

    /**
     * {@inheritdoc)
     */
    public function getContents($hash)
    {
        return $this->driver->getContents($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function putContents($hash, $content)
    {
        return $this->driver->putContents($hash, $content);
    }

    /**
     * {@inheritdoc)
     */
    public function extract($hash)
    {
        return $this->driver->extract($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function archive($hashes, $mime)
    {
        $this->driver->archive($hashes, $mime);
    }

    /**
     * {@inheritdoc)
     */
    public function resize($hash, $width, $height, $x, $y, $mode = 'resize', $bg = '', $degree = 0)
    {
        return $this->driver->resize($hash, $width, $height, $x, $y, $mode, $bg, $degree);
    }

    /**
     * {@inheritdoc)
     */
    public function rm($hash)
    {
        return $this->driver->rm($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function search($q, $mimes)
    {
        return $this->driver->search($q, $mimes);
    }

    /**
     * {@inheritdoc)
     */
    public function dimensions($hash)
    {
        return $this->driver->dimensions($hash);
    }

    /**
     * {@inheritdoc)
     */
    public function getContentUrl($hash, $options = array())
    {
        return $this->driver->getContentUrl($hash, $options);
    }

    /**
     * {@inheritdoc)
     */
    public function getTempPath()
    {
        return $this->driver->getTempPath();
    }

    /**
     * {@inheritdoc)
     */
    public function getUploadTaget($baseTargetHash, $path, &$result)
    {
        return $this->driver->getUploadTaget($baseTargetHash, $path, $result);
    }

    /**
     * {@inheritdoc)
     */
    public function uniqueName($dir, $name, $suffix = ' copy', $checkNum = true)
    {
        return $this->driver->uniqueName($dir, $name, $suffix, $checkNum);
    }


    /**
     * All required methods we don't need as we are wrapping the driver.
     */

    protected function _dirname($path) {}
    protected function _basename($path) {}
    protected function _joinPath($dir, $name) {}
    protected function _normpath($path) {}
    protected function _relpath($path) {}
    protected function _abspath($path) {}
    protected function _path($path) {}
    protected function _inpath($path, $parent) {}
    protected function _stat($path) {}
    protected function _subdirs($path) {}
    protected function _dimensions($path, $mime) {}
    protected function _scandir($path) {}
    protected function _fopen($path, $mode = "rb") {}
    protected function _fclose($fp, $path = '') {}
    protected function _mkdir($path, $name) {}
    protected function _mkfile($path, $name) {}
    protected function _symlink($source, $targetDir, $name) {}
    protected function _copy($source, $targetDir, $name) {}
    protected function _move($source, $targetDir, $name) {}
    protected function _unlink($path) {}
    protected function _rmdir($path) {}
    protected function _save($fp, $dir, $name, $stat) {}
    protected function _getContents($path) {}
    protected function _filePutContents($path, $content) {}
    protected function _extract($path, $arc) {}
    protected function _archive($dir, $files, $name, $arc) {}
    protected function _checkArchivers() {}
}
