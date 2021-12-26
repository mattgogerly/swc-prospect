<?php

namespace swcprospect\view;

/**
 * List of Deposits in a table. Shows type and size.
 */
class DepositListView {
    
    /**
     * Render the DepositListView.
     *
     * @param array $deposits Deposits to list.
     * 
     * @return string HTML of the view.
     */
    public function render(array $deposits): string {
        ob_start();
        include('templates/deposit_list.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
}

?>