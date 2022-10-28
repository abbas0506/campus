<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportStudent implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Student([
            //
            'rollno' => $row['rollno'],
            'regno' => $row['regno'],
            'name' => $row['name'],
            'father' => $row['father'],
            'gender' => $row['gender'],

            //root status
            'section_id' => session('section_id'),

        ]);
    }
}
