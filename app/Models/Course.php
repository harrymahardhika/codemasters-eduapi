<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Course
 *
 * @method static CourseFactory  factory($count = null, $state = [])
 * @method static Builder|Course newModelQuery()
 * @method static Builder|Course newQuery()
 * @method static Builder|Course onlyTrashed()
 * @method static Builder|Course query()
 * @method static Builder|Course whereCode($value)
 * @method static Builder|Course whereCreatedAt($value)
 * @method static Builder|Course whereCredits($value)
 * @method static Builder|Course whereDeletedAt($value)
 * @method static Builder|Course whereDepartment($value)
 * @method static Builder|Course whereDescription($value)
 * @method static Builder|Course whereEnrollmentLimit($value)
 * @method static Builder|Course whereFee($value)
 * @method static Builder|Course whereId($value)
 * @method static Builder|Course whereInstructor($value)
 * @method static Builder|Course whereLocation($value)
 * @method static Builder|Course whereTitle($value)
 * @method static Builder|Course whereUpdatedAt($value)
 * @method static Builder|Course withTrashed()
 * @method static Builder|Course withoutTrashed()
 *
 * @mixin \Eloquent
 *
 * @property int         $id
 * @property string      $title
 * @property string      $description
 * @property string      $code
 * @property int         $credits
 * @property string      $instructor
 * @property string      $department
 * @property string      $location
 * @property int         $enrollment_limit
 * @property float       $fee
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'code',
        'credits',
        'instructor',
        'department',
        'location',
        'enrollment_limit',
        'fee',
    ];

    protected $casts = [
        'fee' => 'float',
    ];
}
