<?php

namespace swcprospect\model\entity;

/**
 * Tile is a cell of a given Planet grid at the (x, y) coordinates The type of the Tile is a
 * value from `tile_types`.
 */
class Tile
{
    private int $planetId;
    private int $x;
    private int $y;
    private EntityType $type;

    /**
     * Create a new Tile instance.
     *
     * @param int        $planetId ID of the planet the Tile is on.
     * @param int        $x        x coord of the Tile.
     * @param int        $y        y coord of the Tile.
     * @param EntityType $type     type ID of the Tile.
     *
     * @return void
     */
    public function __construct(int $planetId, int $x, int $y, EntityType $type,)
    {
        $this->planetId = $planetId;
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
    }

    /**
     * Get the value of planetId.
     *
     * @return int ID of the Planet this Tile belongs to.
     */
    public function getPlanetId(): int
    {
        return $this->planetId;
    }

    /**
     * Get the value of x.
     *
     * @return int x coordinate of this Tile.
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * Get the value of y.
     *
     * @return int y coordinate of this Tile.
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * Get the value of type.
     *
     * @return EntityType type of this Tile.
     */
    public function getType(): EntityType
    {
        return $this->type;
    }
}
