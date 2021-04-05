<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\OrderEditRequest;
use App\Order;
use Illuminate\Support\Facades\DB;
use App\Author;

use Composer\DependencyResolver\Request;
use function React\Promise\all;

class TestController
{
    public function ordersIndex()
    {
        //$orders = (new Order())->book()->author()->get();
        return view('orders', $orders);
    }


    public function orders(Request $request)
    {
        $order = new Order();
        //$order = $order->whereId(2);
        //$a = $order->book->author->name;
        //dd($order->book);
        $a = $order->with('book', 'book.author')->get();

        //dd($a);

        //dd($order->books()->authors()->get());
        return view('orders', ['items' => $a]);
    }

    public function list()
    {

        //return view('void',['query' => $query]);
        $items = Order::all();


        //$items  = Order::with('books', 'books.author', 'address')->whereId(1)->get();

        //return $items->toJson();


        return view('orders', ['items' => $items]);

        //$order = (new Order())->books()->get();

        //return view('orders', ['items' => $items]);
        //dd($books);
    }

    public function never()
    {
        $order = Order::all();
        $order = $order->where('book_id', 2)->first();
        return view('void');
    }


    public function fill()
    {
        $this->fillAuthors();
        $this->fillBooks();
        $this->fillOrders();
        $this->fillOrders();
        $this->fillOrders();
        $this->fillOrders();
        $this->fillOrders();
        $this->fillOrders();
        return view('orders', ['items' => Order::with('books', 'books.author')->get()]);
    }

    public function fillOrders()
    {
        //dd(Book::all());
//        $order = new Order();
//        $order->save();
//        $book1 = Book::whereName('Book1')->first();
//        //dd($book1);
//
//        $order->books()->attach($book1->id);

        $order = new Order();
        $order->save();
        $book2 = Book::whereName('Book2')->first();
        $book3 = Book::whereName('Book3')->first();

        $order->books()->attach([
            $book2->id => ['paid' => true],
            $book3->id => ['paid' => false],
        ]);
        $order->buyer_name = 'Ilya';
        $order->save();

//        $order = new Order();
//        $order->book_id = Book::whereName('Book2')->first()->value('id');
//        $order->save();
//        $order = new Order();
//        $order->book_id = Book::whereName('Book3')->first()->value('id');
//        $order->save();
    }

    private function fillBooks()
    {
        $book            = new Book();
        $book->name      = 'Book1';
        $book->author_id = Author::whereName('Name1')->first()->value('id');
        $book->save();
        $book            = new Book();
        $book->name      = 'Book2';
        $book->author_id = Author::whereName('Name2')->first()->value('id');
        $book->save();
        $book            = new Book();
        $book->name      = 'Book3';
        $book->author_id = Author::whereName('Name3')->first()->value('id');
        $book->save();
        //Author::whereName('Name1')->attach($book);
    }

    private function fillAuthors(): void
    {
        $author       = (new Author());
        $author->name = 'Name1';
        $author->save();
        $author       = (new Author());
        $author->name = 'Name2';
        $author->save();
        $author       = (new Author());
        $author->name = 'Name3';
        $author->save();
    }

    public function edit(OrderEditRequest $request, Order $order)
    {
        dd($order);

        return view('order.edit', ['item' => $order]);

        $book = Book::find(1);

        $image = $book->image; // Изображение книги

        $imageInstance = Image::find(1);

        $imageable = $imageInstance->imageable; // Модель, которая привязана к изображению



        echo $image;
        echo $imageable;

    }
}
