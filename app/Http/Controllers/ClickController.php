<?php


namespace App\Http\Controllers;


use App\BadDomain;
use App\Click;
use App\Http\Controllers\Api\jsonResponse;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ClickController
{
    use jsonResponse;
    const REDIRECT_NEW_CLICK = 'http://local.dev/succes/';
    const REDIRECT_EXISTING_CLICK = 'http://local.dev/error/';
    const REDIRECT_ON_ERROR = 'http://google.com';

    private $queryStringParams = ['param1', 'param2'];

    public function processClick(Request $request)
    {
        $redirectTo = '';
        $redirectMessage = '';

        try {
            $linkData = $this->makeLinkDataArray();

            $clickModel = (new Click())->getRow($linkData);

            if(!$clickModel){
                $clickModel->fill($linkData);
                $clickModel->save();
                $redirectTo = self::REDIRECT_NEW_CLICK . $clickModel->id;
                $redirectMessage = 'redirect_new';
            }
            else{
                $clickModel->increment('error');
                $clickModel->save();
                $redirectTo = self::REDIRECT_EXISTING_CLICK . $clickModel->id;
                $redirectMessage = 'redirect_existing';
            }

            if((new BadDomain())->isBadDomain($this->getReferer())){
                $clickModel->bad_domain = 1;
                $clickModel->increment('error');
                $clickModel->save();
            }

            $this->send_ok($redirectMessage, $redirectTo);


        }catch(Exception $exception){
            $this->throwJsonError($exception->getMessage(), self::REDIRECT_ON_ERROR);
        }
    }

    private function makeLinkDataArray(Request $request)
    {
        $clickDataArray = [
            'ua' => $request->userAgent(),
            'ip' => $request->ip(),
            'ref' => $this->getReferer(),
        ];

        $clickDataArray = array_merge($clickDataArray, $this->extractQueryParams());

        return $clickDataArray;
    }

    private function getReferer(Request $request)
    {
        return $_SERVER['HTTP_REFERER'] ?? '';
    }

    private function hashKey(array $keyArray)
    {
        sha1(implode($keyArray));
    }

    private function extractQueryParams(Request $request)
    {
        $queryParams = [];
        $requestParams   = $request->all();
        $requestSameCase = [];
        foreach ($requestParams as $key => $value) {
            $requestSameCase[strtolower($key)] = $value;
        }

        foreach ($this->queryStringParams as $paramName) {
            if (array_key_exists($paramName, $requestSameCase)) {
                $queryParams[] = $requestSameCase[$paramName];
            }
        }
        return $queryParams;
    }
}
