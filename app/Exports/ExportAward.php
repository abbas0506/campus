<?php

namespace App\Exports;

use App\Models\Course;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Collection;

class ExportAward implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $course_allocation = null;
    public function __construct($course_allocation)
    {
        $this->course_allocation = $course_allocation;
    }

    public function collection()
    {
        //
        $award = new Collection();

        if ($this->course_allocation->section->clas->program->level == 21) {
            //phd case row header
            $award->push((object)[
                'rollno' => 'Roll No',
                'name' => 'Name',
                'assignment' => 'Assignment 20%',
                'mid' => "Assignment 30%",
                'formative' => "Formative 50%",
                'summative' => "Summative 50%",
                'obt' => "Obtained",
                'gpa' => 'GPA',
                'grade' => 'Grade',

            ]);
            foreach ($this->course_allocation->first_attempts_sorted() as $first_attempt) {
                $award->push((object)[
                    'rollno' => $first_attempt->student->rollno,
                    'name' => $first_attempt->student->name,
                    'assignment' => $first_attempt->assignment,
                    'mid' => $first_attempt->mid,
                    'formative' => $first_attempt->formative(),
                    'summative' => $first_attempt->summative,
                    'obt' => $first_attempt->obtained(),
                    'gpa' => $first_attempt->gpa(),
                    'grade' => $first_attempt->grade(),

                ]);
            }
        } else {
            //header row
            $award->push((object)[
                'rollno' => 'Roll No',
                'name' => 'Name',
                'assignment' => 'Assignment 10%',
                'presentation' => "Prsentation 10%",
                'mid' => "Assignment 30%",
                'formative' => "Formative 50%",
                'summative' => "Summative 50%",
                'obt' => "Obtained",
                'gpa' => 'GPA',
                'grade' => 'Grade',

            ]);
            foreach ($this->course_allocation->first_attempts_sorted() as $first_attempt) {
                $award->push((object)[
                    'rollno' => $first_attempt->student->rollno,
                    'name' => $first_attempt->student->name,
                    'assignment' => $first_attempt->assignment,
                    'presentation' => $first_attempt->presentation,
                    'mid' => $first_attempt->mid,
                    'formative' => $first_attempt->formative(),
                    'summative' => $first_attempt->summative,
                    'obt' => $first_attempt->obtained(),
                    'gpa' => $first_attempt->gpa(),
                    'grade' => $first_attempt->grade(),

                ]);
            }
        }



        return $award;
    }
}
