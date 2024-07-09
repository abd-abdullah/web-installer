<?php

namespace Abdullah\WebInstaller\Controllers;

use Illuminate\Routing\Controller;
use Abdullah\WebInstaller\Events\LaravelInstallerFinished;
use Abdullah\WebInstaller\Helpers\EnvironmentManager;
use Abdullah\WebInstaller\Helpers\FinalInstallManager;
use Abdullah\WebInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param  \Abdullah\WebInstaller\Helpers\InstalledFileManager  $fileManager
     * @param  \Abdullah\WebInstaller\Helpers\FinalInstallManager  $finalInstall
     * @param  \Abdullah\WebInstaller\Helpers\EnvironmentManager  $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
