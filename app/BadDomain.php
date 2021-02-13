<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class BadDomain extends Model
{
    public function isBadDomain(string $url)
    {
        $host = parse_url($url, PHP_URL_HOST);

        if(!$host){
            return false;
        }

        if(strpos('www.', $url) === 0){
            $url = substr($url, 4);
        }

        return $this->whereDomain($url)->exists();
    }
}
