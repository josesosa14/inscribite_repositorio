<?php
$router_completo = strtolower($this->router->fetch_class());
$router = explode("_controller", $router_completo);
$router = $router[0];
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <ul class="sidebar-menu">

            <li>
                <a href="<?= base_url() ?>decodificador">
                    <i class="fa fa-cog"></i>
                    <span>Decodificador</span>
                </a>
            </li>
            <li class="<?= (($router == 'cobro') ? 'active' : '') ?>">
                <a href="<?= base_url() ?>cobro">
                    <i class="fa fa-dollar"></i>
                    <span>Cobros</span>
                </a>
            </li>
            <!--<li class="<?= (($router == 'pago') ? 'active' : '') ?>">
                <a href="<?= base_url() ?>pagos">
                    <i class="fa fa-arrow-down"></i>
                    <span>Pagos</span>
                </a>
            </li>-->
            <li class="<?= (($router == 'liquidacion') ? 'active' : '') ?>">
                <a href="<?= base_url("liquidacion") ?>">
                    <i class="fa fa-arrow-down"></i>
                    <span>Liquidaciones</span>
                </a>
            </li>
            <!--<li class="<?= (($router == 'solicitudtransferencia') ? 'active' : '') ?>">
                <a href="<?= base_url() ?>solicitudtransferencia">
                    <i class="fa fa-money"></i>
                    <span>Solicitudes transferencia</span>
                </a>
            </li>-->
            <li class="treeview <?= (($router == 'reporte') ? 'active' : '') ?>">
                <a href=>
                    <i class="fa fa-cog"></i>
                    <span>VARIOS</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= (($router == 'cliente') ? 'active' : '') ?>">
                        <a href="<?= base_url() ?>cliente">
                            <i class="fa fa-bookmark"></i>
                            <span>Clientes</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url("reporte-estado-cuenta-cliente") ?>">
                            <i class="fa  fa-file-excel-o"></i>
                            Estado cuenta clientes
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url("rep-mi-estado-cuenta") ?>">
                            <i class="fa  fa-file-excel-o"></i>
                            Mi estado de cuenta
                        </a>
                    </li>

                    <li class="<?= (($router == 'variables') ? 'active' : '') ?>">
                        <a href="<?= base_url() ?>variables">
                            <i class="fa fa-bookmark"></i>
                            <span>Variables</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview <?= (($router == 'reporte') ? 'active' : '') ?>">
                <a href=>
                    <i class="fa  fa-file"></i>
                    <span>EPSA</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?= base_url("admin-listadifusion") ?>">
                            <i class="fa  fa-list"></i>
                            Listas Difusión
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url("mailing") ?>">
                            <i class="fa  fa-envelope"></i>
                            Mailing
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url("admin-guardavida") ?>">
                            <i class="fa fa-user"></i>
                            <span>Guardavida</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url("admin-tipoatributo") ?>">
                            <i class="fa fa-cog"></i>
                            <span>Tipoatributo</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url("admin-atributo") ?>">
                            <i class="fa fa-list"></i>
                            <span>Atributo</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>

</aside>