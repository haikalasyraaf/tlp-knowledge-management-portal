<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingEvaluation\TrainingEvaluationDefaultQuestion;

class TrainingEvaluationDefaultQuestionSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            'Objective' => [
                'Individual session objectives were fully explained throughout the course.',
                'The defined course and session objectives were consistently met.',
            ],
            'Activities' => [
                'The purpose of course excercises (group discussions, role-plays etc.) was always clearly explained',
                'The range of activities used throughout the programmed (group discussions, role-plays, excercises etc.) were always relevant and appropriate.',
                'After each activity appropriate time was allocated to identifying and discussing the lessons learned.',
                'The activities used made the course more interesting and interactive.',
                'The range of activities used throughout the program (group discussions, role-plays, excercises etc.) helped to enhance the learning experience.',
            ],
            'Material' => [
                'The course materials were well-written, organized, and easy to understand.',
            ],
            'Program Facilities' => [
                'The room used for the course was bright, spacious, quiet and enhanced the learning process.',
                'Equipment such as projectors, flipcharts etc. were of high quality and in good working order.',
                'The quality of food and beverages offered throughout the course was high and the timings of service were appropriate.'
            ],
            'Program Outcomes' => [
                'The course has provided me with new ways of thinking about my role/job.',
                'I would recommend this program to my colleagues and peers.',
                'How relevant and helpful do you think it was for your job?'
            ],
        ];

        foreach ($questions as $category => $items) {
            foreach ($items as $text) {
                TrainingEvaluationDefaultQuestion::create([
                    'question_category' => $category,
                    'question_text'     => $text,
                    'question_type'     => 'scale',
                ]);
            }
        }
    }
}