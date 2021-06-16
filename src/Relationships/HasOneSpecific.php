<?php

namespace CMAndersen\HasOneSpecific\Relationships;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class HasOneSpecific extends Relation
{
    /**
     * The ID of the related model
     *
     * @var int|string
     */
    protected $id;

    /**
     * Key for target
     *
     * @var string
     */
    protected $foreignKey;

    /**
     * HasOneSpecific constructor.
     *
     * @param int|string $id
     */
    public function __construct(Builder $query, Model $parent, $foreignKey, $id)
    {
        $this->id = $id;
        $this->query = $query;
        $this->parent = $parent;
        $this->foreignKey = $foreignKey;

        parent::__construct($query, $parent);
    }

    public function addConstraints()
    {
        $this->query->where($this->foreignKey, '=', $this->id);
    }

    public function addEagerConstraints(array $models)
    {
        $this->addConstraints();
    }

    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newInstance());
        }

        return $models;
    }

    public function match(array $models, Collection $results, $relation)
    {
        if ($results->isEmpty()) {
            return $models;
        }

	    $keyParts = explode( '.', $this->foreignKey );
	    $primaryKey = end( $keyParts );

        foreach ($models as $model) {
            $model->setRelation(
                $relation,
                $results->firstWhere($primaryKey, '=', (string) $this->id)
            );
        }

        return $models;
    }

    public function getResults()
    {
        return $this->query->first();
    }
}
