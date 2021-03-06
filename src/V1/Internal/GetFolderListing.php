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
 * @package   LocalFilesystem\V1\Internal
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2017-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-filesystem-plugin-local
 */

namespace GanbaroDigital\LocalFilesystem\V1\Internal;

use FilesystemIterator;
use GanbaroDigital\Filesystem\V1\PathInfo;
use GanbaroDigital\Filesystem\V1\TypeConverters;
use GanbaroDigital\LocalFilesystem\V1\LocalFileInfo;
use GanbaroDigital\MissingBits\ErrorResponders\OnFailure;

/**
 * what's in a given folder?
 */
class GetFolderListing
{
    /**
     * what's in a given folder?
     * @param  string|PathInfo $fullPath
     *         the folder we want to look inside
     * @param  OnFailure $onFailure
     *         what to do if we can't look inside the folder
     * @return array
     *         the folder's contents, as a string of filenames, or
     *         whatever $onFailure returns otherwise
     */
    public static function from($fullPath, OnFailure $onFailure) : array
    {
        // what are we looking at?
        $pathInfo = TypeConverters\ToPathInfo::from($fullPath);

        // can we make an iterator?
        try {
            $iterator = new FilesystemIterator($pathInfo->getFullPath());
        }
        catch (\Exception $e) {
            return $onFailure($pathInfo->getPrefixedPath(), $e->getMessage());
        }

        // what's in the folder?
        $retval = [];
        foreach ($iterator as $fileInfo) {
            $filename = $fileInfo->getFilename();
            $retval[] = $filename;
        }

        // all done
        return $retval;
    }
}