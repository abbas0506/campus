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
        $roman = config('global.romans');
        $award = new Collection();

        $award->push((object)[
            '', '',
            'University of Okara',
            '',
            'Award Sheet'
        ]);

        $award->push((object)[
            'Department',
            $this->course_allocation->section->clas->program->department->name,
            '', '', '', '',
            'Session',
            $this->course_allocation->section->clas->session(),
        ]);
        $award->push((object)[
            'Porgram',
            $this->course_allocation->section->clas->program->name,
            '', '',
            'Semester',
            $roman[$this->course_allocation->section->clas->semesterNo($this->course_allocation->semester_id) - 1],
            'Section',
            $this->course_allocation->section->name,

        ]);

        $award->push((object)[
            'Course',
            $this->course_allocation->course->name,
            '', '',
            'Code',
            $this->course_allocation->course->code,
            'Cr. Hr',
            $this->course_allocation->course->lblCr(),

        ]);

        $award->push((object)[
            '',
        ]);
        //if PhD course
        if ($this->course_allocation->section->clas->program->level == 21) {
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
