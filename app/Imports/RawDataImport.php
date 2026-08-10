<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class RawDataImport implements ToArray
{
    /**
     * @param array $array
     */
    public function array(array $array)
    {
        // This method is required by the ToArray interface
        // But Excel::toArray() actually just returns the array anyway.
    }
}
