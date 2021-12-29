<?php

namespace swcprospect\model\entity;

use JsonSerializable;

/**
 * Deposit is a record of a deposit of a raw material found at an (x, y) coordinate on a
 * given Planet. The type of the Deposit is a value from `deposit_types`.
 */
class Deposit implements JsonSerializable
{
    private int $planetId;
    private int $x;
    private int $y;
    private EntityType $type;
    private int $size;

    /**
     * Create a new Deposit instance.
     *
     * @param int        $planetId ID of the planet the Deposit is on.
     * @param int        $x        x coord of the Deposit.
     * @param int        $y        y coord of the Deposit.
     * @param EntityType $type     type ID of the Deposit.
     * @param int        $size     size of the Deposit.
     *
     * @return void
     */
    public function __construct(int $planetId, int $x, int $y, EntityType $type, int $size)
    {
        $this->planetId = $planetId;
        $this->x = $x;
        $this->y = $y;
        $this->type = $type;
        $this->size = $size;
    }

    /**
     * Get the value of planetId.
     *
     * @return int ID of the Planet this Deposit belongs to.
     */
    public function getPlanetId(): int
    {
        return $this->planetId;
    }

    /**
     * Get the value of x.
     *
     * @return int x coordinate of this Deposit.
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * Get the value of y.
     *
     * @return int y coordinate of this Deposit.
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * Get the value of type.
     *
     * @return EntityType type of this Deposit.
     */
    public function getType(): EntityType
    {
        return $this->type;
    }

    /**
     * Get the value of size.
     *
     * @return int size of this Deposit.
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Serialize this Deposit as JSON.
     *
     * @return mixed JSON representation of this Deposit.
     */
    public function jsonSerialize(): mixed
    {
        return [
            'planetId' => $this->planetId,
            'x' => $this->x,
            'y' => $this->y,
            'type' => $this->type,
            'size' => $this->size,
        ];
    }
}
