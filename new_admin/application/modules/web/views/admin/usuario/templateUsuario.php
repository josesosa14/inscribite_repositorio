<?phpif(isset($header)) {    $this->load->view("admin/usuario/".$header);}else {    $this->load->view("admin/general/header");}if(isset($menu)) {    $this->load->view("admin/general/".$menu);}else {    $this->load->view("admin/general/menu_default");}if(isset($vista)) {    $this->load->view("admin/usuario/".$vista);}else {    $this->load->view("admin/general/vista_default");}if(isset($footer)) {    $this->load->view("admin/usuario/".$footer);}else {    $this->load->view("admin/general/footer");}