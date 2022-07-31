<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'=>$this->name,
            'description'=>$this->details,
            'price'=>$this->price,
            'stock'=>$this->stock,
            'discount'=>$this->discount,
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
        return route('review.index', $this->id);
    }

    private function getRating()
    {
        return $this->getReviews->count() > 0 ?
            $this->getReviews->sum('star')/$this->getReviews->count() : 'no reviews';
    }
}
