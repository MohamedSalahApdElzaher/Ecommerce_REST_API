<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
        'name'=>$this->name,
        'totalPrice' =>$this->getTotalPrice(),
        'rating'=>$this->getRating(),
        'href'=>[
            'reviews' => $this->getReview()
        ]
    ];

    }
    private function getTotalPrice()
    {
        return abs((1-$this->discount))/100 * $this->price;
    }

    private function getReview()
    {
        return route('products.show', $this->id);
    }

    private function getRating()
    {
        return $this->getReviews->count() > 0 ?
            $this->getReviews->sum('star')/$this->getReviews->count() : 'no reviews';
    }
}
