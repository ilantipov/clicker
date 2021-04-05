<?php

namespace App;

use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Order extends Model
{

    //protected $appends = ['is_ilya'];

    public function getIsIlyaAttribute()
    {
        return Str::of($this->attributes['buyer_name'])->upper() == 'ILYA';
    }

    public function setSomeTimeAttribute($value)
    {
        $this->attributes['some_time'] = (new Carbon($value, (new User())->getTimezone()))->setTimezone('UTC');
    }


    public function getCreatedAtLocalAttribute()
    {
        return (new Carbon($this->created_at))->timezone((new User())->getTimezone());
    }

    public function getOrderedAtLocalAttribute()
    {
        //dd($this->books()->withPivot('ordered_at'));
        return (new Carbon($this->books()->withPivot('ordered_at')->get()))->timezone((new User())->getTimezone());
    }

    public function show()
    {
        '<input name="total_in_dollars" type="text">';
    }
    public function showing(Request $request)
    {
        $order = new Order();
        $order->fill($request);
    }

    public function setTotalInCentAttribute($value)
    {
        $this->attributes['total_in_cent'] = $value;
    }

    public function setTotalInDollarsAttribute($value)
    {
        $this->attributes['total_in_cent'] = $value * 100;
    }


    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('ordered_at', 'paid');
    }
    /**
     * @var mixed|string
     */
//    public $byer_name;

    public function setBuyerNameAttribute($username)
    {
        $this->attributes['order_name'] = $username . ' ordered ' . $this->books()->count() . ' at ' . Carbon::now()->dayName;
        $this->attributes['buyer_name'] = $username;
    }



    public function authors()
    {
        return $this->hasOneThrough(Author::class, Book::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
