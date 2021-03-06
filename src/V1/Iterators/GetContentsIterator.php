<?php

/**
 * Copyright (c) 2017-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   LocalFilesystem\V1\Iterators
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-filesystem-plugin-local
 */

namespace GanbaroDigital\LocalFilesystem\V1\Iterators;

use GanbaroDigital\AdaptersAndPlugins\V1\PluginTypes\PluginClass;
use GanbaroDigital\Filesystem\V1\Iterators\FilesystemContentsIterator;
use GanbaroDigital\Filesystem\V1\Iterators\RecursiveFilesystemContentsIterator;
use GanbaroDigital\Filesystem\V1\PathInfo;
use GanbaroDigital\LocalFilesystem\V1\LocalFilesystem;
use GanbaroDigital\MissingBits\ErrorResponders\OnFatal;
use RecursiveIterator;

/**
 * get an iterator for searching the local filesystem
 */
class GetContentsIterator implements PluginClass
{
    /**
     * get an iterator for searching the local filesystem
     *
     * @param  LocalFilesystem $fs
     *         our filesystem
     * @param  PathInfo $path
     *         where we want to search from
     * @param  OnFatal $onFatal
     *         what do we do if we cannot create the iterator?
     * @return RecursiveIterator
     *         the iterator to use
     */
    public static function for(LocalFilesystem $fs, PathInfo $path, OnFatal $onFatal) : RecursiveIterator
    {
        $contents = $fs->getFolder($path, $onFatal);
        $flags = FilesystemContentsIterator::KEY_AS_FULLPATH
               | FilesystemContentsIterator::CURRENT_AS_FILEINFO
               | FilesystemContentsIterator::SKIP_DOTS;
        return new RecursiveFilesystemContentsIterator($contents, $flags);
    }
}