<?php
if (!isset($data)) {
    $data = "";
}
$ruta = "";

if (isset($header)) {
    $this->load->view($ruta . $header);
} else {
    $this->load->view($ruta . "web/general/header");
}

if (isset($vista)) {
    $this->load->view($ruta . $vista, $data);
} else {
    $this->load->view($ruta . "general/vista_default", $data);
}



if (isset($footer)) {
    $this->load->view($ruta . $footer);
} else {
    $this->load->view($ruta . "web/general/footer");
}
?>

</body>
</html>

