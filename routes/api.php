<?php

use Http\Routes\Route;

Route::delete('/api/qualification/delete', 'QualificationsController@delete')->name('api.qualifications-delete.store');

Route::delete('/api/academic-background/delete', 'AcademicBackgroundsController@delete')->name('api.academic-backgrounds-delete.store');

Route::delete('/api/work-experience/delete', 'WorkExperiencesController@delete')->name('api.work-experiences-delete.store');