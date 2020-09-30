<?php

Route::match(['get', 'post'], '/{access}', 'GraphQLController@index');
