<?php

namespace swcprospect\controller;

use swcprospect\model\DepositModel;
use swcprospect\model\entity\Deposit;
use swcprospect\model\entity\EntityType;
use swcprospect\view\DepositListView;
use swcprospect\view\DepositView;

/**
 * Controller for interacting with the singleton DepositModel.
 */
class DepositController
{
    private DepositModel $model;

    /**
     * Constructs an instance of DepositController.
     *
     * @param DepositModel $model model for Deposit entities, injected by DI.
     */
    public function __construct(DepositModel $model)
    {
        $this->model = $model;
    }

    /**
     * Renders a list of Deposits in table format.
     * @see Deposit
     * @see DepositListView
     *
     * @param int $planetId the planet to retrieve Deposits for.
     *
     * @return string list of Deposits in HTML table format.
     */
    public function depositListView(int $planetId): string
    {
        $deposits = $this->model->getByPlanet($planetId);
        $view = new DepositListView();
        return $view->render($deposits);
    }

    /**
     * Returns a Deposit as JSON, useful for JavaScript.
     * @see Deposit
     *
     * @param int $planetId the planet the Deposit is on.
     * @param int $x        the x coord of the Deposit.
     * @param int $y        the y coord of the Deposit.
     *
     * @return string JSON representation of the Deposit.
     */
    public function depositJson(int $planetId, int $x, int $y): string
    {
        return json_encode($this->model->getByPlanetCoord($planetId, $x, $y));
    }

    /**
     * Renders a Deposit in table format.
     * @see Deposit
     * @see DepositView
     *
     * @param int $planetId the planet the Deposit is on.
     * @param int $x        the x coord of the Deposit.
     * @param int $y        the y coord of the Deposit.
     *
     * @return string Deposit data in HTML table format.
     */
    public function deposit(int $planetId, int $x, int $y): string
    {
        $deposit = $this->model->getByPlanetCoord($planetId, $x, $y);
        $view = new DepositView();
        return $view->render($deposit);
    }

    /**
     * Persists a Deposit entity in the model.
     * @see Deposit
     *
     * @param int $planetId the planet the Deposit is on.
     * @param int $x        the x coord of the Deposit.
     * @param int $y        the y coord of the Deposit.
     * @param int $type     the type of the Deposit.
     * @param int $size     the size of the Deposit.
     */
    public function save(int $planetId, int $x, int $y, int $type, int $size): void
    {
        $deposit = new Deposit($planetId, $x, $y, new EntityType($type), $size);
        $this->model->save($deposit);
    }

    /**
     * Deletes a Deposit entity from the model.
     * @see Deposit
     *
     * @param int $planetId the planet the Deposit is on.
     * @param int $x        the x coord of the Deposit.
     * @param int $y        the y coord of the Deposit.
     */
    public function delete(int $planetId, int $x, int $y): void
    {
        $this->model->delete($planetId, $x, $y);
    }

        /**
     * Validates that the data provided when upserting a deposit is valid. Triggers a 400
     * response if a field is not valid.
     *
     * @param int $planetId the planet the Deposit is on.
     * @param int $x        the x coord of the Deposit.
     * @param int $y        the y coord of the Deposit.
     * @param int $size     the size of the Deposit.
     *
     * @return void
     */
    private function validateDepositData(?int $planetId, string $x, int $y, int $size): void
    {
        if (!is_numeric($planetId) || $planetId < 1) {
            trigger_error('400: Planet ID must be a positive integer');
        }

        if (!is_numeric($x) || $x < 0) {
            trigger_error('400: X coord must be an integer');
        }

        if (!is_numeric($x) || $x < 0) {
            trigger_error('400: Y coord must be an integer');
        }

        if (!is_numeric($size) || $size < 1) {
            trigger_error('400: Deposit size must be a positive integer');
        }
    }
}
