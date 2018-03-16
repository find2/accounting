<?php
    class Book{
        public function Get_Book($name){
            if($name=='1')
                return "Operational MAA";
            else if($name=='2')
                return "Monarch Shop";
            else if($name=='3')
                return "Yayasan Lisensi";
            else if($name=='4')
                return "LSP LPK Monarch Bali";
            else if($name=='5')
                return "LSP PNI";
            else if($name=='6')
                return "Wisuda";
            else if($name=='7')
                return "Konsolidasi";
        }
    }
?>