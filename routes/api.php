<?php

use Http\Routes\Route;

Route::delete('/api/qualification/delete', 'QualificationsController@delete')->name('api.qualifications-delete.store');