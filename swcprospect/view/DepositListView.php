<?php

namespace swcprospect\view;

class DepositListView {

    public function render($deposits): string {
        ob_start();
        include('templates/deposit_list.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
}

?>