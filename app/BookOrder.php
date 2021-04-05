<?php
namespace  App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    protected $table = 'book_order';
    public function getOrderedAtLocalAttribute()
    {
        return (new Carbon($this->ordered_at))->timezone('Europe/Moscow');
        //return (new Carbon($this->ordered_at))->timezone(UserTimezoneController::getTimezone);
    }
}
