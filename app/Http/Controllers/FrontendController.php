<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Language;
use App\Models\System;

class FrontendController extends Controller
{
    protected $language=1;
    protected $systemRepository;
    protected $system;

    public function __construct(
        // SystemRepository $systemRepository
    ){

        $this->setLanguage();
        $this->setSystem();

    }

    public function setLanguage(){
        $locale = app()->getLocale(); 
        $language = Language::where('canonical', $locale)->first();
        $this->language = $language->id;
    }

    public function setSystem()
    {
        $this->system = convert_array(System::where('language_id', 1)->get(), 'keyword', 'content');
    }
}
