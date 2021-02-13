<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Click extends Model
{

    private $indexKeys = ['ua', 'ip', 'ref', 'param1'];
    protected $fillable = ['ua', 'ip', 'ref', 'param1', 'param1', 'param2'];

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            $model->generateIndexKey();
        });
    }

    private function generateIndexKey() : void
    {
        $hashedString = $this->generateHashedIndexKeyFromArray($this->attributes);
        $this->attributes['id'] = $hashedString;
    }

    public function generateHashedIndexKeyFromArray(array $dataArray) : string
    {
        $stringToHash = '';

        foreach ($this->indexKeys as $key){
            $stringToHash .= $this->attributes[$key];
        }

        return $this->getHash($stringToHash);
    }

    private function getHash(string $stringToHash) : string
    {
        return  sha1($stringToHash);
    }

    public function getRow(array $clickData)
    {
        return $this->whereKey($this->generateHashedIndexKeyFromArray($clickData))->first();
    }

}
