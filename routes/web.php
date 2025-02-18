<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormatohistoriaControler;

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/',function(){
        return view('formato.index');
});
/*Route::get('/formato',[FormatohistoriaControler::class,'index'])->name('formato.index');*/
