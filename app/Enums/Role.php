<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case INSTRUCTOR = 'instructor';
    case STUDENT = 'student';
}