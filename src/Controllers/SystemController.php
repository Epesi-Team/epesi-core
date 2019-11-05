<?php

namespace Epesi\Core\Controllers;

use Illuminate\Routing\Controller;
use Epesi\Core\System\SystemCore;
use Epesi\Core\HomePage\HomePageCommon;
use Epesi\Core\App as Epesi;
use Epesi\Core\System\SystemInstallWizard;
use Illuminate\Support\Facades\File;

class SystemController extends Controller
{
    public function index()
    {
    	return SystemCore::isInstalled()? redirect('home'): redirect('install');
    }
    
    public function install(Epesi $epesi)
    {
    	if (SystemCore::isInstalled()) return redirect('home');
    	
    	$epesi->title = config('epesi.app.title') . ' > ' . __('Installation');
    	
    	$epesi->initLayout('Centered');
    	
    	$epesi->add(new SystemInstallWizard());
    	
    	return $epesi->response();
    }
    
    public function home()
    {
    	return redirect(HomePageCommon::getUserHomePagePath());
    }
    
    public function logo()
    {
    	$path = storage_path(implode(DIRECTORY_SEPARATOR, ['app', 'public', 'system', 'logo.png']));

    	$file = new \Symfony\Component\HttpFoundation\File\File($path);
    	
    	return response(File::get($path), 200, ['Content-type' => $file->getMimeType()])->setMaxAge(604800)->setPublic();
    }
}
