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
            '',
            '',
            'University of Okara',
            '',
            'Award Sheet'
        ]);

        $award->push((object)[
            'Department',
            $this->course_allocation->section->clas->program->department->name,
            '',
            '',
            '',
            '',
            'Session',
            $this->course_allocation->section->clas->session(),
        ]);
        $award->push((object)[
            'Porgram',
            $this->course_allocation->section->clas->program->name,
            '',
            '',
            'Semester',
            $roman[$this->course_allocation->section->clas->semesterNo($this->course_allocation->semester_id) - 1],
            'Section',
            $this->course_allocation->section->name,

        ]);

        $award->push((object)[
            'Course',
            $this->course_allocation->course->name,
            '',
            '',
            'Code',
            $this->course_allocation->course->code,
            'Cr. Hr',
            $this->course_allocation->course->lblCr(),

        ]);

        $award->push((object)[
            '',
        ]);
        // Fresh
        //if PhD course
        if ($this->course_allocation->section->clas->program->level == 21) {
            $award->push((object)[
                'rollno' => 'Roll No',
                'name' => 'Name',
                'mid' => "Mid 20%",
                'assignment' => 'Assignment 20%',
                'formative' => "Formative 50%",
                'summative' => "Summative 50%",
                'obt' => "Obtained",
                'gpa' => 'GPA',
                'grade' => 'Grade',

            ]);
            foreach ($this->course_allocation->first_attempts_active() as $first_attempt) {
                $award->push((object)[
                    'rollno' => $first_attempt->student->rollno,
                    'name' => $first_attempt->student->name,
                    'mid' => $first_attempt->midterm,
                    'assignment' => $first_attempt->assignment,
                    'formative' => $first_attempt->formative(),
                    'summative' => $first_attempt->summative,
                    'obt' => $first_attempt->obtained(),
                    'gpa' => $first_attempt->gpa(),
                    'grade' => $first_attempt->grade(),

                ]);
            }
        } else {
            //BS, MS case: header row
            $award->push((object)[
                'rollno' => 'Roll No',
                'name' => 'Name',
                'mid' => "Mid 30%",
                'quiz1' => "Quiz 10%",
                'assignment' => 'Assignment 10%',
                'formative' => "Formative 50%",
                'quiz2' => "Quiz 10%",
                'summative' => "Summative 40%",
                'total_summative' => "Total Summative 50%",
                'obt' => "Obtained",
                'gpa' => 'GPA',
                'grade' => 'Grade',

            ]);
            foreach ($this->course_allocation->first_attempts_active() as $first_attempt) {
                $award->push((object)[
                    'rollno' => $first_attempt->student->rollno,
                    'name' => $first_attempt->student->name,
                    'mid' => $first_attempt->midterm,
                    'quiz1' => $first_attempt->quiz1,
                    'assignment' => $first_attempt->assignment,
                    'formative' => $first_attempt->formative(),
                    'quiz2' => $first_attempt->quiz1,
                    'summative' => $first_attempt->summative,
                    'total_summative' => $first_attempt->summative(),
                    'obt' => $first_attempt->obtained(),
                    'gpa' => $first_attempt->gpa(),
                    'grade' => $first_attempt->grade(),

                ]);
            }

            $award->push((object)[
                'Reappearing *',
            ]);

            // reappearing students data
            $award->push((object)[
                'rollno' => 'Roll No',
                'name' => 'Name',
                'mid' => "Mid 30%",
                'quiz1' => "Quiz 10%",
                'assignment' => 'Assignment 10%',
                'formative' => "Formative 50%",
                'quiz2' => "Quiz 10%",
                'summative' => "Summative 40%",
                'total_summative' => "Total Summative 50%",
                'obt' => "Obtained",
                'gpa' => 'GPA',
                'grade' => 'Grade',

            ]);
            foreach ($this->course_allocation->reappears_sorted() as $reappear) {
                $award->push((object)[
                    'rollno' => $reappear->first_attempt->student->rollno,
                    'name' => $reappear->first_attempt->student->name,
                    'mid' => $reappear->midterm,
                    'quiz1' => $reappear->quiz1,
                    'assignment' => $reappear->assignment,
                    'formative' => $reappear->formative(),
                    'quiz2' => $reappear->quiz2,
                    'summative' => $reappear->summative,
                    'total_summative' => $reappear->summative(),
                    'obt' => $reappear->total(),
                    'gpa' => $reappear->gpa(),
                    'grade' => $reappear->grade(),

                ]);
            }
        }

        return $award;
    }
}
