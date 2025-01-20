<?php

use App\Http\Routes\Route;

Route::delete('/api/document/delete', 'DocumentsController@delete')->name('api.documents-delete.store');

Route::delete('/api/qualification/delete', 'QualificationsController@delete')->name('api.qualifications-delete.store');

Route::delete('/api/academic-background/delete', 'AcademicBackgroundsController@delete')->name('api.academic-backgrounds-delete.store');

Route::delete('/api/work-experience/delete', 'WorkExperiencesController@delete')->name('api.work-experiences-delete.store');

Route::delete('/api/department/delete', 'DepartmentsController@delete')->name('api.departments-delete.store');

Route::delete('/api/official-position/delete', 'OfficialPositionsController@delete')->name('api.official-positions-delete.store');