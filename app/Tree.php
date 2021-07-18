<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    protected $table = 'trees';

    protected $fillable = [
        'name', 'tree_id'
    ];

    public static function findNode($name)
    {
        // explode item name to array of nodes name
        $nodesNames = explode(' ', $name);

        // first node do not have parent node
        $parentId = null;
        $node = null;

        foreach ($nodesNames as $nodeName) {
            $node = Tree::firstOrCreate(
                ['tree_id' => $parentId, 'name' => $nodeName]
            );

            // parent's id for next node
            $parentId = $node->id;
        }

        return $node;
    }

    public function parent()
    {
        return $this->belongsTo('App\Tree');
    }

    public function children()
    {
        return $this->hasMany('App\Tree');
    }

    public function item()
    {
        return $this->hasOne('App\Item');
    }
}
