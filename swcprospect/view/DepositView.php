<?php

namespace swcprospect\view;

class DepositView {

    public function render($deposit): string {
        ob_start();
        include('templates/deposit.php');
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
}

?>