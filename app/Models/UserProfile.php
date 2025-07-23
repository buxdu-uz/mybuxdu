<?php

namespace App\Models;

use App\Domain\Classifiers\Models\ClassifierOption;
use App\Domain\Departments\Models\Department;
use App\Domain\Specialities\Models\Speciality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $guarded = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function staff(): BelongsTo
    {
        return $this->BelongsTo(ClassifierOption::class,'h_staff_position','id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function gender(): BelongsTo
    {
        return $this->belongsTo(ClassifierOption::class,'h_gender','id');
    }

    public function academicDegree(): BelongsTo
    {
        return $this->belongsTo(ClassifierOption::class,'h_academic_degree','id');
    }
    public function academicRank(): BelongsTo
    {
        return $this->belongsTo(ClassifierOption::class,'h_academic_rank','id');
    }
    public function employmentForm(): BelongsTo
    {
        return $this->belongsTo(ClassifierOption::class,'h_employment_form','id');
    }
    public function employmentStaff(): BelongsTo
    {
        return $this->belongsTo(ClassifierOption::class,'h_employment_staff','id');
    }
    public function staffPosition(): BelongsTo
    {
        return $this->belongsTo(ClassifierOption::class,'h_staff_position','id');
    }
    public function employeeStatus(): BelongsTo
    {
        return $this->belongsTo(ClassifierOption::class,'h_employee_status','id');
    }
    public function employeeType(): BelongsTo
    {
        return $this->belongsTo(ClassifierOption::class,'h_employee_type','id');
    }
}
