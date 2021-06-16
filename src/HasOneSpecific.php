<?php

namespace CMAndersen\HasOneSpecific;

use Illuminate\Database\Eloquent\Model;
use CMAndersen\HasOneSpecific\Relationships\HasOneSpecific as Relation;

trait HasOneSpecific {
	public function hasOneSpecific($related, $id, $foreignKey = null)
	{
		/* @var Model $instance */
		$instance = new $related();

		$foreignKey = $foreignKey ?: $instance->getQualifiedKeyName();

		return new Relation($instance->newQuery(), $this, $foreignKey, $id);
	}
}