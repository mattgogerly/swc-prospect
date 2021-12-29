<?php

namespace swcprospect\view;

use swcprospect\model\entity\Deposit;

/**
 * View of a Deposit. Shows type and size, and buttons for update/delete.
 */
class DepositView
{
    /**
     * Render the DepositView.
     *
     * @param Deposit $deposit Deposit to display.
     *
     * @return string HTML of the view.
     */
    public function render(Deposit $deposit): string
    {
        ob_start();
        include('templates/deposit.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
