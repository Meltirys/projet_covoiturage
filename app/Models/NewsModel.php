<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Elément du tutoriel CodeIgniter laissé comme pense-bête
 */
class NewsModel extends Model
{
    protected $table = 'news';

    protected $allowedFields = ['title', 'slug', 'body'];

    /**
     * Function getNews will fetch news from the database. If a slug is included, fetches only the row where that slug is. Otherwise, fetches every row.
     * 
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
