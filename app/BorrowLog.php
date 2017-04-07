<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BorrowLog extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['book_id', 'user_id', 'is_returned'];

    protected $casts = [
    'is_returned' => 'boolean',
    ];

    /**
     * BorrowLog belongs to Book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
    	// belongsTo(RelatedModel, foreignKey = book_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\Book');
    }

    /**
     * BorrowLog belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
    	// belongsTo(RelatedModel, foreignKey = user_id, keyOnRelatedModel = id)
    	return $this->belongsTo('App\User');
    }

    /**
     * Query scope .
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReturned($query)
    {
        return $query->where('is_returned', 1);
    }

    /**
     * Query scope .
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBorrowed($query)
    {
        return $query->where('is_returned', 0);
    }
}
