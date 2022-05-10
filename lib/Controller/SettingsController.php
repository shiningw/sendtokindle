<?php

namespace OCA\SendtoKindle\Controller;

use OCA\SendtoKindle\Helper;
use OCA\SendtoKindle\Settings;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;

class SettingsController extends Controller
{
    /*@ OC\AppFramework\Http\Request*/
    //private $request;

    //@config OC\AppConfig
    private $config;
    public function __construct($AppName, IRequest $Request, $UserId) //, IL10N $L10N)

    {
        parent::__construct($AppName, $Request);
        $this->UserId = $UserId;
        //$this->L10N = $L10N;
        $this->settings = new Settings($UserId);
        //$this->config = \OC::$server->getAppConfig();
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function getSettings()
    {
        $name = $this->request->getParam("name");
        $type = $this->request->getParam("type") ?? Settings::TYPE['USER'];
        $default = $this->request->getParam("default") ?? null;
        return new JSONResponse(Helper::getSettings($name, $default, $type));
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function save()
    {
        $params = $this->request->getParams();
        foreach ($params as $key => $value) {
            $resp = $this->saveSettings($key, $value);
        }
        return new JSONResponse($resp);
    }

    public function saveSettings($key, $value)
    {
        //key starting with _ is invalid
        if (substr($key, 0, 1) == '_') {
            return;
        }
        try {
            $this->settings->save($key, $value);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage(), "status" => false];
        }
        return ['message' => "Saved!", "status" => true];
    }
}
