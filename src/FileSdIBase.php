<?php

/**
 * Copyright (C) 2018 Taocomp s.r.l.s. <https://taocomp.com>
 *
 * This file is part of php-sdicoop-server.
 *
 * php-sdicoop-server is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-sdicoop-server is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-sdicoop-server.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Taocomp\Einvoicing\SdicoopServer;

class FileSdIBase
{
    public $NomeFile = null;
    public $File = null;

    public function __construct( \StdClass $parametersIn = null )
    {
        if ($parametersIn) {
            if (!property_exists($parametersIn, 'NomeFile')) {
                throw new \Exception("Cannot find property 'NomeFile'");
            }
            if (!property_exists($parametersIn, 'File')) {
                throw new \Exception("Cannot find property 'File'");
            }
        
            $this->NomeFile = $parametersIn->NomeFile;
            $this->File = $parametersIn->File;
            //$this->removeBOM();
        }
    }

    public function __toString()
    {
        return "NomeFile:{$this->NomeFile}";
    }

    public function import( $file)
    {
        if (false === is_readable($file)) {
            throw new \Exception("'$file' not found or not readable");
        }

        $this->NomeFile = basename($file);
        $this->File = file_get_contents($file);

        return $this;
    }

    /**
     * Remove UTF-8 BOM
     *
     * Credits: https://forum.italia.it/u/Francesco_Biegi
     * See https://forum.italia.it/t/risolto-notifica-di-scarto-content-is-not-allowed-in-prolog/5798/7
     */
    public function removeBOM()
    {
        $this->File = str_replace("\xEF\xBB\xBF", '', $this->File);

        return $this;
    }
}
