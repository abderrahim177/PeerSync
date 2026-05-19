<?php
class Review {
    private int $id;
    private int $rating;
    private string $comment;

    public function __construct(int $id , int $rating , string $comment)
    {
        $this->id = $id;
        $this->rating = $rating;
        $this->comment = $comment;
    }
    // getters

    public function getId() : int{
        return $this->id;
    }
    public function getRating() : int {
        return $this->rating;
    }
    public function getComment() : string {
        return $this->comment;
    }
    // setters

    public function setId() : int {
        return $this->id;
    }
    public function setRating() : int {
        return $this->rating;
    }
    public function setComment() : string {
        return $this->comment;
    }
}